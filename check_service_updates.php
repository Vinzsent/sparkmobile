<?php
session_start();
include('config.php');

header('Content-Type: application/json');

$userID = $_SESSION['user_id'];
$response = [
    'hasNotification' => false,
    'notifications' => []
];

// Check for outdated services
$outdated_services_query = "SELECT 
    s.service_name,
    s.last_updated,
    DATEDIFF(NOW(), s.last_updated) as days_since_update
FROM offered_services s
WHERE (s.last_updated < DATE_SUB(NOW(), INTERVAL 1 MONTH)
    OR s.last_updated IS NULL)";

$result = mysqli_query($connection, $outdated_services_query);

if ($result && mysqli_num_rows($result) > 0) {
    $response['hasNotification'] = true;
    
    while ($service = mysqli_fetch_assoc($result)) {
        $response['notifications'][] = [
            'service' => $service['service_name'],
            'last_updated' => $service['last_updated'],
            'days_since_update' => $service['days_since_update']
        ];
    }
}

// Check for services count
$current_month = date('m');
$current_year = date('Y');

$service_count_query = "SELECT COUNT(*) as service_count 
                       FROM offered_services 
                       WHERE MONTH(last_updated) = '$current_month' 
                       AND YEAR(last_updated) = '$current_year'";

$count_result = mysqli_query($connection, $service_count_query);
$service_count = mysqli_fetch_assoc($count_result)['service_count'];

if ($service_count < 4) {
    $response['hasNotification'] = true;
    $response['notifications'][] = [
        'type' => 'count_warning',
        'message' => "You need to add more services. Current count: $service_count (minimum required: 4)"
    ];
}

echo json_encode($response);
?> 