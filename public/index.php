<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Saphpi\Application;

$env = parse_ini_file('../.env');
if ($env === false) {
    die('Failed to load .env file');
}

$app = new Application(dirname(__DIR__));

$app->router()->get('/', 'index');

$app->run();
