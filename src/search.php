-- Step 5: Overall goal to create a form that allows the user to search for students via major or first (last name starts with M) name, and then display results

<?php

require_once 'db_connect.php';

$searchTerm    = '';
$searchField   = 'first_name';
$results       = [];
$searched      = false;

if (isset($_GET['search_term'])) {
    $searched    = true;
    $searchTerm  = trim($_GET['search_term']);
    $searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'first_name';

    $allowedFields = ['first_name', 'major'];
    if (!in_array($searchField, $allowedFields, true)) {
        $searchField = 'first_name';
    }

    if ($searchTerm !== '') {
        $pdo = getConnection();

        // Step 5: Prepared statement to be handled via client
        $sql  = "SELECT * FROM students
                  WHERE {$searchField} LIKE :term
                  ORDER BY first_name ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':term' => '%' . $searchTerm . '%']);
        $results = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory — Search</title>
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
            <a href="index.php">All Students</a>
            <a href="search.php" class="active">Search</a>
        </div>
    </nav>
</header>

<main>
    <div class="page-title">
        <h2>Search Students</h2>
        <p>Find students by first name or major using partial or full text matching.</p>
    </div>

    <div class="search-card">
        <h3>Search Criteria</h3>

        <form method="GET" action="search.php">
            <div class="form-row">

                <div class="form-group">
                    <label for="search_field">Search By</label>
                    <select id="search_field" name="search_field">
                        <option value="first_name"
                            <?= ($searchField === 'first_name') ? 'selected' : '' ?>>
                            First Name
                        </option>
                        <option value="major"
                            <?= ($searchField === 'major')     ? 'selected' : '' ?>>
                            Major
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="search_term">Search Term</label>
                    <input
                        type="text"
                        id="search_term"
                        name="search_term"
                        placeholder="e.g. Garcia or Computer Science"
                        value="<?= htmlspecialchars($searchTerm) ?>"
                        required
                    >
                </div>

                <div style="display:flex; gap:10px; align-items:flex-end;">
                    <button type="submit" class="btn btn-primary">
                        &#128269; Search
                    </button>
                    <a href="search.php" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
    </div>

    <?php if (!$searched): ?>
        <div class="alert alert-info">
            Enter a search term above and click <strong>Search</strong> to find students.
        </div>

    <?php elseif ($searchTerm === ''): ?>
        <div class="alert alert-warning">
            Please enter a search term to find students.
        </div>

    <?php elseif (count($results) === 0): ?>
        <div class="alert alert-warning">
            No students found matching <strong>"<?= htmlspecialchars($searchTerm) ?>"</strong>
            in the <strong><?= $searchField === 'first_name' ? 'First Name' : 'Major' ?></strong> field.
            Try a different term.
        </div>

    <?php else: ?>
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
                    <?php foreach ($results as $student): ?>
                        <?php
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
                    </tbody>
                </table>
            </div>

            <div class="record-count">
                <?= count($results) ?> result<?= count($results) !== 1 ? 's' : '' ?>
                for &ldquo;<?= htmlspecialchars($searchTerm) ?>&rdquo;
                &mdash; searched by <?= $searchField === 'first_name' ? 'first Name' : 'Major' ?>
            </div>
        </div>
    <?php endif; ?>

</main>

</body>
</html>