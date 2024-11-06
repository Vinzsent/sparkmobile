<?php
session_start();

// Update user status to offline if user is logged in
if (isset($_SESSION['user_id'])) {
    // Database connection
    require_once 'config.php';
    
    $user_ID = $_SESSION['user_id'];
    $sql = "UPDATE users SET status = 'offline' WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_ID]);
}

// Destroy session and redirect
session_destroy();
header("Location: index.php");
exit();
?>