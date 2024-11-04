<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$appearance_id = $_POST['appearance_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM carappearance WHERE appearance_id = '$appearance_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("Car Appearance deleted successfully!");';
    echo 'window.location="admin-database-car-appearance.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database-car-appearance.php";';
    echo '</script>';
}
?>
