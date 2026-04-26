<?php
return function ($pdo) {

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id SERIAL PRIMARY KEY,
            migration VARCHAR(255) UNIQUE NOT NULL,
            run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
};