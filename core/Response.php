<?php
namespace Saphpi;

class Response {
    public static function setHttpStatus(int $code): void {
        http_response_code($code);
    }
}
