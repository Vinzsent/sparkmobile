<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['user_id'];

    // Check if each key is set before accessing it
    $vehicle_id = isset($_POST["vehicle_id"]) ? $_POST["vehicle_id"] : "";
    $battery = isset($_POST["battery"]) ? $_POST["battery"] : "";
    $lights = isset($_POST["lights"]) ? $_POST["lights"] : "";
    $oil = isset($_POST["oil"]) ? $_POST["oil"] : "";
    $water = isset($_POST["water"]) ? $_POST["water"] : "";
    $brake = isset($_POST["brake"]) ? $_POST["brake"] : "";
    $air = isset($_POST["air"]) ? $_POST["air"] : "";
    $gas = isset($_POST["gas"]) ? $_POST["gas"] : "";
    $engine = isset($_POST["engine"]) ? $_POST["engine"] : "";
    $tire = isset($_POST["tire"]) ? $_POST["tire"] : "";
    $self = isset($_POST["self"]) ? $_POST["self"] : "";
    $shop_id = isset($_POST['shop_id']) && is_numeric($_POST['shop_id']) ? (int)$_POST['shop_id'] : NULL;  // Modified to handle shop_id correctly

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO carcondition_details (user_id, vehicle_id, shop_id, battery, lights, oil, water, brake, air, gas, engine, tire, self) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iiissssssssss", $userID, $vehicle_id, $shop_id, $battery, $lights, $oil, $water, $brake, $air, $gas, $engine, $tire, $self);

    // Execute the statement
    try {
        $query = "SELECT * FROM vehicles WHERE vehicle_id = '$vehicle_id'";
        $result = mysqli_query($connection, $query);
        $vehicleData = mysqli_fetch_assoc($result);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('Condition Submitted!. Please wait for the notification ');</script>";
        echo "<script>
        setTimeout(function() {
            window.location.href = 'checkingcar2.php?vehicle_id=" . (isset($vehicleData['vehicle_id']) ? $vehicleData['vehicle_id'] : '') . "&shop_id=" . (isset($shop_id) ? $shop_id : '') . "';
        }, 100); // Redirect after 1 second
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
