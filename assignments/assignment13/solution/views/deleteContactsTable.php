<?php
require_once 'includes/navigation.php';
require_once 'classes/Pdo_methods.php';

$pdo = new PdoMethods();
$sql = "SELECT id, fname, lname, address, city, state, phone, zip, email, dob, contacts, age FROM contacts";
$records = $pdo->selectNotBinded($sql);

$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'deleted') $message = "<p style='color:green'>Contact(s) deleted</p>";
    if ($_GET['msg'] === 'error')   $message = "<p style='color:red'>Could not delete the contacts</p>";
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
<h1>Delete Contact(s)</h1>
<?= $message ?>

<form method="post" action="controllers/deleteContactProc.php">
    <input type="submit" class="btn btn-danger mb-2" name="delete" value="Delete" /><br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>State</th><th>Phone</th>
            <th>Zip Code</th><th>Email</th><th>DOB</th><th>Contact</th><th>Age</th><th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($records === 'error' || count($records) === 0): ?>
            <tr><td colspan="12">There are no records to display</td></tr>
        <?php else: foreach ($records as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['fname']) ?></td>
                <td><?= htmlspecialchars($row['lname']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['city']) ?></td>
                <td><?= htmlspecialchars($row['state']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['zip']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['dob']) ?></td>
                <td><?= htmlspecialchars($row['contacts']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?></td>
                <td><input type="checkbox" name="chkbx[]" value="<?= $row['id'] ?>" /></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</form>
</body>
</html>
