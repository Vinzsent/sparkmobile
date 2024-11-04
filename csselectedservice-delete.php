
<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$servicedone_id = $_POST['servicedone_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM finish_jobs WHERE servicedone_id = '$servicedone_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admin-database-finish-jobs.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admin-database-finish-jobs.php";';
    echo '</script>';
}
?>
