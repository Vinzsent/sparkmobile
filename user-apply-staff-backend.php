<?php
session_start();
include('config.php');

// Get form data
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : null;
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$contact = isset($_POST['contact']) ? $_POST['contact'] : null;
$position = isset($_POST['position']) ? $_POST['position'] : null;
$interviewdate = isset($_POST['interviewdate']) ? $_POST['interviewdate'] : null;


// Prepare the SQL statement
$stmt = $connection->prepare("INSERT INTO application (user_id, shop_id, firstname, lastname, email, contact, position, interviewdate) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Error preparing statement: " . $connection->error);
}

$stmt->bind_param(
    "iissssss", 
    $user_id,
    $shop_id, 
    $firstname, 
    $lastname, 
    $email, 
    $contact, 
    $position, 
    $interviewdate, 
    
);

// Execute the statement
if ($stmt->execute()) {
    echo '<script language ="javascript">';
    echo 'window.location="user-apply-staff-files.php?user_id=' . $user_id . '&shop_id=' . $shop_id . '";';
    echo '</script>';
} else {
    echo '<script language="javascript">';
    echo 'alert("Application Error!");';
    echo 'window.location="user-apply-staff.php?user_id=' . $user_id . '&shop_id=' . $shop_id . '";';
    echo '</script>';
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
