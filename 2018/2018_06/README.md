#  Modern PHP Without a Framework


## Modern PHP?

>이 글은 아래의 내용들을 참고하여 작성하였습니다.
>- [PHP THE RIGHT WAY](http://modernpug.github.io/php-the-right-way/)
>- [2016 GDG Incheon 8월 전창완님 발표자료](http://wani.kr/posts/2016/08/10/modern-php/)
>- [Modern PHP(도서)](http://www.hanbit.co.kr/store/books/look.php?p_code=B8778782784)
>- [ModernPUG wiki - 모던의 의미](http://www.modernpug.org/wiki/%EB%AA%A8%EB%8D%98%EC%9D%98-%EC%9D%98%EB%AF%B8)

라고 말씀하신 권윤학님의 [[ PHP ] Modern PHP 란?](http://web-front-end.tistory.com/75)을 참고하자


## Modern PHP Without a Framework

이 코스는 Kevin Smith의 [Modern PHP Without a Framework](https://kevinsmith.io/modern-php-without-a-framework)이라는 글을 토대로 합니다.

많은 Modern PHP Framework은 몇가지 공통 요소를 제공합니다.
- Front Controller
- Autoloading(PSR-4)
- Package Managing
- Dependency Injection
- Middleware
- Routing
- 등등 

네, 더 있겠지만 이 정도로 만족합시다.

이 요소들을 하나씩 추가해 볼 생각입니다.

## Front Controller

<img src="https://miro.medium.com/fit/c/240/240/1*dGKzs3DwBr4Bb_VJK2CQZw.jpeg" width="50" alt="Hyunseok Lee profile image" /> said...

> 프런트 컨트롤러 패턴은 웹 애플리케이션으로 오는 모든 리소스 요청을 처리해주는 하나의 진입점(예를 들면 index.php)을 두는 패턴입니다. 이 패턴은 많은 웹 프레임워크에서 MVC 패턴과 함께 사용됩니다.

(이 분이 Front Controller란 용어를 만드신 건 아닙니다만...)

#### Document Root

보통 웹서버는 project root 내의 document root라고 불리곤 하는 별도의 디렉토리를 기준으로 서비스 합니다.

Document root가 public이란 디렉토리이고, 이 안에 다음과 같은 파일 구조가 있다면,

```
public/
    index.php 
    modern/people.php
    assets/logo.png
```

이렇게 서비스 되겠죠

```
http://my-domain.kr/index.php
http://my-domain.kr/modern/people.php
http://my-domain.kr/assets/logo.png
```

#### Front Controller 하나를 만들어 봅니다.

Project root 아래 document root로 사용할 public이란 디렉토리를 만듭니다.

그 public이란 디렉토리 아래 index.php란 파일 하나를 만듭니다.

```php
<?php
declare(strict_types=1);

echo 'Hello, world!';
```

`declare(strict_types=1);` 이건 무슨 구문인가 싶죠?

[declare strict mode](http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration.strict)
- strict mode가 선언된 파일에서의 함수 호출과 리턴 시 타입 체크
- 함수 선언 위치와는 관계 없음
- PHP7.0 이상
- 반드시 파일의 가장 상단에 설정해야 함

#### 서버를 띄워 볼까요?

Project root에서,

```bash
php -S localhost:8080 -t public/
```

확인해봅시다!

http://localhost:8080/


## Autoloading (PSR-4)


겁나 먼 왕국에서는...

다른 PHP 파일에서 기능이나 설정을 가져오기 위해
- 특정 기능을 사용할 때마다 상단에 include 하고
- 파일 명이 바뀌거나 사용하지 않을 때, 모든 include 구문을 찾아 수정/제거해야 하고
- 두번 가져오지 않게 하기 위해 require_once로 바꾸고
- 이렇게는 못살겠다 싶어, 모든 기능을 function.php에 넣고, 이걸 항상 include 하고
- 그러다 관리할 게 늘어나면 function.php와 config.php를 common.php에 넣고
- 그렇게 또 하루 멀어저 가고 

### Autoloading 

[PSR-0](https://www.php-fig.org/psr/psr-0/)(X), [PSR-4](https://www.php-fig.org/psr/psr-4/)(O)

[Composer](https://getcomposer.org/)를 설치합니다

```bash
composer init
```

인터렉티브하게 계속 뭘 물어봅니다.

만약 git 프로젝트라면 마지막에 (composer로 설치되는 모듈이 위치할) vendor 디렉토리를 .gitignore에 추가하겠느냐고 물어보기도 하죠.

그냥 대충 끝내고 자동 생성된 composer.json 파일에 아래 내용을 입력해도 됩니다.
우리가 이 시간에 설치할 라이브러리를 포함하고 있습니다.

```json
{
    "name": "you/no-framework",
    "description": "An example of a modern PHP application bootstrapped without a framework.",
    "type": "project",
    "require": {
        "php-di/php-di": "^6.0",
        "relay/relay": "2.x@dev",
        "zendframework/zend-diactoros": "^1.7",
        "middlewares/fast-route": "^1.0",
        "middlewares/request-handler": "^1.1"
    },
    "autoload": {
        "psr-4": {
            "ExampleApp\\": "src/"
        }
    }
}
```

이 시간에는 처음부터 차근차근 진행하겠습니다.

autoload 설정을 추가해볼까요?

```json
{
    "name": "you/no-framework",
    "description": "An example of a modern PHP application bootstrapped without a framework.",
    "type": "project",
    "require": {
    },
    "autoload": {
        "psr-4": {
            "ExampleApp\\": "src/"
        }
    }
}
```

autoload 설정이 보이시죠?

> ExampleApp이란 namespace를 쓰면 자동으로 src에서 찾아 로드하겠다!

아래 구문을 실행해볼까요?

```bash
composer install
```

`composer install`을 하면 
- composer.json의 require에 기술한 의존성 라이브러리가 설치됩니다
- composer.json의 autoload에 명시된 규칙대로 autoload.php를 생성합니다
  
이제 autoload.php를 사용하면 우리가 만든 클래스도 자동으로 불러올 수 있습니다.

아까는 index.php에서 "Hello"라고 인사를 했지만, 이제 역할을 좀 바꿔볼 거예요.

- index.php : FrontController의 기능만 담당합니다
- HelloWorld.php : "Hello"라고 인사를 하는 클래스를 새로 만들 겁니다.

Project root에 src라는 디렉토리를 만들고 HelloWorld.php를 만들어 봅시다.

```php
<?php
declare(strict_types=1);

namespace ExampleApp;

class HelloWorld
{
    public function announce(): void
    {
        echo 'Hello, autoloaded world!';
    }
}
```

index.php에서 이 클래스를 불러다 씁니다.

```php
<?php
declare(strict_types=1);

use ExampleApp\HelloWorld;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$helloWorld = new HelloWorld();
$helloWorld->announce();

```

확인 : http://localhost:8080/

## Dependency Injection

저 소스를 보면 HelloWorld 클래스를 바로 new 해서 인스턴스를 생성하죠?

HelloWorld 클래스는 index.php가 아닌 다른 곳에서도 쓰일 수 있지만,

index.php는 HelloWorld가 없이는 살아갈 수 없습니다.

이런 상황을 `index.php가 HelloWorld 클래스에 의존하고 있다`라고 합니다.

의존성 주입이란 의존 관계를 외부로부터 주입 받는 것을 말합니다.

우선 외부로부터 무언가를 주입 받는 상황을 살펴봅시다.

DB 연결을 해야하는 클래스를 예로 들어볼게요.

```php
class AwesomeClass
{
    public function doSomethingAwesome()
    {
        $dbConnection = new \PDO(
            "{$_ENV['type']}:host={$_ENV['host']};dbname={$_ENV['name']}",
            $_ENV['user'],
            $_ENV['pass']
        );
        
        // Make magic happen with $dbConnection
    }
}
```

환경 변수에서 값을 가져와서 매번 PDO 객체를 만들어 사용하고 있어요.

이때 AwesomeClass는 PDO에 의존하고 있다고 이야기 합니다.

이 구문은 다른 클래스에서도, 동일한 구문으로, 수도 없이 반복될 겁니다.

이번엔 PDO 객체를 외부로부터 주입받아 봅니다.

```php
class AwesomeClass
{
    private $dbConnection;

    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function doSomethingAwesome()
    {        
        // Make magic happen with $this->dbConnection
    }
}
```

생성자로 PDO 객체를 받아와서 반복되고 지저분한 코드는 사라졌습니다.

그럼 누군가 한번은 그 더러운 작업을 해야하지 않느냐고요?

맞아요. 그래서 프레임웍에서는 Dependency Injection 컨테이너(혹은 IoC 컨테이너)를 사용합니다.

의존성이 필요하면 컨테이너에서 가져온다라고 생각하면 쉬워요.


혹시...

조금 더 깊이 들어가고 싶다면 다른 관점에서도 이야기 하고 싶어요.

사실 이 코드를 `의존성 주입`의 예라고 할 수 있는지에 대해선 논란이 좀 있습니다.

AwesomeClass는 PDO란 객체를 외부에서 받았지만, 의존 관계가 외부에서 주입된 건 아니거든요.

즉, 이미 코드 상에서 PDO를 쓰겠다고 선언되었으니, 의존 관계는 주입되지 않고 이미 성립되었다라고 보시면 됩니다.

어쨌든 이제부터 소위 `DI 컨테이너`를 사용할 것이고, DI 개념에 대해 아주 정확하게 이야기하진 않을 것입니다. 

#### The Dependency Injection Container

이런 DI 컨테이너는 여러 종류가 있지만, 우리는 [PHP-DI](http://php-di.org/)를 사용할 겁니다.

```bash
composer require php-di/php-di
```

composer.lock이라는 파일이 생겼고, vendor 하위에는 php-di 관련 디렉토리가 생겼습니다.

index.php에 php-di에 관한 설정을 하고 HelloWorld 클래스를 DI 컨테이너로 받아올 겁니다.

index.php

```php
use ExampleApp\HelloWorld;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//container를 만들어 주는 ContainerBuilder란 놈이 있다
$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    HelloWorld::class => \DI\create(HelloWorld::class)
]);
//container를 만든다
$container = $containerBuilder->build();

//before
//$helloWorld = new HelloWorld();
//after
$helloWorld = $container->get(HelloWorld::class);
$helloWorld->announce();
```

이제 DI container를 사용할 준비가 됐습니다.

index.php가 의존성을 `주입` 받았다고 할 수는 없지만,

이 코스의 마지막에는 HelloWorld 클래스가 container를 통해 의존성을 주입받는 모습을 보게 될 겁니다!  

## Middleware

<img src="https://www.slimframework.com/docs/v3/images/middleware.png" width="400px" alt="middleware in and out image">

외부에서 들어온 요청이 여러 레이어를 거쳐 앱에 도달하고, 
앱에서 처리한 결과가 다시 이 레이어를 거쳐 돌아나와 클라이언트에 전달이 됩니다.

공통의 요청/응답 동작을 application layer 밖에서 처리하기 위해, HTTP middleware를 사용하곤 합니다.

[PSR-15: HTTP Server Request Handlers](https://www.php-fig.org/psr/psr-15/)에는 middleware와 request handler를 위한 interface를 정의하고 있습니다.

```php
interface RequestHandlerInterface
{
    /**
     * Handles a request and produces a response
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
```

Request handler interface에선 ServerRequestInterface를 구현한 request 객체를 인자로 받아 
뭔가 처리하고 response를 내보내는 역할

```php
interface MiddlewareInterface
{
    /**
     * Process an incoming server request
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}
```

MiddlewareInterface는 RequestHandlerInterface와 비슷하지만, 스스로 response를 생성할 수 없을 때 두번째 인자로 받은 request handler로 response를 생성할 수 있습니다.

무슨 말인지 모르겠다면, 라우팅을 통해 더 알아봅시다.

## Routing

위에서 이런 식의 URL을 보셨죠?

```
http://my-domain.kr/modern/people.php
```

> [Cool URIs don't change](https://www.w3.org/Provider/Style/URI)

(PHP 개발자는 구하기 어렵다는 이유로) JAVA로 서비스하기로 했다면,

이미 널리 퍼진 `/modern/people.php`란 URL은 어떻게 해야할까요?

애초에 URI는 추상적으로 정의했어야지요!

`/modern/people`까지를 리소스로 정의하고,

이렇게 요청이 들어오면 `/modern/people.php`로 연결해주겠다고 정의하면 됩니다.

추상적인 URI에 특정 동작을 매핑해주는 것을 라우팅이라고 합니다.  

이를 middleware로 처리해보겠습니다.

#### The Middleware Dispatcher

Middleware는 함수처럼 input과 output이 있을 뿐 스스로 실행하지 못합니다.

Dispatcher는 여럿 등록된 middleware를 순서대로 실행해주는 역할을 합니다.

여기서는 dispatcher로 [Relay](https://github.com/relayphp/Relay.Relay)를 사용하기로 합니다.

Relay 역시 RequestHandlerInterface를 implements하고 있습니다.

```bash
composer require relay/relay:2.x@dev
```

PSR-15에서 middleware와 request handler는 PSR-7에서 정의된 request를 받아 response로 응답을 넘겨주도록 되어 있습니다. 

[PSR-7: HTTP message interfaces](https://www.php-fig.org/psr/psr-7/)

따라서 [zend-diactoros](https://github.com/zendframework/zend-diactoros)라는 PSR-7 구현체도 사용하겠습니다.

```bash
composer require zendframework/zend-diactoros
```

Middleware를 배열에 담고, dispatcher가 이들을 차례로 실행하는 구조로 만들어 볼 겁니다.

index.php를 수정할게요.

```php
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;

// ...

$container = $containerBuilder->build();

//middleware + dispatcher
$middlewareQueue = [];

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());
```

Relay는 내부에 $middlewareQueue를 갖게 되고, 이를 하나씩 실행할 것입니다.

Relay가 RequestHandlerInterface를 구현했다는 사실을 기억하시나요?

따라서 handle에 Request 객체(PSR-7)를 만들어 넘겨주면, Response 객체가 돌아올 겁니다.

지금은 아무것도 안하고 있지만요.

#### 본격 middleware 추가

Router로 사용할 [FastRoute](https://github.com/nikic/FastRoute)를 설치하겠습니다.

```bash
composer require middlewares/fast-route middlewares/request-handler
```

예제에서는 [middlewares/request-handler](https://github.com/middlewares/request-handler)도 같이 설치했습니다.

위에서 언급한 RequestHandlerInterface와는 별개로 생각해주세요.

FastRoute는 요청이 유효한지, 그 요청이 어떻게 핸들링 되어야 할지 정해주는 역할만 한다면,

request-handler는 라우터에서 정해준 콜백이나 클래스를 실행해줍니다.

이렇게 두 단계로 나누면, 중간에 또 다른 middleware를 넣는 등 더 유연한 구조로 만들 수 있습니다.

라우팅을 정의한 후, 이 두 middleware를 추가하겠습니다.

```php
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

// ...

$container = $containerBuilder->build();

//middleware + dispatcher
$routes = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
    $r->get('/hello', HelloWorld::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler();

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

//이제 필요없다
//$helloWorld = $container->get(HelloWorld::class);
//$helloWorld->announce();
```

HelloWorld를 직접 호출하던 소스를 지웠습니다.

`/hello`라고 요청이 들어오면 `HelloWorld` 클래스에 보내라고 라우팅을 정의했고

request-handler middleware는 `HelloWorld` 클래스를 실행하게 될 겁니다.

그러나,

클래스는 함수처럼 바로 실행을 할 수 없지요.

대신 클래스 인스턴스를 함수처럼 실행하려고 할 때,

클래스 안의 [__invoke](http://php.net/manual/kr/language.oop5.magic.php#object.invoke)라는 magic method가 실행됩니다.

HelloWorld 클래스를 callable하게 바꿔봅시다.

```php
class HelloWorld
{
    public function __invoke(): void
    {
        echo 'Hello, autoloaded world!';
        exit;
    }
}
```

(exit 해버린 게 마음에 안 들어도 조금만 참아주세요)

이제 라우팅을 설정했으니 `/hello`로 접근해봅시다.

확인 : http://localhost:8080/hello

## 하나로 묶기

#### DI container

DI 컨테이너를 아직 활용하지 않았습니다.

이제 생성자에 $foo라는 값을 받아들이고, 이를 화면에 보여주도록 바꾸겠습니다.

```php
class HelloWorld
{
    private $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }

    public function __invoke(): void
    {
        echo "Hello, {$this->foo} world!";
        exit;
    }
}
```

지금은 당연히 문제가 생기겠죠?

생성자에 문자열을 넘길 수 있게 index.php에서 수정해봅시다.

before :

```php
$containerBuilder->addDefinitions([
    \ExampleApp\HelloWorld::class => \DI\create(\ExampleApp\HelloWorld::class)
]);
```

after : 

```php
$containerBuilder->addDefinitions([
    HelloWorld::class => \DI\create(HelloWorld::class)
        ->constructor(\DI\get('Foo')),
    'Foo' => 'bar'
]);
```

constructor에서 사용할 값도 container에 등록했습니다. `'Foo' => 'bar'`

이렇게 만들어진 container는 어디서 필요할까요?

```php
$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler();
```

FastRoute에는 `/hello`라고 들어올 때 HelloWorld 클래스를 사용하라고 지정만 했고,

실제 HelloWorld 클래스를 생성하는 것은 RequestHandler쪽입니다.

RequestHandler 클래스 안에 [이 컨테이너를 사용하는 곳](https://github.com/middlewares/request-handler/blob/master/src/RequestHandler.php#L53)이 있습니다.

container를 RequestHandler에 전달해줍니다.

```php
$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);
```

확인 : http://localhost:8080/hello

#### Response 

이제 응답을 제대로 처리해봅시다. HelloWorld에선 그냥 exit 해서 끝내버렸죠.

이전에 middleware가 양파처럼 app을 감싸고 있는 모습을 봤는데요.

request가 app으로 넘어갈 때 이를 중간에 수정할 수도 있고,
app의 실행 결과를 response에 담에 클라이언트에 전달되기 전에 중간에서 수정할 수도 있습니다.

PSR-7에서는 Request 뿐 아니라 Response Interface도 정의하고 있습니다.

위에서 MiddlewareInterface가 ServerRequestInterface 구현체를 받아 ResponseInterface를 리턴하는 모습을 보셨을 겁니다. 

HelloWorld가 Response Interface의 구현체를 넘기도록 만들어 봅니다.

```php
use Psr\Http\Message\ResponseInterface;

class HelloWorld
{
    private $foo;

    private $response;

    public function __construct(
        string $foo,
        ResponseInterface $response
    ) {
        $this->foo = $foo;
        $this->response = $response;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body><h1>Hello, {$this->foo} world!</h1></body></html>");

        return $response;
    }
}
```

response라는 객체를 DI container로부터 받아

client에 리턴할 html을 그 response에 쓰고 리턴합니다.

이 reponse를 받는 어떤 middleware에서 이를 수정할 수도 있겠죠?

이 코드가 잘 동작하려면,

DI container에 reponse 객체를 등록해야 합니다.

```php
// ...

use Zend\Diactoros\Response;

// ...

$containerBuilder->addDefinitions([
    HelloWorld::class => \DI\create(HelloWorld::class)
        ->constructor(\DI\get('Foo'), \DI\get('Response')),
    'Foo' => 'bar',
    'Response' => function() {
        return new Response();
    },
]);

$container = $containerBuilder->build();

// ...
```

짠. 

확인 : http://localhost:8080/hello



아무것도 안 보이는데, 아무것도 안했기 때문입니다.

index.php를 다시 볼까요?

웹서버는 PHP 엔진에게 index.php를 실행하라고 시켰고,

router에서 /hello 요청에 대해 HelloWorld라는 클래스를 선택했고,

그 실행 결과를 Response에 담아두기까지 했습니다.



클라이언트에 응답을 보내기 위해서는, 웹서버와 app 사이에 emitter라는 게 필요합니다.

Zend Diactoros엔 SapiEmitter라는, Response를 전달하는 emitter 기능도 포함돼 있습니다.

SAPI(Server API)는 PHP와 웹서버 간의 인터페이스를 의미합니다.

header(), echo(), printf(), var_dump(), var_export()... 모두 서버로 결과물을 방출해주는 녀석들입니다.

index.php를 마지막을 아래와 같이 고쳐볼게요.

```php
use Zend\Diactoros\Response\SapiEmitter;

// ...

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
$emitter->emit($response);
```

Response를 서버에게 emit하고, 

확인 : http://localhost:8080/hello

## 결론

Modern PHP framework에서 보통 어떤 기능을 제공해주는지 살펴봤습니다.

저는 그냥 프레임웍을 쓰기로 했으니, 모두 안녕!

