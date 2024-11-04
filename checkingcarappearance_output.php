<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['user_id'];
    $vehicleID = isset($_SESSION['vehicle_id']) ? $_SESSION['vehicle_id'] : null;

    // Check if vehicle_id is set
    if (empty($vehicleID)) {
        echo "Error: 'vehicle_id' is not set.";
        exit;
    }

    // Check if each key is set before accessing it
    $body = isset($_POST["body"]) ? $_POST["body"] : "";
    $windshield = isset($_POST["windshield"]) ? $_POST["windshield"] : "";
    $interior = isset($_POST["interior"]) ? $_POST["interior"] : "";
    $sidemirror = isset($_POST["sidemirror"]) ? $_POST["sidemirror"] : "";
    $tires = isset($_POST["tires"]) ? $_POST["tires"] : "";

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO carappearance (vehicle_id, body, windshield, interior, sidemirror, tires) 
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);
    
    if ($stmt === false) {
        echo "Error: " . mysqli_error($connection);
        exit;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "isssss", $vehicleID, $body, $windshield, $interior, $sidemirror, $tires);

    // Execute the statement
    try {
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Condition Submitted!. Please wait for the notification ');</script>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'checkingcar.php';
            }, 1000); // Redirect after 1 second
        </script>";
        exit;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>
