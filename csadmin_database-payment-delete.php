<?php

session_start();
include('config.php');

$payment_id = $_POST['payment_id'];


$delete_query = "DELETE FROM payment_details WHERE payment_id = '$payment_id'";

if(mysqli_query($connection, $delete_query)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admin-database-payment.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database-payment.php";';
    echo '</script>';
}


?>