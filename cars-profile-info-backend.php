<?php
session_start();
include('config.php');



    // Retrieve and sanitize form data
    $vehicle_id = $_POST['vehicle_id'];
	$label = $_POST['label'];
	$platenumber = $_POST['platenumber'];
	$chassisnumber = $_POST['chassisnumber'];
	$enginenumber = $_POST['enginenumber'];
	$brand = $_POST['brand'];
	$model = $_POST['model'];
	$color = $_POST['color'];

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE vehicles SET label='$label', platenumber='$platenumber', chassisnumber='$chassisnumber',enginenumber='$enginenumber', brand='$brand', model='$model', color='$color' WHERE vehicle_id = '$vehicle_id'";
	if(mysqli_query($connection, $sql)){
	echo '<script language="javascript">';
	echo 'alert("Vechicle details successfully updated!");';
	echo 'window.location="cars-profile.php";';
	echo'</script>';	
} else {
	echo'<script language="javascript">';
	echo'alert("Error Updating!");';
	echo'window.location="cars-profile.php";';
	echo '</script>';
}
?>