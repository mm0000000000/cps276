<?php
$output = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>add names</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"/>
</head>

<body class="container">

  <h1 class="mt-3">Add Names</h1>

  <form method="post">

    <div class="row">
      <div class="col">
        <button type="submit" name="add_btn" class="btn btn-primary">Add Name</button>
        <button type="submit" name="clear_btn" class="btn btn-primary">Clear Names</button>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="fullname" class="form-label">Enter Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname"/>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="namelist" class="form-label">List of Names</label>
        <textarea class="form-control" id="namelist" name="namelist" style="height: 500px;"><?php echo $output; ?></textarea>
      </div>
    </div>
  </form>

</body>
</html>
