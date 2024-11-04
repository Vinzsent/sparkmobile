<?php
session_start();

// Include database connection file
include('erwinconfig.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $completeadd = $_POST['completeadd'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate the form data (you may add more robust validation)
    if (empty($firstname) || empty($lastname) || empty($contact) || empty($completeadd) || empty($email) || empty($username) || empty($password))  {
        echo "All fields are required.";
        exit;
    }

    // Assuming you have a user ID stored in the session
    $userID = $_SESSION['user_id'];

    // Update the user's profile in the database
    $query = "UPDATE carowners SET firstname='$firstname', lastname='$lastname', contact='$contact', completeadd='$completeadd', email='$email', username='$username', password='$password' WHERE id=$userID";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Profile updated successfully.');</script>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'csdashboard.php';
            }, 1000); // Redirect after 1 second
        </script>";
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not POST, redirect to the edit profile page
    header("Location: edit_csdashboard.php");
    exit;
}
?>
