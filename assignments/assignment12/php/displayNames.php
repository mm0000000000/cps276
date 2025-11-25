<?php
require_once "../classes/Pdo_methods.php";

header('Content-Type: application/json');

$pdo = new PdoMethods();
$sql = "SELECT name FROM names ORDER BY name ASC";

$records = $pdo->selectNotBinded($sql);

// DB error
if ($records === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "There was an error retrieving names"
    ]);
    exit;
}

// empty table
if (count($records) === 0) {
    echo json_encode([
        "masterstatus" => "success",
        "names" => "No names to display"
    ]);
    exit;
}

// build simple <p> list
$output = "";
foreach ($records as $row) {
    $output .= "<p>{$row['name']}</p>";
}

echo json_encode([
    "masterstatus" => "success",
    "names" => $output
]);
?>
