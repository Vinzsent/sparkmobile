<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$selected_id = $_POST['selected_id'];
$user_id = $_POST['user_id'];
$vehicle_id = $_POST['vehicle_id'];
$shop_id = $_POST['shop_id'];
$servicename_id = $_POST['servicename_id'];


// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM service_details WHERE selected_id = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $selected_id); // Assuming selected_id is an integer

if (mysqli_stmt_execute($stmt)) {
    // Redirect after successful deletion
    header("Location: csservice_view.php?user_id=$user_id&vehicle_id=$vehicle_id&shop_id=$shop_id&servicename_id=$servicename_id");
    exit(); // Make sure to exit after the redirect
} else {
    // Optionally handle the error here, e.g., log it
    $_SESSION['error_message'] = 'Error deleting record: ' . mysqli_error($connection);
    
    // Redirect to the same page or another error handling page
    header("Location: csservice_view.php?user_id=$user_id&vehicle_id=$vehicle_id&shop_id=$shop_id&servicename_id=$servicename_id");
    exit(); // Ensure to exit after redirect
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connection);
?>
