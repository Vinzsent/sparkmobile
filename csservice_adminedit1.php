<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$id = mysqli_real_escape_string($connection, $_POST['id']);
$service_name = mysqli_real_escape_string($connection, $_POST['service_name']);
$services = mysqli_real_escape_string($connection, $_POST['services']);
$price = mysqli_real_escape_string($connection, $_POST['price']);
$shop_id = mysqli_real_escape_string($connection, $_POST['shop_id']);

// Assuming shop_id is stored in session, retrieve it
$shop_id = $_POST['shop_id']; 

// Prepare the SQL statement using placeholders
$sql = "INSERT INTO offered_services (servicename_id, shop_id, service_name, services, price) VALUES (?, ?, ?, ?, ?)";

// Initialize the prepared statement
$stmt = mysqli_prepare($connection, $sql);

// Bind parameters to the statement (i = integer, s = string)
mysqli_stmt_bind_param($stmt, 'iisss', $id, $shop_id, $service_name, $services, $price);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo '<script language="javascript">';
    echo 'alert("Service successfully added!");';
    echo 'window.location = "owner-shop-service-list.php?shop_id=' . $shop_id . '";';
    echo '</script>';
} else {
    echo '<script language="javascript">';
    echo 'alert("Error inserting service: ' . mysqli_error($connection) . '");';
    echo 'window.location = "owner-shop-service-list.php?shop_id=' . $shop_id . '";';
    echo '</script>';
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
