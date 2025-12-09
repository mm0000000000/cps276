<?php
require_once 'includes/navigation.php';
require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

// build sticky forum
function getAdminFormConfig() {
    return [
        'masterStatus' => [
            'error' => false,
            'msg'   => ''
        ],

        'fname' => [
            'type' => 'text',
            'id' => 'fname',
            'name' => 'fname',
            'label' => 'First Name',
            'required' => true,
            'regex' => 'name',
            'value' => '',
            'errorMsg' => 'You must enter a valid first name',
            'error' => ''
        ],

        'lname' => [
            'type' => 'text',
            'id' => 'lname',
            'name' => 'lname',
            'label' => 'Last Name',
            'required' => true,
            'regex' => 'name',
            'value' => '',
            'errorMsg' => 'You must enter a valid last name',
            'error' => ''
        ],

        'email' => [
            'type' => 'text',
            'id' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'required' => true,
            'regex' => 'email',
            'value' => '',
            'errorMsg' => 'You must enter a valid email address.',
            'error' => ''
        ],

        'password' => [
            'type' => 'password',
            'id' => 'password',
            'name' => 'password',
            'label' => 'Password',
            'required' => true,
            'regex' => 'password',
            'value' => '',
            'errorMsg' => 'You must enter a valid password.',
            'error' => ''
        ],

        'status' => [
            'type' => 'select',
            'id' => 'status',
            'name' => 'status',
            'label' => 'Status',
            'required' => true,
            'selected' => '0',
            'options' => [
                '0' => 'Please Select a Status',
                'staff' => 'Staff',
                'admin' => 'Admin'
            ],
            'errorMsg' => 'You must select a status.',
            'error' => ''
        ],
    ];
}


$sticky = new StickyForm();
$pdo = new PdoMethods();
$form = getAdminFormConfig();
$message = "&nbsp;";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $sticky->validateForm($_POST, $form);

    // check for duplicate email
    if ($form['email']['error'] === '') {
        $sql = "SELECT email FROM admins WHERE email = :email";
        $bindings = [
            [':email', $_POST['email'], 'str']
        ];
        $exists = $pdo->selectBinded($sql, $bindings);

        if ($exists !== 'error' && count($exists) > 0) {
            $form['email']['error'] = "There is already someone with that email";
            $form['masterStatus']['error'] = true;
        }
    }

    if (!$form['masterStatus']['error']) {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (fname, lname, email, password, status) VALUES (:fname, :lname, :email, :password, :status)";
        $bindings = [
            [':fname', $_POST['fname'], 'str'],
            [':lname', $_POST['lname'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':password', $hash, 'str'],
            [':status', $_POST['status'], 'str']
        ];
        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'noerror') {
            $message = "<p style='color:green'>Admin added</p>";
            $form = getAdminFormConfig(); // reset form!!
        } else {
            $message = "<p style='color:red'>Error adding admin</p>";
        }
    }
}

// render manually with the sticky form
$fname = $sticky->renderInput($form['fname'], 'mb-3');
$lname = $sticky->renderInput($form['lname'], 'mb-3');
$email = $sticky->renderInput($form['email'], 'mb-3');
$pass = $sticky->renderPassword($form['password'], 'mb-3');
$status = $sticky->renderSelect($form['status'], 'mb-3');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container">
    <?= $nav ?>
    <div class="container">
        <h1>Add Admin</h1>
        <p><?= $message ?></p>

        <form method="post" action="">
            <div class="row">
                <div class="col-md-6"><?= $fname ?></div>
                <div class="col-md-6"><?= $lname ?></div>
            </div>

            <div class="row">
                <div class="col-md-4"><?= $email ?></div>
                <div class="col-md-4"><?= $pass ?></div>
                <div class="col-md-4"><?= $status ?></div>
            </div>

            <input type="submit" class="btn btn-primary" value="Add Admin">
        </form>
    </div>
</body>
</html>
