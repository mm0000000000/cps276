<?php
/*
1. Explain the difference between a REST API client and a REST API server. What role does this code play in that relationship?

2. Why is JSON commonly used for API responses? What are the benefits of using JSON over other data formats like XML?

3. Explain the difference between a REST API client and a REST API server. What role does this code play in that relationship?

4. How should an application handle different types of API responses (success, error, empty data)? What considerations are important for each scenario?

5. What is cURL used for in web development?
*/

$output = "";
$acknowledgement = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/rest_client.php';
    $result = getWeather();
    $acknowledgement = $result[0];
    $output = $result[1];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Weather API</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>
<div class="container mt-5">

  <h1 class="mb-4">Enter Zip Code to Get City Weather</h1>

  <?php echo $acknowledgement; ?>

  <form method="post" action="index.php" class="mb-3">
    <label for="zip" class="form-label">Zip Code:</label>
    <input type="text" id="zip" name="zip_code" class="form-control mb-3">
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <?php echo $output; ?>

</div>
</body>
</html>
