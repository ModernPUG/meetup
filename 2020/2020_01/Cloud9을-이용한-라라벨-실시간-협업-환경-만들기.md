# Cloud9을 이용한 라라벨 실시간 협업 환경 만들기

## AWS Cloud9

<img src="https://d1.awsstatic.com/product-marketing/Tulip/C9-Collab-Image@3x.e03a65d9488633c154358430540ab363dd1e8f45.png">

- 동명의 서비스를 AWS가 인수
- 웹 기반 IDE
- 실시간 협업 코딩 - 마치 구글 드라이브의 문서 도구처럼!
- 서버리스 구축을 위한 도구 지원
- 서울 리전 사용 가능

## 시작하기

`AWS Console` -> `개발자 도구` -> `Cloud9` -> 우상단의 `Create environment` 클릭  
환경 이름을 잘 지어준 후 `Next Step`  

### 환경 선택

- Create a new instance for environment (EC2)  
   신규 EC2 서버를 생성하고 Cloud9 환경을 구성합니다
- Connect and run in remote server (SSH)  
   이미 운영중인 서버에 SSH 연결 설정을 합니다

### 인스턴스 타입

- t2.micro (1 GiB RAM + 1 vCPU)  
   T2 타입에 대한 프리티어가 남아있다면 프리티어 적용이 가능한 인스턴스 타입입니다
- t3.small (2 GiB RAM + 2 vCPU)  
   작은 규모의 웹 프로젝트에 추천한다고 합니다
- m5.large (8 GiB RAM + 2 vCPU)  
   실제 프로덕션으로 이용할 수 있다고 합니다
- Other instance type  
   직접 원하는 타입을 선택합니다

### 플랫폼

- Amazon Linux  
   PHP의 경우 5.6을 지원합니다.
- Ubuntu Server 18.04 LTS  
   PHP의 경우 7.2를 지원합니다.  
**어차피 sudo 권한을 주기 때문에 입맛에 맞게 세팅을 변경할 수 있습니다.**

### 비용 절감 세팅

일정 시간 이상 미사용시 최대 절전 모드로 들어갈 수 있도록 하는 옵션입니다.  
T시리즈 인스턴스를 선택해도 최대 절전 모드가 지원됩니다 (!!)


## 설정

### t2.micro 타입일 경우 스왑 메모리 설정

```bash
sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1
```

### 익스텐션 설치

```bash
sudo apt-get install php7.2-mbstring php7.2-xml
```

### 라라벨 설치

```bash
composer create-project laravel/laravel laravel --prefer-dist
```

### 라라벨 디렉토리 권한 설정

```bash
chmod -R 777 laravel/storage
chmod -R 777 laravel/bootstrap/cache/
```

### 아파치 설정 변경

```bash
sudo vim /etc/apache2/ports.conf
```
```diff
- Listen 80
+ Listen 8080
```

```
sudo vim /etc/apache2/sites-enabled/000-default.conf
```
```diff
- <VirtualHost *:80>
+ <VirtualHost *:8080>
...
- DocumentRoot /var/www/html
+ DocumentRoot /home/ubuntu/environment/laravel/public
```

```
sudo vim /etc/apache2/apache2.conf
```
```diff
- <Directory /var/www>
+ <Directory /home/ubuntu/environment/laravel>
```

### 아파치 재시작

```
sudo service apache2 restart
```

## IAM 계정 설정

공동 작업을 위해서 IAM 계정을 생성합니다.  
생성되는 IAM 계정은 다음 권한 중 하나가 필요합니다.

- AWSCloud9Administrator
- AWSCloud9EnvironmentMember
- AWSCloud9User

### IAM 사용자 초대

Cloud9 IDE 상의 `Share` 버튼을 통해 IAM 사용자 초대

## 활용 방안

- 협력사 작업용 환경으로 제공 가능
- 교육용으로 활용 가능
- 짝코딩시 이용 가능
- 비상용 혹은 여행용으로 아이패드 개발환경 구축 가능
