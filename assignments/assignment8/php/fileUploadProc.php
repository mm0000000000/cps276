<?php
require_once __DIR__ . "/../classes/Pdo_methods.php";

$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // make a new instance
    $pdo = new PdoMethods();
    $file_name = trim($_POST['fileName']);

    // make sure we specified a file name when we posted our upload
    if ($file_name == "") {
        $output = "You must enter a file name.";
    } 

    // make sure we actually selected a file
    else if (!isset($_FILES['pdfFile']) || $_FILES['pdfFile']['error'] != 0) {

        // handle if upload failed due to size or missing file
        if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == UPLOAD_ERR_INI_SIZE) {
            $output = "File too large.";
        } else {
            $output = "No file was uploaded. Make sure you choose a file to upload.";
        }
    } 
    else {
        $file = $_FILES['pdfFile'];
        $file_size = $file['size'];

        // get the mime type
        $file_type = mime_content_type($file['tmp_name']);

        // validate
        if ($file_size > 100000) {
            $output = "File too large. Must be under 100000 bytes.";
        }
        elseif ($file_type != "application/pdf") {
            $output = "Invalid file type. Only PDFs are allowed.";
        }
        else {
            // path to files dir relative to this file
            $target_dir = __DIR__ . "/../files/";
            $file_name_on_disk = basename($file['name']);
            $target_file = $target_dir . $file_name_on_disk;

            // move the uploaded temp file into /files
            if (move_uploaded_file($file['tmp_name'], $target_file)) {

                // prepare
                $sql = "INSERT INTO files (file_name, file_path) VALUES (:file_name, :file_path)";
                $bindings = [
                    [':file_name', $file_name, 'str'],
                    [':file_path', "files/" . $file_name_on_disk, 'str']
                ];

                // execute the query using bindings and such
                $result = $pdo->otherBinded($sql, $bindings);

                if ($result == 'noerror') {
                    $output = "File uploaded and saved successfully.";
                } else {
                    $output = "Database error. Please try again.";
                }
            } 
            else {
                $output = "Error moving uploaded file.";
            }
        }
    }
}
else {
    $output = "";
}

// render the upload form
$output .= <<<HTML
<form method="post" action="index.php" enctype="multipart/form-data" class="mt-3 text-start">
  <div class="mb-3">
    <label for="fileName" class="form-label">File Name</label>
    <input type="text" class="form-control" name="fileName" id="fileName" placeholder="Enter a name for your file">
  </div>

  <div class="mb-3 d-flex align-items-center">
    <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" class="form-control-file me-2">
  </div>

  <button type="submit" class="btn btn-primary">Upload File</button>
</form>
HTML;
?>
