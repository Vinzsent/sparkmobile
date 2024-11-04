<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : '';
	$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : '';
	$contact = isset($_POST["contact"]) ? $_POST["contact"] : '';
	$address = isset($_POST["address"]) ? $_POST["address"] : '';
	$email = isset($_POST["email"]) ? $_POST["email"] : '';
	$username = isset($_POST["username"]) ? $_POST["username"] : '';
	$password = isset($_POST["password"]) ? $_POST["password"] : '';
	$role = isset($_POST["role"]) ? $_POST["role"] : '';
	$profile = isset($_POST["profile"]) ? $_POST["profile"] : '';
	$gender = isset($_POST["gender"]) ? $_POST["gender"] : '';



	
	$query = "INSERT INTO users (firstname, lastname, contact, address, email, username, password, role, gender, profile) 
	VALUES ('$firstname', '$lastname', '$contact', '$address', '$email', '$username', '$password', '$role', '$gender', '$profile')";

	
	if (mysqli_query($connection, $query)) {
		echo '<script>alert("Registration successful!"); window.location.href = "index.php";</script>';
		exit;
	} else{
		echo "Error: " . $query . "<br>" . mysqli_error($connection);
	}
}	
mysqli_error ($connection);
?>