<?php
require_once '../classes/Pdo_methods.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php?page=login");
    exit;
}

$pdo = new PdoMethods();

$sql = "SELECT id, fname, lname, email, password, status FROM admins WHERE email = :email";

$bindings = [
    [":email", $_POST["email"] ?? "", "str"]
];

$records = $pdo->selectBinded($sql, $bindings);

// if query failed OR no records, invalid login
if ($records === "error" || count($records) === 0) {
    header("Location: ../index.php?page=login&error=1");
    exit;
}

// we know we have exactly one admin row for this email
$admin = $records[0];

// check password hash
if (!password_verify($_POST["password"] ?? "", $admin["password"])) {
    header("Location: ../index.php?page=login&error=1");
    exit;
}

// set sess
$_SESSION["admin_id"] = $admin["id"];
$_SESSION["name"] = $admin["fname"] . " " . $admin["lname"];
$_SESSION["status"] = $admin["status"];

header("Location: ../index.php?page=welcome");
exit;
