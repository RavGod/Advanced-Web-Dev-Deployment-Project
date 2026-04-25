<?php
function getConnection()
{
    $connectionString  = "mysql:host=localhost;dbname=student_directory";
    $connectionString .= ";charset=utf8mb4";

    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO($connectionString, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}