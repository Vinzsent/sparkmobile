<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$selected_id = $_POST['selected_id'];
$user_id = $_POST['user_id'];
$shop_id = $_POST['shop_id'];
$vehicle_id = $_POST['vehicle_id'];


// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM service_details WHERE selected_id = ? AND shop_id = ? AND vehicle_id = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "iii", $selected_id, $shop_id, $vehicle_id); // Assuming selected_id is an integer

if (mysqli_stmt_execute($stmt)) {
    // Redirect after successful deletion
    header("Location: user-service-summary.php?");
    exit(); // Make sure to exit after the redirect
} else {
    // Optionally handle the error here, e.g., log it
    $_SESSION['error_message'] = 'Error deleting record: ' . mysqli_error($connection);
    
    // Redirect to the same page or another error handling page
    header("Location: user-service-summary.php?");
    exit(); // Ensure to exit after redirect
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connection);
?>
