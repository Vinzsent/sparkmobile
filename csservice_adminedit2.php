<?php
session_start();
require_once "config.php";

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from the session
    $service_id = $_SESSION['service_id'];

    $service_name = $_POST["service_name"];
    $services = implode(', ', $_POST["services"]);  // Convert array to a comma-separated string
    $price = $_POST["price"];
    $priceperservice = $_POST["priceperservice"];
    $duration = $_POST["duration"];
    $durationperservice = $_POST["durationperservice"];

    // Use prepared statement to prevent SQL injection
    $query = "INSERT INTO services (service_name, services, price, priceperservice, duration, durationperservice) 
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $service_name, $services, $price, $priceperservice, $duration, $durationperservice);

    try {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo '<script>alert("Service Added successfully!"); window.location.href = "csservice_adminview.php";</script>';
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

mysqli_close($connection);
?>
