<?php

return function ($pdo) {

    $students = [
        ['Jet', 'Longview', 'jet@school.com', 'password123', 'Linguistics', 'Sophomore'],
        ['Rose', 'Thornton', 'rose@school.com', 'password123', 'Computer Science', 'Junior'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO students (
            first_name, last_name, email, password_hash, major, classification
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    foreach ($students as $s) {
        $stmt->execute([
            $s[0],
            $s[1],
            $s[2],
            password_hash($s[3], PASSWORD_BCRYPT),
            $s[4],
            $s[5],
        ]);
    }

    echo "Seeding complete\n";
};