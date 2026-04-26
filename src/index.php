<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db_connect.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Step 4: Retrieve all students, ordered in reverse alphabetical order
$pdo  = getConnection();
$stmt = $pdo->query('SELECT * FROM students ORDER BY last_name ASC');
$students = $stmt->fetchAll();         // Returns an array of associative arrays
$totalCount = count($students);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory — All Students</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="header-logo">SD</div>
        <div class="header-text">
            <h1>Student Directory</h1>
            <p>University Records Management System</p>
        </div>
    </div>
    <nav>
        <div class="nav-inner">
            <a href="index.php" class="active">All Students</a>
            <a href="search.php">Search</a>
        </div>
    </nav>
</header>

<main>
    <div class="page-title">
        <h2>All Students</h2>
        <p>Showing all enrolled students sorted alphabetically by last name.</p>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Major</th>
                    <th>Classification</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($totalCount > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <?php
                        // Build a CSS class for the classification badge
                        $cls      = strtolower($student['classification']);
                        $badgeCls = 'badge badge-' . $cls;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($student['student_id']) ?></td>
                            <td><?= htmlspecialchars($student['first_name']) ?></td>
                            <td><?= htmlspecialchars($student['last_name']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                            <td><?= htmlspecialchars($student['major']) ?></td>
                            <td>
                                    <span class="<?= $badgeCls ?>">
                                        <?= htmlspecialchars($student['classification']) ?>
                                    </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:#7a8499;">
                            No student records found. Please run <code>create_database.sql</code> first.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="record-count">
            <?= $totalCount ?> student<?= $totalCount !== 1 ? 's' : '' ?> found
        </div>
    </div>
</main>

</body>
</html>