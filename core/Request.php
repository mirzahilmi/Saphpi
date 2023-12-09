<?php
namespace Saphpi\Core;

class Request {
    private ?string $path;
    private ?string $method;
    private ?array $body;

    public function __construct() {
        $this->path = @$this->assignPath();
        $this->method = @$this->assignMethod();
        $this->body = @$this->assignBody();
    }

    public function getPath(): ?string {
        return $this->path;
    }

    public function getMethod(): ?string {
        return $this->method;
    }

    public function getBody(): ?array {
        return $this->body;
    }

    public function assignPath(): ?string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $queryStringPos = strpos($path, '?');
        if ($queryStringPos === false) {
            return $path;
        }

        $path = substr($path, 0, $queryStringPos);
        return $path;
    }

    public function assignMethod(): ?string {
        return $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    public function assignBody(): ?array {
        $body = [];

        $method = $this->assignMethod();
        if ($method === 'GET') {
            foreach ($_GET as $key => $_) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } elseif ($method === 'POST' || $method === 'PUT' || $method === 'PATCH' || $method === 'DELETE') {
            foreach ($_POST as $key => $_) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
