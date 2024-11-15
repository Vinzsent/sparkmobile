<?php
session_start();
include('config.php');

// Fetch all the required data
$total_users_query = "SELECT COUNT(*) as total_count FROM users WHERE role = 'User'";
$total_result = mysqli_query($connection, $total_users_query);
$total_users_in_db = mysqli_fetch_assoc($total_result)['total_count'];

$online_users_query = "SELECT COUNT(*) as online_count FROM users WHERE status = 'online' AND role != 'Owner'";
$online_result = mysqli_query($connection, $online_users_query);
$online_count = mysqli_fetch_assoc($online_result)['online_count'];

$offline_users_query = "SELECT COUNT(*) as offline_count FROM users WHERE status = 'offline' AND role = 'User'";
$offline_result = mysqli_query($connection, $offline_users_query);
$offline_count = mysqli_fetch_assoc($offline_result)['offline_count'];

$online_percentage = ($total_users_in_db > 0) ? round(($online_count / $total_users_in_db) * 100) : 0;
$offline_percentage = ($total_users_in_db > 0) ? round(($offline_count / $total_users_in_db) * 100) : 0;

$occupied_slots_query = "SELECT COUNT(*) as occupied_slots FROM queuing_slots WHERE is_serving = '1'";
$occupied_slots_result = mysqli_query($connection, $occupied_slots_query);
$occupied_slots = mysqli_fetch_assoc($occupied_slots_result)['occupied_slots'];

$max_slots = 5;
$vacant_slots = $max_slots - $occupied_slots;
$vacant_slots = max(0, $vacant_slots);

// Fetch recent user activities
$user_activities_query = "SELECT 
    u.firstname,
    u.lastname,
    u.activity,
    u.profile,
    ul.login_time,
    u.status
FROM user_logs ul
JOIN users u ON ul.user_id = u.user_id
WHERE u.role = 'User'
ORDER BY ul.login_time DESC
LIMIT 10";

$activities_result = mysqli_query($connection, $user_activities_query);
$user_activities = [];
while ($activity = mysqli_fetch_assoc($activities_result)) {
    $user_activities[] = $activity;
}

// Prepare the response data
$response = [
    'total_users' => $total_users_in_db,
    'online_users' => $online_count,
    'online_percentage' => $online_percentage,
    'offline_users' => $offline_count,
    'offline_percentage' => $offline_percentage,
    'vacant_slots' => $vacant_slots,
    'user_activities' => $user_activities
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

mysqli_close($connection);
?> 