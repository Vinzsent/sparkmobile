<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $label = $_POST["label"];
    $platenumber = $_POST["platenumber"];
    $chassisnumber = $_POST["chassisnumber"];
    $enginenumber = $_POST["enginenumber"];
    $model = $_POST["model"];
    $color = $_POST["color"];
    $size = $_POST["size"];

    $query = "INSERT INTO vehicles (label, platenumber, chassisnumber, enginenumber, model, color, size )
              VALUES ('$label', '$platenumber', '$chassisnumber', '$enginenumber', '$model', '$color', '$size' )";

    if (mysqli_query($connection, $query)) {
        echo "Registration successful!<br>";
        echo "View <a href='cars.php'>Details</a> to continue.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
