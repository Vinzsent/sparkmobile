<?php
include_once ('config.php');

// Get the user ID and position from the form
$user_id = $_POST['user_id'];
$application_id = $_POST['application_id'];
$position = $_POST['position'];

// Check for a valid position before updating (optional, but good practice)

    // Update the user's role to 'Staff' based on the user ID
    $query = "UPDATE users SET role = 'Staff' WHERE user_id = '$user_id'";

    if ($connection->query($query) === TRUE) {
        // If the update is successful, redirect or show success message
        echo '<script language="javascript">';
        echo 'alert("Application Accepted!");';
        echo 'window.location.href = "owner-application.php";'; // Redirect to user management page or another page
        echo '</script>';
    } else {
        // If there's an error with the query, show error message
        echo '<script language="javascript">';
        echo 'alert("Error accepting application: ' . $connection->error . '");';
        echo 'window.location.href = "owner-application-profile.php?application_id=' . $application_id . '";'; // Redirect to an error page
        echo '</script>';
    }
// Close the database connection
$connection->close();
?>
