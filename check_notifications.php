<?php
session_start();
include('config.php');

// Add error handling
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$userID = $_SESSION['user_id'];
$current_month = date('m');
$current_year = date('Y');

try {
    // Get shop information
    $shop_query = "SELECT shop_name FROM shops WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $shop_query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $shop_result = mysqli_stmt_get_result($stmt);
    $shop_data = mysqli_fetch_assoc($shop_result);
    $shop_name = $shop_data ? $shop_data['shop_name'] : 'your shop';

    // Check service count with prepared statement
    $service_count_query = "SELECT COUNT(*) as service_count 
                           FROM offered_services 
                           WHERE shop_id IN (SELECT shop_id FROM shops WHERE user_id = ?)
                           AND MONTH(last_updated) = ? 
                           AND YEAR(last_updated) = ?";

    $stmt = mysqli_prepare($connection, $service_count_query);
    mysqli_stmt_bind_param($stmt, "iss", $userID, $current_month, $current_year);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $service_count = mysqli_fetch_assoc($result)['service_count'];

    $response = [
        'hasNotification' => false,
        'message' => '',
        'service_count' => $service_count
    ];

    if ($service_count < 4) {
        $response['hasNotification'] = true;
        $response['message'] = "Please update services for $shop_name. Minimum requirement is 4 services per month. Current count: $service_count";
        
        // Insert into notifications table if not already exists for this month
        $notification_query = "INSERT INTO notifications 
                             (user_id, type, title, message, action_url, is_read, created_at, notification_month) 
                             SELECT ?, 'service_update', 'Service Update Required', ?, 'owner-shop-service.php', 0, NOW(), DATE_FORMAT(NOW(), '%Y-%m')
                             WHERE NOT EXISTS (
                                 SELECT 1 FROM notifications 
                                 WHERE user_id = ? 
                                 AND type = 'service_update' 
                                 AND notification_month = DATE_FORMAT(NOW(), '%Y-%m')
                             )";
        
        $stmt = mysqli_prepare($connection, $notification_query);
        mysqli_stmt_bind_param($stmt, "isi", $userID, $response['message'], $userID);
        mysqli_stmt_execute($stmt);
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error in check_notifications.php: " . $e->getMessage());
    echo json_encode([
        'error' => 'An error occurred while checking notifications',
        'hasNotification' => false,
        'message' => ''
    ]);
}

mysqli_close($connection);
?> 