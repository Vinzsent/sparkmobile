<?php
session_start();
include('config.php');

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    
    // Query to count unread notifications
    $query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_fetch_assoc($result)['count'];
    
    header('Content-Type: application/json');
    echo json_encode(['count' => $count]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['count' => 0]);
}

mysqli_close($connection);
?> 