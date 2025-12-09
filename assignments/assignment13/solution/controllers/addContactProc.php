<?php
require_once '../classes/Pdo_methods.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PdoMethods();

    $contact = '';
    if (isset($_POST['contact']) && is_array($_POST['contact'])) {
        $contact = implode(",", $_POST['contact']);
    }

    $sql = "INSERT INTO contacts
            (fname, lname, address, city, state, zip, phone, email, dob, contact, age)
            VALUES
            (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :contact, :age)";

    $bindings = [
        [':fname', $_POST['fname'], 'str'],
        [':lname', $_POST['lname'], 'str'],
        [':address', $_POST['address'], 'str'],
        [':city', $_POST['city'], 'str'],
        [':state', $_POST['state'], 'str'],
        [':zip', $_POST['zipCode'], 'str'],
        [':phone', $_POST['phone'], 'str'],
        [':email', $_POST['email'], 'str'],
        [':dob', $_POST['dob'], 'str'],
        [':contact', $contact, 'str'],
        [':age', isset($_POST['age']) ? $_POST['age'] : '', 'str'],
    ];

    $pdo->otherBinded($sql, $bindings);

    // back to Add Contact with success flag
    header("Location: ../index.php?page=addContact&msg=success");
    exit;
}

// fallback
header("Location: ../index.php?page=addContact");
exit;
