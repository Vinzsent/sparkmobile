<?php
// This file should be called when you want to check for notifications
session_start();
include('config.php');

// Get the current date
$current_date = date('Y-m-d');
$current_day = date('d');

// Only proceed if it's the first day of the month
if ($current_day === '01') {
    // Include and run the notification check
    include('check_service_notifications.php');
    
    echo json_encode([
        'success' => true,
        'message' => 'Monthly notifications generated',
        'date' => $current_date
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Not the first day of the month',
        'date' => $current_date
    ]);
}
?> 