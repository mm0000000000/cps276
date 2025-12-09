<?php
require_once 'includes/navigation.php';
require_once 'classes/Pdo_methods.php';

$pdo = new PdoMethods();
$sql = "SELECT id, fname, lname, email, password, status FROM admins";
$records = $pdo->selectNotBinded($sql);

$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'deleted') $message = "<p style='color:green'>Admin(s) deleted</p>";
    if ($_GET['msg'] === 'error')   $message = "<p style='color:red'>Could not delete the admins</p>";
}
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
<h1>Delete Admin(s)</h1>
<?= $message ?>

<form method="post" action="controllers/deleteAdminProc.php">
    <input type="submit" class="btn btn-danger mb-2" name="delete" value="Delete" />
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Status</th><th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($records === 'error' || count($records) === 0): ?>
            <tr><td colspan="5">There are no records to display</td></tr>
        <?php else: foreach ($records as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['fname']) ?></td>
                <td><?= htmlspecialchars($row['lname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['password']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><input type="checkbox" name="chkbx[]" value="<?= $row['id'] ?>" /></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</form>
</body>
</html>
