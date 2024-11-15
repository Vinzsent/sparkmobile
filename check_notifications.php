<?php
session_start();
include('config.php');

$userID = $_SESSION['user_id'];
$current_month = date('m');
$current_year = date('Y');

// Check service count
$service_count_query = "SELECT COUNT(*) as service_count 
                       FROM services 
                       WHERE MONTH(last_updated) = '$current_month' 
                       AND YEAR(last_updated) = '$current_year'";

$service_count_result = mysqli_query($connection, $service_count_query);
$service_count = mysqli_fetch_assoc($service_count_result)['service_count'];

$response = [
    'hasNotification' => false,
    'message' => ''
];

if ($service_count < 4) {
    $response['hasNotification'] = true;
    $response['message'] = "Please update your services. Minimum requirement is 4 services per month. Current count: $service_count";
}

header('Content-Type: application/json');
echo json_encode($response);
?> 