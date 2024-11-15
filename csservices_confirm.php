<?php
session_start();
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $servicename_id = mysqli_real_escape_string($connection, $_POST['servicename_id']);
    $service_id = mysqli_real_escape_string($connection, $_POST['service_id']);
    $services = mysqli_real_escape_string($connection, $_POST['services']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $shop_id = $_POST['shop_id'];
    $userID = $_SESSION['user_id']; // Get user ID from session

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE offered_services SET services=?, price=?, last_updated=NOW() WHERE service_id=?";
    $stmt = mysqli_prepare($connection, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ssi", $services, $price, $service_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Get current service count from notification
        $count_query = "SELECT id, service_count FROM notifications 
                       WHERE user_id = '$userID' 
                       AND type = 'service_update'
                       ORDER BY created_at DESC LIMIT 1";
        $count_result = mysqli_query($connection, $count_query);
        $notification = mysqli_fetch_assoc($count_result);
        
        $current_count = isset($notification['service_count']) ? $notification['service_count'] : 0;
        $new_count = $current_count + 1;
        
        if ($new_count >= 4) {
            // Delete notification if requirement is met
            $delete_query = "DELETE FROM notifications 
                           WHERE user_id = '$userID' 
                           AND type = 'service_update'";
            mysqli_query($connection, $delete_query);
        } else {
            // Update notification with new count
            $remaining = 4 - $new_count;
            $update_message = "This is a reminder to update your services. Minimum requirement is 4 services per month. Current count: $new_count";
            
            if (isset($notification['id'])) {
                // Update existing notification
                $update_query = "UPDATE notifications 
                               SET service_count = '$new_count',
                                   message = '$update_message',
                                   is_read = 0
                               WHERE id = '{$notification['id']}'";
                mysqli_query($connection, $update_query);
            } else {
                // Create new notification if none exists
                $insert_query = "INSERT INTO notifications 
                               (user_id, type, title, message, action_url, is_read, created_at, service_count)
                               VALUES 
                               ('$userID', 
                                'service_update', 
                                'Service Update Required', 
                                '$update_message', 
                                'owner-shop-service.php', 
                                0, 
                                NOW(), 
                                '$new_count')";
                mysqli_query($connection, $insert_query);
            }
        }

        // Show success message and redirect
        echo '<script language="javascript">';
        echo 'alert("Service details successfully updated!");';

        // Fetch the updated service data
        $query = "SELECT s.*, sn.service_name 
                 FROM offered_services s
                 JOIN service_names sn ON s.servicename_id = sn.servicename_id
                 WHERE s.service_id = '$service_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $servicenameData = mysqli_fetch_assoc($result);
            echo 'window.location.href = "owner-shop-service-list-view.php?servicename_id=' 
                . (isset($servicenameData['servicename_id']) ? $servicenameData['servicename_id'] : '') 
                . (isset($servicenameData['service_id']) ? '&service_id=' . $servicenameData['service_id'] : '') 
                . (isset($servicenameData['shop_id']) ? '&shop_id=' . $servicenameData['shop_id'] : '') 
                . '"';
        } else {
            echo 'alert("Error fetching updated service data!");';
            echo 'window.location.href = "csservice_adminedit3.php";';
        }
        echo '</script>';
    } else {
        // Redirect with error message
        echo '<script language="javascript">';
        echo 'alert("Error updating service details!");';
        echo 'window.location.href = "csservice_adminedit3.php";';
        echo '</script>';
    }
} else {
    // Handle non-POST requests
    echo '<script language="javascript">';
    echo 'alert("Form submission error!");';
    echo 'window.location.href = "csservice_adminedit3.php";';
    echo '</script>';
}

mysqli_close($connection);
?>
