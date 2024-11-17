<?php
session_start();
include('config.php');

function insertMonthlyNotification($connection, $userID, $type, $title, $message, $action_url) {
    // Get the first day of current month
    $firstDayOfMonth = date('Y-m-01');
    
    // Check if notification already exists for this month
    $check_query = "SELECT id FROM notifications 
                   WHERE user_id = ? 
                   AND type = ? 
                   AND DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
    
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, "is", $userID, $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Only insert if no notification exists for this month
    if (mysqli_num_rows($result) == 0) {
        $insert_sql = "INSERT INTO notifications 
                      (user_id, type, title, message, action_url, is_read, created_at) 
                      VALUES (?, ?, ?, ?, ?, 0, ?)";
                      
        $stmt = mysqli_prepare($connection, $insert_sql);
        mysqli_stmt_bind_param($stmt, "isssss", $userID, $type, $title, $message, $action_url, $firstDayOfMonth);
        return mysqli_stmt_execute($stmt);
    }
    return false;
}

// Get current month and year from system date
$current_month = date('m');
$current_year = date('Y');
$first_day_of_month = date('Y-m-01');

// Fetch all shop owners
$owners_query = "SELECT DISTINCT u.user_id, u.firstname, s.shop_name 
                FROM users u 
                JOIN shops s ON u.user_id = s.user_id 
                WHERE u.role = 'Owner'";
$owners_result = mysqli_query($connection, $owners_query);

while ($owner = mysqli_fetch_assoc($owners_result)) {
    $userID = $owner['user_id'];
    $shopName = $owner['shop_name'];
    
    // Check service count for current month
    $service_count_query = "SELECT COUNT(*) as service_count 
                           FROM offered_services 
                           WHERE MONTH(last_updated) = ? 
                           AND YEAR(last_updated) = ? 
                           AND shop_id IN (SELECT shop_id FROM shops WHERE user_id = ?)";
    
    $stmt = mysqli_prepare($connection, $service_count_query);
    mysqli_stmt_bind_param($stmt, "ssi", $current_month, $current_year, $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $service_count = mysqli_fetch_assoc($result)['service_count'];

    // Generate monthly reminder notification
    $notification_message = "Monthly Service Update Reminder for $shopName: " .
                          "Please ensure you have at least 4 updated services this month. " .
                          "Current service count: $service_count";
    
    insertMonthlyNotification(
        $connection,
        $userID,
        'monthly_reminder',
        'Monthly Service Update Reminder',
        $notification_message,
        'owner-shop-service.php'
    );

    // Check for services not updated in the last month
    $outdated_services_query = "SELECT services, last_updated
                               FROM offered_services 
                               WHERE last_updated < DATE_SUB(?, INTERVAL 1 MONTH)
                               AND shop_id IN (SELECT shop_id FROM shops WHERE user_id = ?)";
    
    $stmt = mysqli_prepare($connection, $outdated_services_query);
    mysqli_stmt_bind_param($stmt, "si", $first_day_of_month, $userID);
    mysqli_stmt_execute($stmt);
    $outdated_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($outdated_result) > 0) {
        $outdated_services = [];
        while ($service = mysqli_fetch_assoc($outdated_result)) {
            $outdated_services[] = $service['services'];
        }
        
        if (!empty($outdated_services)) {
            $notification_message = "The following services need updates: " . 
                                  implode(", ", $outdated_services);
            
            insertMonthlyNotification(
                $connection,
                $userID,
                'outdated_services',
                'Services Need Updates',
                $notification_message,
                'owner-shop-service.php'
            );
        }
    }
}

mysqli_close($connection);
?> 