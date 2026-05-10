<?php

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        try {
            // Ambil dari environment atau default
            $host = getenv('MYSQL_HOST') ?: 'db';
            $db = getenv('MYSQL_DB') ?: 'inventaris';
            $user = getenv('MYSQL_USER') ?: 'user';
            $pass = getenv('MYSQL_PASSWORD') ?: 'password';

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            ];

            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}