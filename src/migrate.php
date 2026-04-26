<?php

require_once "db_connect.php";

if (getenv("APP_ENV") !== "dev") {
    die("Disabled in production");
}

$pdo = getConnection();

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS students (
            student_id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            major VARCHAR(100),
            classification VARCHAR(50)
        );
    ");

    echo "Migration complete: students table ready.";

} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}