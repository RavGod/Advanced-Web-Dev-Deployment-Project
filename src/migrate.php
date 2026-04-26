<?php

require_once __DIR__ . '/db_connect.php';

$pdo = getConnection();

echo $pdo->query("SELECT current_database()")->fetchColumn();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) UNIQUE,
        run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$applied = $pdo->query("SELECT migration FROM migrations")
               ->fetchAll(PDO::FETCH_COLUMN);

$files = glob(__DIR__ . "/migrations/*.{sql,php}", GLOB_BRACE);
sort($files);

foreach ($files as $file) {

    $name = basename($file);

    if (in_array($name, $applied)) {
        continue;
    }

    try {
        $pdo->beginTransaction();

        $ext = pathinfo($file, PATHINFO_EXTENSION); // Literally how it's able to tell if it's php or sql

        if ($ext === 'sql') {
            $sql = file_get_contents($file);
            $pdo->exec($sql);
        }

        if ($ext === 'php') {
            $migration = require $file;

            if (is_callable($migration)) {
                $migration($pdo);
            } else {
                throw new Exception("Invalid migration: $name");
            }
        }

        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$name]);

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: $name\n";
        echo $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All migrations complete.\n";