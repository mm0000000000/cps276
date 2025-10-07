<?php
require_once "Calculator.php";

$Calculator = new Calculator();

$result = "";
$result .= $Calculator->calc("*", 10, 2);
$result .= $Calculator->calc("*", 4.56, 2);
$result .= $Calculator->calc("/", 10, 2);
$result .= $Calculator->calc("/", 10, 3);
$result .= $Calculator->calc("/", 10, 0);
$result .= $Calculator->calc("/", 0, 10);
$result .= $Calculator->calc("-", 10, 2);
$result .= $Calculator->calc("-", 10, 20);
$result .= $Calculator->calc("+", 10.5, 2);
$result .= $Calculator->calc("+", 10.5, 0);
$result .= $Calculator->calc("*", 10);
$result .= $Calculator->calc("+", "a", 10);
$result .= $Calculator->calc("+", 10, "a");
$result .= $Calculator->calc(10);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Calculator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body class="text-center">
  <h1>Calculator Output</h1>
  <main>
    <?php echo $result; ?>
  </main>
</body>
</html>
