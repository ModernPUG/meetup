## Faker 패키지를 활용한 의미있는 테스트 데이타 만들기

- 발표 자료중 코드 부분을 Markdown 으로 옮겼습니다.
- 발표 자료는 [여기](https://github.com/ModernPUG/meetup/blob/master/2015_09/03_PHP_Faker/PHP-Fake.pdf)에서 다운 받으세요. 

### 설치 

```sh
composer require fzaninotto/faker 
```

## 사용
### 기본 사용법

 1. Faker\Factory::create() 로 Faker 객체 생성
 2. 생성된 객체의 property 를 호출하면 Faker 데이타가 생성됨
 3. property 는 생성할 데이타의 종류(Ex: name, address, phoneNumber)


```php
<?php

require_once ‘vendor/autoload.php'; 

$faker = Faker\Factory::create(); 

// generate data by accessing properties 
echo $faker->name;  
echo $faker->address;
echo $faker->text;
```
### 사용자 정보 생성
```php
public function testUserCreate()
    {
        $faker = Faker\Factory::create();
	   
        $user = [
            'id' => $faker->randomNumber($nbDigits = NULL), 
            'name' => $faker->name($gender = 'female'),
            'country' =>$faker->country,
            'address' => $faker->address,
            'phoneNumber' => $faker->phoneNumber,
            'company' => $faker->company,
            'birthDay' => $faker->dateTimeBetween('-50 years', '-20 years'),
            'email' => $faker->email, // safeEmail,freeEmail, etc..
            'homePage' => $faker->url,
            'creditCardType' => $faker->creditCardType,
            'creditCardNumber' => $faker->creditCardNumber,
        ];

        dump($user);
    }
```

### 첨부 파일 정보 생성
```php
public function testAttachmentCreate()
    {
        $faker = Faker\Factory::create();
       
        $attachment = [
            'id' => $faker->randomNumber($nbDigits = NULL), 
            'user_id' => $faker->numberBetween($min = 1000, $max = 9000), 
            'mimeType' => $faker->mimeType, 
            'size' => (1024 * $faker->numberBetween($min = 12345678, $max = 987654321)),
            'path' => $faker->file($srcDir = '.' , $destDir = 'storage', $fullPath = false),
        ];

        dump($attachment);
    }

```

## Laravel 과 연동

### Model Factory 정의
database/factories/ModelFactory.php 에 생성할 팩토리 정보 기술
```php
$factory->define(App\Author::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        ‘country' => $faker->country,
        ‘birthDay' => $faker->dateTimeBetween('-50 years', '-20 years'),
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
```
### Faker Model 생성
두 번째 파라미터는 생성할 모델의 갯수
```php
factory('App\Author‘, 5)->make();
```

### Persisting Factory Models
- make() 는 모델을 생성만 하고 DB 에 입력하지 않음
- 입력이 필요하면 create() 사용

```php
factory('App\Author‘, 5)->create();
```


## 참고 자료 :

 - PHP Faker : https://github.com/fzaninotto/Faker/
 - Laravel Model Factory : http://laravel.com/docs/5.1/testing#modelfactories
 - 발표자 블로그 : https://lesstif.com/pages/viewpage.action?pageId=26084077


