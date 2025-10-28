<?php
require_once __DIR__ . "/../classes/Pdo_methods.php";

// make a new instance
$pdo = new PdoMethods();

// prepare and select all file records showing the newest first
$sql = "SELECT file_name, file_path FROM files ORDER BY id DESC";

// query without bindings (params)
$records = $pdo->selectNotBinded($sql);

if ($records == 'error') {
    $output = "There was an error retrieving files.";
}
else if (count($records) == 0) {
    $output = "No files found.";
}
else {
  // build an html list
    $output = "<ul style='padding-left: 1.2rem;'>";
    foreach ($records as $row) {
        $output .= "<li><a target='_blank' href='{$row['file_path']}'>{$row['file_name']}</a></li>";
    }
    $output .= "</ul>";
}
?>
