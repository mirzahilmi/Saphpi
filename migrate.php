<?php

use Saphpi\Database;

require_once __DIR__ . '/vendor/autoload.php';

$env = parse_ini_file('.env');
if ($env === false) {
    die('Failed to load .env file');
}

$db = new Database(
    Database::MYSQL,
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_USERNAME'],
    $env['DB_PASSWORD'],
    $env['DB_DATABASE']
);

$db->establishConnection();

$migrations = scandir('migrations');
array_splice($migrations, 0, 2);
foreach ($migrations as $migration) {
    $content = file_get_contents("migrations/$migration");
    if ($content === false) {
        die("Failed to read $migration file");
    }

    if ($db->conn()->exec($content) === false) {
        die("Failed to run $migration migration");
    }
}
