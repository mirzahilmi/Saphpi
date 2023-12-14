<?php
namespace Saphpi\Core;

class Response {
    public function setHttpStatus(int $code): void {
        http_response_code($code);
    }

    public function redirect(string $path): void {
        header("Location: $path");
    }

    public function withFlash(mixed $value, string $key = 'message'): void {
        Application::session()->flash($value, $key);
    }
}
