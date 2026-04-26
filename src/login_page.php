<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $pdo = getConnection();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div style="max-width:400px;margin:100px auto;">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required style="width:100%;padding:10px;"><br><br>

        <input type="password" name="password" placeholder="Password" required style="width:100%;padding:10px;"><br><br>

        <button type="submit" style="width:100%;padding:10px;">
            Login
        </button>
    </form>
</div>

</body>
</html>