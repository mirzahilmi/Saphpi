<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Saphpi\Database;
use Saphpi\Application;
use Saphpi\Controllers\TestController;

$env = parse_ini_file('../.env');
if ($env === false) {
    die('Failed to load .env file');
}

$app = new Application(dirname(__DIR__), new Database(
    Database::MYSQL,
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_USERNAME'],
    $env['DB_PASSWORD'],
    $env['DB_DATABASE']
));

$app->router->get('/foo', function () {
    return 'Hello World';
});
$app->router->get('/', 'index');
$app->router->post('/login', '');
$app->router->get('/bar', function () {
    return '<h1>Hello There</h1>';
});
$app->router->get('/index', [TestController::class, 'login']);
$app->router->get('/form', [TestController::class, 'handleLogin']);

$app->run();
