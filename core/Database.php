<?php
namespace Saphpi\Core;

class Database {
    public static ?\PDO $db;

    private function __construct() {}

    public static function connect(
        string $dsn,
        string $username,
        string $password,
    ) {
        self::$db = new \PDO($dsn, $username, $password);
    }
}
