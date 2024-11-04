<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$user_id = $_POST['user_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM users WHERE user_id = '$user_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admin-database.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database.php";';
    echo '</script>';
}
?>
