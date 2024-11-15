<?php
session_start();
require_once 'config.php';

// Update user status to offline if user is logged in
if (isset($_SESSION['user_id'])) {
    // Database connection
    $user_ID = $_SESSION['user_id'];
    $sql = "UPDATE users SET status = 'offline' WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_ID]);
    
    // Destroy session and redirect
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    // If no user is logged in, just redirect
    header("Location: index.php");
    exit();
}
?>