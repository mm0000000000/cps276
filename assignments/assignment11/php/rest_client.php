<?php

function getWeather() {

    if (!isset($_POST["zip_code"]) || trim($_POST["zip_code"]) === "") {
        return [
            "<p class='text-danger'>No zip code provided. Please enter a zip code.</p>",
            ""
        ];
    }

    $zip = trim($_POST["zip_code"]);
    $api_url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code=" . urlencode($zip);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if ($response === false) {
        return [
            "<p class='text-danger'>API request failed.</p>",
            ""
        ];
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data["error"])) {
        return [
            "<p class='text-danger'>{$data['error']}</p>",
            ""
        ];
    }

    // pull base data
    $city_info = $data["searched_city"];
    $city_name = $city_info["name"];
    $temperature = $city_info["temperature"];
    $humidity = $city_info["humidity"];
    $forecast = $city_info["forecast"];

    $warmer = $data["higher_temperatures"];
    $cooler = $data["lower_temperatures"];

    // build the html
    $html = "<h2>$city_name</h2>";
    $html .= "<p><strong>Temperature:</strong> $temperature</p>";
    $html .= "<p><strong>Humidity:</strong> $humidity</p>";

    $html .= "<p><strong>3-day forecast</strong></p><ul>";
    foreach ($forecast as $day) {
        $html .= "<li>{$day['day']}: {$day['condition']}</li>";
    }
    $html .= "</ul>";

    // warmer section
    if (count($warmer) === 0) {
        $html .= "<p><strong>There are no cities with temperatures higher than $city_name.</strong></p>";
    } else {
        $html .= "<p><strong>Up to three cities where temperatures are higher than $city_name</strong></p>";
        $html .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";

        foreach ($warmer as $c) {
            $html .= "<tr><td>{$c['name']}</td><td>{$c['temperature']}</td></tr>";
        }

        $html .= "</tbody></table>";
    }

    // cooler section
    if (count($cooler) === 0) {
        $html .= "<p><strong>There are no cities with temperatures lower than $city_name.</strong></p>";
    } else {
        $html .= "<p><strong>Up to three cities where temperatures are lower than $city_name</strong></p>";
        $html .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";

        foreach ($cooler as $c) {
            $html .= "<tr><td>{$c['name']}</td><td>{$c['temperature']}</td></tr>";
        }

        $html .= "</tbody></table>";
    }

    return ["", $html];
}

?>
