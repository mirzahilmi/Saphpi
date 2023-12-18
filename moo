#!/usr/bin/env php
<?php

use Saphpi\Core\Prompt;

require_once __DIR__ . '/psr4_autoloader.php';

define('ROOT', __DIR__);

$cli = new Prompt();
$cli->resolve();
