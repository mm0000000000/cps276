<?php
require_once "php/fileUploadProc.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  </head>

  <body>
    <div class="container mt-5">
      <h1 class="mb-3">File Upload</h1>
      <p><a href="listFiles.php">Show File List</a></p>
      <div class="mt-3">
        <?php echo $output; ?>
      </div>
    </div>
  </body>
</html>
