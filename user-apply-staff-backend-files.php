<?php
session_start();
include('config.php'); // Include your database connection file

// Directory where you want to store the uploaded files
$uploadDir = 'uploads/';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize file paths
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : null;
    $coverletterPath = null;
    $resumePath = null;
    $otherdocumentsPath = null;

    // Check if cover letter file is uploaded
    if (isset($_FILES['coverletter']['name']) && !empty($_FILES['coverletter']['name'])) {
        $coverletterPath = $uploadDir . basename($_FILES['coverletter']['name']);
        if (!move_uploaded_file($_FILES['coverletter']['tmp_name'], $coverletterPath)) {
            echo "Error uploading cover letter.";
        }
    }

    // Check if resume file is uploaded
    if (isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])) {
        $resumePath = $uploadDir . basename($_FILES['resume']['name']);
        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath)) {
            echo "Error uploading resume.";
        }
    }

    // Check if other documents file is uploaded
    if (isset($_FILES['otherdocuments']['name']) && !empty($_FILES['otherdocuments']['name'])) {
        $otherdocumentsPath = $uploadDir . basename($_FILES['otherdocuments']['name']);
        if (!move_uploaded_file($_FILES['otherdocuments']['tmp_name'], $otherdocumentsPath)) {
            echo "Error uploading other documents.";
        }
    }

    // Prepare SQL statement to insert file paths into the database
    $stmt = $connection->prepare("UPDATE application SET coverletter=?, resume=?, otherdocuments=? WHERE user_id= ? AND shop_id= ?");

    if ($stmt === false) {
        die("Error preparing statement: " . $connection->error);
    }

    // Bind parameters (use 's' for strings)
    $stmt->bind_param("sssii", $coverletterPath, $resumePath, $otherdocumentsPath, $user_id, $shop_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script language="javascript">';
        echo 'alert("Files Uploaded Successfully!");';
        echo 'window.location="user-apply-staff-files.php?user_id=' . $user_id . '&shop_id=' . $shop_id . '";'; 
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error saving file paths to the database.");';
        echo 'window.location="user-apply-staff-files.php?user_id=' . $user_id . '&shop_id=' . $shop_id . '";'; 
        echo '</script>';
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
}
?>
