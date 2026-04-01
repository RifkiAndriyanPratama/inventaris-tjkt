<?php

function get_db(): PDO
{
    $host = $_ENV['MYSQL_HOST'] ?? 'db';
    $db = $_ENV['MYSQL_DB'];
    $user = $_ENV['MYSQL_USER'];
    $pass = $_ENV['MYSQL_PASSWORD'];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}
