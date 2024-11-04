<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$shop_name = $_POST["shop_name"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$contact = $_POST["contact"];
	$email = $_POST["email"];
	$username = $_POST["username"];
	$password = $_POST["password"];

	
	$query = "INSERT INTO shopowners (shop_name, firstname, lastname, contact, email, username, password) 
	VALUES ('$shop_name', '$firstname', '$lastname', '$contact',  '$email', '$username', '$password')";

	
	if (mysqli_query($connection, $query)) {
		echo '<script>alert("Registration successful!"); window.location.href = "cslogin_admin.html";</script>';
		exit;
	} else{
		echo "Error: " . $query . "<br>" . mysqli_error($connection);
	}
}	
mysqli_error ($connection);
?>