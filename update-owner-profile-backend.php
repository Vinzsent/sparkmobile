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

// Prepare the SQL query
$sql = "UPDATE users SET firstname=?, lastname=?, contact=?, street_address=?, email=?, username=?, password=?, gender=?, role=?, optional_address=?, barangay=?, city=?, province=? WHERE user_id=?";

// Use prepared statements to prevent SQL injection
$stmt = $connection->prepare($sql);

// Check if the preparation was successful
if ($stmt === false) {
    die("Error preparing statement: " . $connection->error);
}

// Bind the parameters (there are 14 parameters in total)
$stmt->bind_param(
    "sssssssssssssi", 
    $firstname, 
    $lastname, 
    $contact, 
    $street_address, 
    $email, 
    $username, 
    $password, 
    $gender, 
    $role, 
    $optional_address, 
    $barangay, 
    $city, 
    $province, 
    $user_id
);

// Execute the query and check if it was successful
if ($stmt->execute()) {
    echo '<script language="javascript">';
    echo 'alert("Profile successfully updated!");';
    echo 'window.location="owner-profile.php";';
    echo '</script>';
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Updating!");';
    echo 'window.location="owner-profile.php";';
    echo '</script>';
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
