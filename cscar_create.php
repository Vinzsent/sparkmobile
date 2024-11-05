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
    $profile_path = ''; // Default empty path

    // Handle profile picture upload
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        // File validation
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // Validate file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['profile']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            die('Invalid file type. Only JPG, PNG and GIF are allowed.');
        }

        // Validate file size
        if ($_FILES['profile']['size'] > $max_size) {
            die('File size too large. Maximum size is 5MB.');
        }

        // Create upload directory if it doesn't exist
        $upload_directory = __DIR__ . '/uploads/';
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true);
        }

        // Generate unique filename
        $file_extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . uniqid() . '.' . $file_extension;
        $target_path = $upload_directory . $file_name;
        $profile_path = 'uploads/' . $file_name; // Database path

        // Move uploaded file
        if (!move_uploaded_file($_FILES['profile']['tmp_name'], $target_path)) {
            die('File upload failed. Please try again.');
        }
    }

    try {
        // Prepare and execute the database insertion using prepared statements
        $stmt = $connection->prepare("INSERT INTO vehicles (user_id, label, platenumber, chassisnumber, enginenumber, brand, model, color, profile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $connection->error);
        }

        $stmt->bind_param("issssssss", 
            $userID, 
            $label, 
            $platenumber, 
            $chassisnumber, 
            $enginenumber, 
            $brand, 
            $model, 
            $color, 
            $profile_path
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        // Success message and redirect
        echo '<script>alert("Car registration successful!");</script>';
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'cars-profile.php';
                }, 100);
              </script>";
        exit;

    } catch (Exception $e) {
        // Log the error (you should implement proper error logging)
        error_log("Error in car registration: " . $e->getMessage());
        echo "An error occurred during registration. Please try again later.";
        
        // Clean up uploaded file if database insertion failed
        if (!empty($profile_path) && file_exists($target_path)) {
            unlink($target_path);
        }
    }
}

mysqli_close($connection);
?>