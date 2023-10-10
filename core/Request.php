<?php
namespace Saphpi;

class Request {
    public function getPath(): string {
        $path = $_SERVER['REQUEST_URI'];
        
        $queryStringPos = strpos($path, '?');
        if ($queryStringPos === false) {
            return $path;
        }

        $path = substr($path, $queryStringPos);
        return $path;
    }
}