<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$vehicle_id = $_POST['vehicle_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM vehicles WHERE vehicle_id = '$vehicle_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("Vehicle deleted successfully!");';
    echo 'window.location="admin-database.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database.php";';
    echo '</script>';
}
?>
