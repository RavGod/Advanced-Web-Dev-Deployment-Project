<?php

return function ($pdo) {

    $users = [
        ['admin', 'password123'],
        ['student1', 'test123'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO users (username, password_hash)
        VALUES (:username, :password_hash)
    ");

    foreach ($users as [$username, $password]) {
        $stmt->execute([
            ':username' => $username,
            ':password_hash' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
};
?>