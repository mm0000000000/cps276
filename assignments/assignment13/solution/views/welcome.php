<?php
require_once 'includes/navigation.php';

$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project</title>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container">
<?= $nav ?>
<h1>Welcome Page</h1>
<p>Welcome <?= htmlspecialchars($name) ?></p>
</body>
</html>
