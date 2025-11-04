<?php
require_once "classes/Date_time.php";
$dt = new Date_time();
$output = $dt->displayNotes();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Display Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  </head>

  <body>
    <div class="container mt-5">
      <h1 class="mb-3">Display Notes</h1>
      <p><a href="index.php">Add Note</a></p>

      <div class="mt-3">
        <?php echo $output; ?>
      </div>
    </div>
  </body>
</html>
