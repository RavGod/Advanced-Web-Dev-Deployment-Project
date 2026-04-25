<?php
function getConnection()
{
    $connectionString  = "mysql:host=db;dbname=student_directory";
    $connectionString .= ";charset=utf8mb4";

    $user = "root";
    $pass = "root";

    try {
        $pdo = new PDO($connectionString, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}