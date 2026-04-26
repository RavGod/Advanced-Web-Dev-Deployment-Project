-- Done just in case the migrate.php file doesn't
CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) UNIQUE,
        run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);