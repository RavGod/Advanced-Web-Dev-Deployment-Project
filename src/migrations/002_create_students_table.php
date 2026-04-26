<?php
return function ($pdo) {

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS students (
            student_id BIGSERIAL PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            major VARCHAR(100),
            classification VARCHAR(50)
        )
    ");
};