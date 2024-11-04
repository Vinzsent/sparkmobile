<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$shop_id = $_POST['shop_id'];
$shop_name = $_POST['shop_name'];
$shop_email = $_POST['shop_email'];
$shop_contact = $_POST['shop_contact'];
$website = $_POST['website'];
$operating = $_POST['operating'];
$description = $_POST['description'];
$street_address = $_POST['street_address'];
$optional_address = $_POST['optional_address'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal = $_POST['postal'];

// Prepare the SQL query
$sql = "UPDATE shops SET shop_name = ?, shop_email = ?, shop_contact = ?, website = ?, operating = ?, description = ?, street_address = ?, optional_address = ?, barangay = ?, city = ?, province = ?, postal = ? WHERE shop_id = ?";

// Use prepared statements to prevent SQL injection
$stmt = $connection->prepare($sql);

// Check if the preparation was successful
if ($stmt === false) {
    die("Error preparing statement: " . $connection->error); // Output the error if prepare() fails
}

// Bind the parameters
$stmt->bind_param("ssssssssssssi", $shop_name, $shop_email, $shop_contact, $website, $operating, $description, $street_address, $optional_address, $barangay, $city, $province, $postal, $shop_id);

// Execute the statement
if ($stmt->execute()) {
    echo '<script language="javascript">';
    echo 'alert("Shop Profile successfully updated!");';
    echo 'window.location="owner-shop-profile2.php?shop_id=' . $shop_id . '";';
    echo '</script>';
} else {
    echo '<script language="javascript">';
    echo 'alert("Error updating profile!");';
    echo 'window.location="owner-shop-profile-edit.php";';
    echo '</script>';
}

// Close the statement
$stmt->close();

// Close the connection
$connection->close();
?>
