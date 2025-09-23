<?php

// use . to combine
$numbers = range(1, 50);
$evenNumbers = '';
foreach ($numbers as $n) {
    if ($n % 2 === 0) {
        $evenNumbers .= $n . ' - ';
    }
}

$evenNumbers = 'Even Numbers: ' . rtrim($evenNumbers, " -");



$form = <<<HTML
<form class="mt-3 mb-3" method="post" action="#">
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
  </div>
  <div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="exampleTextarea" name="message" rows="3"></textarea>
  </div>
</form>
HTML;

function createTable(int $rows, int $cols) {
    $table = '<table class="table table-bordered"><tbody>';

    for ($r = 1; $r <= $rows; $r++) {
        $table .= '<tr>';

        for ($c = 1; $c <= $cols; $c++) {
            $table .= '<td>Row ' . $r . ', Col ' . $c . '</td>';
        }

        $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    return $table;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Form Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"/>
</head>

<body class="container">
  <?php
    echo $evenNumbers;
    echo $form;
    echo createTable(8, 6);
  ?>
</body>

</html>
