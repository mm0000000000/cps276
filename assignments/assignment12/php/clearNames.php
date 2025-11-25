<?php
require_once "../classes/Pdo_methods.php";

header('Content-Type: application/json');

$pdo = new PdoMethods();
$sql = "DELETE FROM names";

$result = $pdo->otherNotBinded($sql);

if ($result === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "There was a problem clearing the names"
    ]);
} else {
    echo json_encode([
        "masterstatus" => "success",
        "msg" => "All names cleared"
    ]);
}
?>
