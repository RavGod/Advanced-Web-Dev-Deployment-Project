<?php

require_once __DIR__ . '/db.php';

$db = getConnection();

$db->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) UNIQUE,
        run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$applied = $db->query("SELECT migration FROM migrations")
              ->fetchAll(PDO::FETCH_COLUMN);

$files = glob(__DIR__ . "/migrations/*.php");
sort($files);

foreach ($files as $file) {
    $name = basename($file);

    if (in_array($name, $applied)) {
        continue;
    }

    echo "Running migration: $name\n";

    $migration = require $file;

    try {
        $db->beginTransaction();

        $migration($db);

        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$name]);

        $db->commit();

        echo "Done: $name\n";

    } catch (Exception $e) {
        $db->rollBack();
        echo "Failed: $name\n";
        echo $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All migrations complete.\n";