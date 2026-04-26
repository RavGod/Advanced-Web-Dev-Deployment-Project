<?php

require_once __DIR__ . '/db_connect.php';

$pdo = getConnection();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) UNIQUE NOT NULL,
        run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$applied = $pdo->query("SELECT migration FROM migrations")
               ->fetchAll(PDO::FETCH_COLUMN);

$files = glob(__DIR__ . "/migrations/*.php");
sort($files);

foreach ($files as $file) {

    $name = basename($file);

    if (in_array($name, $applied, true)) {
        continue;
    }

    echo "Running: $name\n";

    $migration = require $file;

    if (!is_callable($migration)) {
        throw new Exception("Invalid migration file: $name");
    }

    try {
        $pdo->beginTransaction();

        $migration($pdo);

        $stmt = $pdo->prepare("
            INSERT INTO migrations (migration)
            VALUES (:migration)
        ");

        $stmt->execute([
            ':migration' => $name
        ]);

        $pdo->commit();

        echo "Done: $name\n";

    } catch (Exception $e) {
        $pdo->rollBack();

        echo "Failed: $name\n";
        echo $e->getMessage() . "\n";

        exit(1);
    }
}

echo "All migrations complete.\n";