<?php
spl_autoload_register('psr4Autoload');

const AUTOLOAD = [
    'Saphpi\\Core\\'        => 'core/',
    'Saphpi\\Controllers\\' => 'controllers/',
    'Saphpi\\Rules\\'       => 'rules/',
    'Saphpi\\Models\\'      => 'models/',
    'Saphpi\\Middlewares\\' => 'middlewares/',
    'Saphpi\\Exceptions\\'  => 'exceptions/',
];

function psr4Autoload($class) {
    $classNamespace = str_replace(array_keys(AUTOLOAD), array_values(AUTOLOAD), $class, $count);
    if ($count === 0) {
        throw new Exception("Cannot find $class class");
    }
    $classPath = str_replace('\\', '/', $classNamespace);

    $root = __DIR__;
    $filePath = "$root/$classPath.php";
    if (file_exists($filePath)) {
        require $filePath;
    }
}
