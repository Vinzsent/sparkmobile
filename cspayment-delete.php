<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$total_price_id = $_POST['total_price_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM payment_details WHERE total_price_id = '$total_price_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="csadmin_database-payment.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="csadmin_database-payment.php";';
    echo '</script>';
}
?>
