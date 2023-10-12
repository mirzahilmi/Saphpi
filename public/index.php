<?php

require_once __DIR__.'/../vendor/autoload.php';

use Saphpi\Application;
use Saphpi\Controller\TestController;

$app = new Application(dirname(__DIR__));

$app->router->get('/foo', function() {
    return 'Hello World';
});
$app->router->get('/', 'index');
$app->router->post('/login', '');
$app->router->get('/foo', [TestController::class, 'index']);
$app->router->get('/bar', function() {
    return '<h1>Hello There</h1>';
});

$app->run();
