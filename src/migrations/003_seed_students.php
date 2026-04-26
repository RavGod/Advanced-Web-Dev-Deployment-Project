<?php
echo "Running: $name\n";

return function ($pdo) {

    $students = [
        ['Jet', 'Longview', 'jet@school.com', 'password123', 'Linguistics', 'Sophomore'],
        ['Rose', 'Thornton', 'rose@school.com', 'password123', 'Computer Science', 'Junior'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO students (
            first_name, last_name, email, password_hash, major, classification
        )
        VALUES (
            :first_name, :last_name, :email, :password_hash, :major, :classification
        )
    ");

    foreach ($students as $s) {
        $stmt->execute([
            ':first_name' => $s[0],
            ':last_name' => $s[1],
            ':email' => $s[2],
            ':password_hash' => password_hash($s[3], PASSWORD_BCRYPT),
            ':major' => $s[4],
            ':classification' => $s[5],
        ]);
    }
};