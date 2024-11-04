<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$selected_id = $_POST['selected_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM service_details WHERE selected_id = '$selected_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("Service deleted successfully!");';
    echo 'window.location="admin-database-service-details.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database-service-details.php";';
    echo '</script>';
}
?>
