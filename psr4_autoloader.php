<?php
spl_autoload_register('psr4Autoload');

function psr4Autoload($class) {
    $classPath = str_replace('\\', '/', $class);
    $namespaceArr = explode('/', $classPath);
    array_splice($namespaceArr, 0, 1);
    switch ($namespaceArr[0]) {
        case 'Controllers':
            $namespaceArr[0] = 'controllers';
            break;
        case 'Rules':
            $namespaceArr[0] = 'rules';
            break;
        case 'Models':
            $namespaceArr[0] = 'models';
            break;
        case 'Middlewares':
            $namespaceArr[0] = 'middlewares';
            break;
        case 'Exceptions':
            $namespaceArr[0] = 'exceptions';
            break;
        default:
            $namespaceArr[0] = 'core';
    }
    $namespace = implode('/', $namespaceArr);

    $root = __DIR__;
    $filePath = "$root/$namespace.php";
    if (file_exists($filePath)) {
        require $filePath;
    }
}
