<?php
// add_user.php

session_start();
require_once "config.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input data
    $firstname = $_POST['add_firstname'] ?? '';
    $lastname = $_POST['add_lastname'] ?? '';
    $phonenumber = $_POST['add_phonenumber'] ?? '';
    $completeaddress = $_POST['add_completeaddress'] ?? '';
    $emailaddress = $_POST['add_emailaddress'] ?? '';
    $username = $_POST['add_username'] ?? '';
    $password = $_POST['add_password'] ?? '';

    // Perform additional validation as needed (e.g., checking if required fields are not empty)

    // Prepare and execute the INSERT query
    $query = "INSERT INTO users (firstname, lastname, phonenumber, completeaddress, emailaddress, username, password) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $phonenumber, $completeaddress, $emailaddress, $username, $password);

    $response = array();

    if (mysqli_stmt_execute($stmt)) {
        // Insertion successful
        $response['success'] = true;
    } else {
        // Insertion failed
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Send the JSON response back to the client
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>