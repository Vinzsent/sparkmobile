<?php
session_start();
include('config.php');

// Get notification ID and type from URL parameters
$notification_id = isset($_GET['id']) ? $_GET['id'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$user_id = $_SESSION['user_id'];

if ($notification_id && $type) {
    if ($type == 'service_update') {
        // Get current service count
        $count_query = "SELECT service_count FROM notifications 
                       WHERE id = '$notification_id' AND user_id = '$user_id'";
        $count_result = mysqli_query($connection, $count_query);
        $notification = mysqli_fetch_assoc($count_result);
        
        $current_count = $notification['service_count'];
        $new_count = $current_count + 1;
        
        if ($new_count >= 4) {
            // Delete notification if 4 services are updated
            $delete_query = "DELETE FROM notifications 
                           WHERE id = '$notification_id' AND user_id = '$user_id'";
            mysqli_query($connection, $delete_query);
        } 
        
        // Redirect to service update page
        header('Location: ower-shop-service.php');
        exit();
    }
    // Handle other notification types here
} else {
    header('Location: notification.php');
    exit();
}
?> 