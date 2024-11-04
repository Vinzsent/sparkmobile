<?php
session_start();
include('config.php');



    // Retrieve and sanitize form data
    $user_id = $_POST['user_id'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$contact = $_POST['contact'];
	$street_address = $_POST['street_address'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $optional_address = $_POST['optional_address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', contact='$contact',street_address='$street_address', email='$email', username='$username', password='$password', gender='$gender', role='$role', optional_address='$optional_address', barangay='$barangay', city='$city', province='$province' WHERE user_id = '$user_id'";
	if(mysqli_query($connection, $sql)){
	echo '<script language="javascript">';
	echo 'alert("Profile successfully updated!");';
	echo 'window.location="user-profile.php";';
	echo'</script>';	
} else {
	echo'<script language="javascript">';
	echo'alert("Error Updating!");';
	echo'window.location="user-profile.php";';
	echo '</script>';
}
?>