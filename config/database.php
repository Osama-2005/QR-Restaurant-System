<?php

class Database
{
    private $host;
    private $port;
    private $database;
    private $username;
    private $password;
    private $connection;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->port = getenv('DB_PORT') ?: '3306';
        $this->database = getenv('DB_NAME') ?: 'qr_restaurant';
        $this->username = getenv('DB_USER') ?: 'qr_user';
        $this->password = getenv('DB_PASSWORD') ?: '';
    }

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed.");
        }

        return $this->connection;
    }
}