<?php
namespace Saphpi\Core;

class MySQL {
    public static \mysqli $db;

    private function __construct() {}

    public static function connect(
        string $username,
        string $password,
        string $schema,
        int $port = 3306,
        string $host = '127.0.0.1',
    ): void {
        self::$db = new \mysqli(
            $host,
            $username,
            $password,
            $schema,
            $port,
        );
    }
}
