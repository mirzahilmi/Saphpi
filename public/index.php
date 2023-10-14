<?php

require_once __DIR__.'/../vendor/autoload.php';

use Saphpi\Application;
use Saphpi\Controllers\TestController;

$app = new Application(dirname(__DIR__));

$app->router->get('/foo', function() {
    return 'Hello World';
});
$app->router->get('/', 'index');
$app->router->post('/login', '');
$app->router->get('/bar', function() {
    return '<h1>Hello There</h1>';
});
$app->router->get('/index', [TestController::class, 'login']);
$app->router->get('/form', [TestController::class, 'handleLogin']);

$app->run();
