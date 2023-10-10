<?php
namespace Saphpi;

class Request {
    public function getPath(): string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $queryStringPos = strpos($path, '?');
        if ($queryStringPos === false) {
            return $path;
        }

        $path = substr($path, 0, $queryStringPos);
        return $path;
    }

    public function getMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
