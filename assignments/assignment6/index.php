<?php
require_once "classes/Directories.php";

$message = "";
$link = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folder_name = $_POST["folder_name"];
    $file_text = $_POST["file_text"];

    // make a new Directories object
    $dir = new Directories();

    // create a dir and get the result
    $result = $dir->createDirectory($folder_name, $file_text);

    // parse the result
    if ($result["status"] == "exists") {
        $message = "A directory already exists with that name.";

    } elseif ($result["status"] == "error") {
        $message = $result["message"];

    } elseif ($result["status"] == "success") {
        $message = "File and directory were created";
        // construct a _blank link so it opens in a new tab
        $link = "<a href='" . $result["path"] . "' target='_blank'>Path where file is located</a>";

    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>File and Directory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container mt-4">
  <h1>File and Directory Assignment</h1>
  <p>Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>

  <?php
  // if we have a message or link show them
  if ($message != "") {
      echo "<p>$message</p>";
  }
  if ($link != "") {
      echo "<p>$link</p>";
  }
  ?>

  <form method="post">
    <div class="mb-3">
      <label for="folder_name" class="form-label">Folder Name</label>
      <input type="text" class="form-control" id="folder_name" name="folder_name" required>
    </div>

    <div class="mb-3">
      <label for="file_text" class="form-label">File Content</label>
      <textarea class="form-control" id="file_text" name="file_text" rows="6" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>
</html>
