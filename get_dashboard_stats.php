<?php
session_start();
require_once 'config.php';

// Verify admin/owner access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Owner') {
    http_response_code(403);
    exit('Unauthorized');
}

// Get updated stats
$total_users_query = "SELECT COUNT(*) as total_count FROM users WHERE role = 'User'";
$online_users_query = "SELECT COUNT(*) as online_count FROM users WHERE status = 'online' AND role = 'User' AND last_activity >= NOW() - INTERVAL 5 MINUTE";
$offline_users_query = "SELECT COUNT(*) as offline_count FROM users WHERE (status = 'offline' OR last_activity < NOW() - INTERVAL 5 MINUTE) AND role = 'User'";
$occupied_slots_query = "SELECT COUNT(*) as occupied_slots FROM queuing_slots WHERE is_serving = '1'";

// Execute queries
$total_result = mysqli_query($connection, $total_users_query);
$online_result = mysqli_query($connection, $online_users_query);
$offline_result = mysqli_query($connection, $offline_users_query);
$occupied_slots_result = mysqli_query($connection, $occupied_slots_query);

// Get results
$total_users = mysqli_fetch_assoc($total_result)['total_count'];
$online_count = mysqli_fetch_assoc($online_result)['online_count'];
$offline_count = mysqli_fetch_assoc($offline_result)['offline_count'];
$occupied_slots = mysqli_fetch_assoc($occupied_slots_result)['occupied_slots'];

// Calculate percentages
$online_percentage = ($total_users > 0) ? round(($online_count / $total_users) * 100) : 0;
$offline_percentage = ($total_users > 0) ? round(($offline_count / $total_users) * 100) : 0;

// Calculate slots
$max_slots = 5;
$vacant_slots = max(0, $max_slots - $occupied_slots);

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'total_users' => $total_users,
    'online_count' => $online_count,
    'offline_count' => $offline_count,
    'online_percentage' => $online_percentage,
    'offline_percentage' => $offline_percentage,
    'max_slots' => $max_slots,
    'occupied_slots' => $occupied_slots,
    'vacant_slots' => $vacant_slots
]); 