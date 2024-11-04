<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$service_name = mysqli_real_escape_string($connection, $_POST['service_name']);
$shop_id = mysqli_real_escape_string($connection, $_POST['shop_id']);

// Use prepared statements to prevent SQL injection
$sql = "INSERT INTO service_names (service_name, shop_id) VALUES (?, ?)";
$stmt = mysqli_prepare($connection, $sql);

// Bind parameters (s = string, i = integer)
mysqli_stmt_bind_param($stmt, 'si', $service_name, $shop_id);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo '<script language="javascript">';
    echo 'alert("Service successfully added!");';
    echo 'window.location.href = "owner-shop-service-list.php?shop_id=' . $shop_id . '";';
    echo '</script>';
} else {
    echo '<script language="javascript">';
    echo 'alert("Error inserting service: ' . mysqli_error($connection) . '");';
    echo 'window.location="csservice_adminview.php";';
    echo '</script>';
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
