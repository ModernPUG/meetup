<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Slim\Slim;
$view = new Pug\Example\Simple($app);

// Request전체를 보고자 할때.
$app->get("/status", [$view, 'showStatus']);
$app->post("/status", [$view, 'showStatus']);
$app->put("/status", [$view, 'showStatus']);
$app->delete("/status", [$view, 'showStatus']);


// 일반적인 상황의 로그인과 로그아웃
$app->post('/login', [$view, 'normalLogin']);
$app->get('/me', [$view, 'normalMe']);


// 크로스 도메인의 경우 로그인과 로그아웃 (세션 분리)
$app->post('/cors/login', [$view, 'corsLogin']);
$app->get('/cors/me', [$view, 'corsMe']);


$app->run();