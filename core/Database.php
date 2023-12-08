<?php
namespace Saphpi\Core;

class Database {
    private ?\PDO $connection;

    public const MYSQL = 'mysql:host=%s;port=%d;dbname=%s';
    public const POSTGRESQL = 'pgsql:host=%s;port=%d;dbname=%s';

    private readonly string $driver;
    private readonly string $host;
    private readonly string $port;
    private readonly string $username;
    private readonly string $password;
    private readonly string $databaseName;

    public function __construct(
        string $driver,
        string $host,
        string $port,
        string $username,
        string $password,
        string $databaseName
    ) {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->databaseName = $databaseName;
    }

    public function establishConnection() : void {
        try {
            $this->connection = new \PDO(
                sprintf(
                    $this->driver,
                    $this->host,
                    $this->port,
                    $this->databaseName
                ),
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public function closeConnection(): void {
        $this->connection = null;
    }

    public function conn(): \PDO {
        return $this->connection;
    }
}
