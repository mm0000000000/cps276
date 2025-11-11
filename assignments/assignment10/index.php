<?php
require_once "classes/Pdo_methods.php";
require_once "classes/Validation.php";

/*
1. Why does StickyForm extend Validation instead of including validation logic directly? What are the benefits of this design?

2. Explain what "sticky form" means. How does it improve user experience compared to a non-sticky form?

3. Describe the validation process. When does validation occur, and what happens if validation fails?

4. Explain the purpose of the $formConfig array. What information does it store, and how is it used throughout the form lifecycle?

5. What is the purpose of masterStatus['error'] in the form configuration? How does it coordinate validation across multiple form fields?
*/


$v = new Validation();
$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $output = handleForm($v);
} else {
  $output = showForm();
}

function handleForm($v) {
  $pdo = new PdoMethods();

  // get our vars from the request
  $first = trim($_POST['firstName'] ?? "");
  $last = trim($_POST['lastName'] ?? "");
  $email = trim($_POST['email'] ?? "");
  $pass = trim($_POST['password'] ?? "");
  $confirm = trim($_POST['confirmPassword'] ?? "");

  $errors = [
    'firstName' => '',
    'lastName' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => ''
  ];

  // validate and setup our errors if we have any
  if ($first == "") {
    $errors['firstName'] = "First name is required.";
  } elseif (!$v->checkFormat($first, 'name')) {
    $errors['firstName'] = "Invalid name format.";
  }

  if ($last == "") {
    $errors['lastName'] = "Last name is required.";
  } elseif (!$v->checkFormat($last, 'name')) {
    $errors['lastName'] = "You must enter a valid last name.";
  }

  if ($email == "") {
    $errors['email'] = "Email is required.";
  } elseif (!$v->checkFormat($email, 'email')) {
    $errors['email'] = "You must enter a valid email address.";
  }

  $pass_msg = "Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)";
  if ($pass == "") {
    $errors['password'] = "Password is required.";
  } elseif (!$v->checkFormat($pass, 'password', $pass_msg)) {
    $errors['password'] = $pass_msg;
  }

  if ($confirm == "") {
    $errors['confirmPassword'] = "Confirm password is required.";
  } elseif (!$v->checkFormat($confirm, 'password', $pass_msg)) {
    $errors['confirmPassword'] = $pass_msg;
  } elseif ($pass !== $confirm) {
    $errors['confirmPassword'] = "Your passwords do not match.";
  }

  // check if an email already exists
  if ($errors['email'] == "") {
    $sql = "SELECT email FROM users WHERE email = :email";
    $bindings = [[':email', $email, 'str']];
    $result = $pdo->selectBinded($sql, $bindings);

    if ($result != 'error' && count($result) > 0) {
      $errors['email'] = "There is already a record with that email.";
    }
  }

  // see if we have any errors
  $hasError = false;
  foreach ($errors as $e) {
    if ($e != "") { $hasError = true; break; }
  }

  if ($hasError) {
    return showForm($errors, $_POST);
  }

  // setup our hashed password
  $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

  // insert that record into the database
  $sql = "INSERT INTO users (first_name, last_name, email, password)
          VALUES (:first_name, :last_name, :email, :password)";
  $bindings = [
    [':first_name', $first, 'str'],
    [':last_name', $last, 'str'],
    [':email', $email, 'str'],
    [':password', $hashed_pass, 'str']
  ];

  $insert_result = $pdo->otherBinded($sql, $bindings);

  if ($insert_result == 'noerror') {
    return showForm([], [], true);
  } else {
    return "<p class='text-danger'>Database error.</p>" . showForm($errors, $_POST);
  }
}

// declare our showform func, we set all the param defaults too
function showForm($errors = [], $data = [], $clear = false) {
  $pdo = new PdoMethods();

  // if we are clear empty the values
  // otherwise keep the submitted data so the form stays "sticky"
  $first = $clear ? "" : htmlspecialchars($data['firstName'] ?? "");
  $last = $clear ? "" : htmlspecialchars($data['lastName'] ?? "");
  $email = $clear ? "" : htmlspecialchars($data['email'] ?? "");
  $pass = $clear ? htmlspecialchars($data['password'] ?? "") : htmlspecialchars($data['password'] ?? "");
  $confirm = $clear ? htmlspecialchars($data['confirmPassword'] ?? "") : htmlspecialchars($data['confirmPassword'] ?? "");

  $msg = "";
  if ($clear) {
    $msg = "<p class='text-success'>You have been added to the database</p>";
  }

  $eFirst = $errors['firstName'] ?? "";
  $eLast = $errors['lastName'] ?? "";
  $eEmail = $errors['email'] ?? "";
  $ePass = $errors['password'] ?? "";
  $eConfirm = $errors['confirmPassword'] ?? "";

  // fetch all users
  $sql = "SELECT first_name, last_name, email, password FROM users ORDER BY id DESC";
  $records = $pdo->selectNotBinded($sql);

  if ($records == 'error' || count($records) == 0) {
    $table = "<p class='mt-3'>No records to display.</p>";
  } else {

    // build our table
    $table = "<table class='table table-bordered mt-3'>
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Password</th>
        </tr>
      </thead>
      <tbody>";

    foreach ($records as $row) {
      $table .= "<tr>
        <td>{$row['first_name']}</td>
        <td>{$row['last_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['password']}</td>
      </tr>";
    }

    $table .= "</tbody></table>";
  }

  $formHTML = <<<HTML
  $msg
  <form method="post" action="index.php" class="text-start mt-3">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" class="form-control" name="firstName" id="firstName" value="$first">
        <span class="text-danger">$eFirst</span>
      </div>
      <div class="col-md-6 mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="text" class="form-control" name="lastName" id="lastName" value="$last">
        <span class="text-danger">$eLast</span>
      </div>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" class="form-control" name="email" id="email" value="$email">
      <span class="text-danger">$eEmail</span>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" class="form-control" name="password" id="password" value="$pass">
        <span class="text-danger">$ePass</span>
      </div>
      <div class="col-md-6 mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="text" class="form-control" name="confirmPassword" id="confirmPassword" value="$confirm">
        <span class="text-danger">$eConfirm</span>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>

  $table
  HTML;

  return $formHTML;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sticky Form Example</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="container mt-5">
    <?php echo $output; ?>
  </div>
</body>
</html>
