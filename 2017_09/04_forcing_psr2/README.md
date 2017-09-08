# PSR-2 강제하기
Composer, Git hook, phpcs를 활용하여 모든 팀원이 PSR-2을 강제로 지키도록 해봅시다. 커밋을 하는 중에 어떠한 출력이라도 있는 경우 커밋이 취소 되는 점을 활용한 방법입니다.

- pre-commit에는 PSR-2 준수 여부를 검사하는 스크립트를 작성합니다.
- `composer install`을 실행하면 pre-commit 파일을 .git/hooks에 자동으로 복사되도록 합니다.

원문은 [여기](http://tech.zumba.com/2014/04/14/control-code-quality/)에서 확인할 수 있습니다.

## 실습용 프로젝트 만들기

```
~$ mkdir psr2
```

## PHPCS 설치

PSR 준수 여부를 검사하는 PHPCS를 설치합니다.

```sh
~/psr2$ composer require squizlabs/php_codesniffer
```

## Git 저장소 생성

Git Hook을 쓰기 위해 Git 저장소를 만듭니다. Git Hook은 Git에서 어떤 동작이 발생했을 때 지정한 스크립트를 실행할 수 있도록 하는 것입니다.

```sh
~/psr2$ git init
```

## Git pre-commit 작성

Git으로 커밋을 하기 전에 PSR-2 준수 여부를 검사하는 코드를 작성합니다. 파일은 프로젝트 루트 디렉터리에 저장합니다.

```sh
#!/bin/sh

vendor/bin/phpcs src --standard=psr2
```

`src` 디렉터리를 검사하도록 설정했습니다.

## Composer 스크립트 작성

나 뿐만 아니라 동료 모두가 PSR-2를 지키도록 하는 것이 목적입니다. 따라서, 컴포저를 이용하여 부지불식간에 PSR-2를 지키지 않으면 커밋을 할 수 없게 만듭니다.

다음과 같이 post-install-cmd에 스크립트를 작성합니다.

```json
{
    "require": {
        "squizlabs/php_codesniffer": "^3.0"
    },
    "scripts": {
        "post-install-cmd": [
            "cp pre-commit .git/hooks/pre-commit",
            "chmod +x .git/hooks/pre-commit"
        ]
    }
}
```

이제 composer install 이 실행되면 pre-commit 파일이 git hook 디렉터리에 복사되고 (cp pre-commit .git/hooks/pre-commit), 실행 가능하도록 설정됩니다.(chmod +x .git/hooks/pre-commit)

## 테스트

PSR-2를 위반하는 코드를 작성해서 `src` 디렉터리에 저장합니다.

```php
// 파일 위치 /src/test.php

<?php
function cannotCommit(){
    echo "You activated my trap card.";
}
```

커밋을 시도합니다.

```sh
git add .
git commit -m "나에겐 나만의 스타일이 있다";
```

커밋 되지 않고 아래와 같이 나오면 성공.

```
FILE: /Users/leehyunseok/psr2/src/test.php
----------------------------------------------------------------------
FOUND 1 ERROR AFFECTING 1 LINE
----------------------------------------------------------------------
 2 | ERROR | [x] Opening brace should be on a new line
----------------------------------------------------------------------
PHPCBF CAN FIX THE 1 MARKED SNIFF VIOLATIONS AUTOMATICALLY
----------------------------------------------------------------------

Time: 93ms; Memory: 4Mb
```

2번째 줄에 에러가 있는데, 여는 중괄호는 새로운 줄에 써야한다는 규칙을 어겼다는 내용입니다.

## 동료에게 전달하기
Git으로 아래 파일들을 공유하면 됩니다.

- composer.json
- composer.lock
- pre-commit
