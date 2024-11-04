<?php
session_start();
require_once "config.php";

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from the session
    $userID = $_SESSION['user_id'];
    $label = $_POST["label"];
    $platenumber = $_POST["platenumber"];
    $chassisnumber = $_POST["chassisnumber"];
    $enginenumber = $_POST["enginenumber"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $color = $_POST["color"];

    // Handle profile picture upload
    if (isset($_FILES['profile']['tmp_name'])) {
        $file = $_FILES['profile']['tmp_name'];
        $profile = addslashes(file_get_contents($_FILES['profile']['tmp_name']));
        $profile_name = addslashes($_FILES['profile']['name']);
        $profile_size = getimagesize($_FILES['profile']['tmp_name']);

        if ($profile_size == FALSE) {
            echo "Error: That's not an image!";
            exit;
        } else {
            move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $_FILES['profile']['name']);
            $profile_path = "uploads/" . $_FILES['profile']['name'];
        }
    } else {
        $profile_path = ''; // Set default profile path if no file uploaded
    }

    // Insert car details into the vehicles table
    $query = "INSERT INTO vehicles (user_id, label, platenumber, chassisnumber, enginenumber, brand, model, color, profile) 
              VALUES ('$userID', '$label', '$platenumber', '$chassisnumber', '$enginenumber', '$brand', '$model', '$color', '$profile_path')";

    try {
        mysqli_query($connection, $query);
        echo '<script>alert("Car registration successful!");</script>';
        echo "<script>
                    setTimeout(function() {
                        window.location.href = 'cars-profile.php';
                    }, 100); // Redirect after 1 second
                  </script>";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

mysqli_close($connection);
?>
