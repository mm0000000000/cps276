<?php
require_once '../classes/Pdo_methods.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PdoMethods();

    // check for duplicate email
    $checkSql = "SELECT id FROM admins WHERE email = :email";
    $checkBindings = [
        [':email', $_POST['email'], 'str']
    ];
    $existing = $pdo->selectBinded($checkSql, $checkBindings);

    if ($existing !== 'error' && count($existing) > 0) {
        // email already exists
        header("Location: ../index.php?page=addAdmin&msg=exists");
        exit;
    }

    // hash password
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (fname, lname, email, password, status) VALUES (:fname, :lname, :email, :password, :status)";

    $bindings = [
        [':fname', $_POST['fname'], 'str'],
        [':lname', $_POST['lname'], 'str'],
        [':email', $_POST['email'], 'str'],
        [':password', $hash, 'str'],
        [':status', $_POST['status'], 'str'],
    ];

    $pdo->otherBinded($sql, $bindings);

    header("Location: ../index.php?page=addAdmin&msg=success");
    exit;
}

// fallback
header("Location: ../index.php?page=addAdmin");
exit;
