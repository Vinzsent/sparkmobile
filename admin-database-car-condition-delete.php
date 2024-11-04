<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$condition_id = $_POST['condition_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM carcondition_details WHERE condition_id = '$condition_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("Car Condition deleted successfully!");';
    echo 'window.location="admin-database-car-condition.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database-car-condition.php";';
    echo '</script>';
}
?>
