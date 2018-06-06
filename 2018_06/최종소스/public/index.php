<?php
declare(strict_types=1);

use ExampleApp\HelloWorld;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//container를 만들어 주는 ContainerBuilder란 놈이 있다
$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    HelloWorld::class => \DI\create(HelloWorld::class)
        ->constructor(\DI\get('Foo'), \DI\get('Response')),
    'Foo' => 'bar',
    'Response' => function() {
        return new Response();
    },
]);
//container를 만든다
$container = $containerBuilder->build();

//middleware + dispatcher
$routes = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
    $r->get('/hello', HelloWorld::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
$emitter->emit($response);
