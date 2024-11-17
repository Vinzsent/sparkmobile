<?php
session_start();
include('config.php');

// Set headers to prevent caching
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

try {
    // Validate inputs
    if (!isset($_POST['vehicle_id']) || !isset($_POST['user_id']) || !isset($_POST['shop_id'])) {
        throw new Exception('Missing required parameters');
    }

    // Sanitize inputs
    $vehicle_id = mysqli_real_escape_string($connection, $_POST['vehicle_id']);
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $shop_id = mysqli_real_escape_string($connection, $_POST['shop_id']);

    // Prepare and execute delete query
    $delete_query = "DELETE FROM queuing_slots WHERE vehicle_id = ? AND user_id = ? AND shop_id = ?";
    $stmt = mysqli_prepare($connection, $delete_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $vehicle_id, $user_id, $shop_id);
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            echo json_encode(['status' => 'success', 'message' => 'Slot deleted successfully']);
        } else {
            throw new Exception('Failed to delete slot: ' . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception('Failed to prepare statement: ' . mysqli_error($connection));
    }

} catch (Exception $e) {
    // Log error and send response
    error_log('Slot deletion error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Close connection
mysqli_close($connection);
?>
