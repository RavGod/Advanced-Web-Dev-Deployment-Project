<?php

function getConnection()
{
    $url = getenv("DATABASE_URL");

    if (!$url) {
        die("DATABASE_URL not set");
    }

    $db = parse_url($url);

    $host = $db["host"];
    $port = $db["port"] ?? 5432;
    $user = $db["user"];
    $pass = $db["pass"];
    $name = ltrim($db["path"], "/");

    $dsn = "pgsql:host=$host;port=$port;dbname=$name";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        return $pdo;

    } catch (PDOException $e) {
        error_log($e->getMessage());
        die("Database connection error.");
    }
}