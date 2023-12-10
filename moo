#!/usr/bin/env php
<?php

use Saphpi\Core\Database;
use Saphpi\Core\Application;

require_once __DIR__ . '/psr4_autoloader.php';

$env = parse_ini_file('.env');
if ($env === false) {
    die('Failed to load .env file');
}

$app = new Application(new Database(
    Database::MYSQL,
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_USERNAME'],
    $env['DB_PASSWORD'],
    $env['DB_SCHEMA'],
));

$app->prompt()->resolve();
