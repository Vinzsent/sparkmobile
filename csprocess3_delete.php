<?php
session_start();

// Include database connection file
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if userId, selectedId, and vehicleId are set
    if(isset($_POST['user_id']) && isset($_POST['selected_id']) && isset($_POST['vehicle_id'])) {
        // Assuming you have a database connection established
        $userId = $_POST['user_id'];
        $selectedId = $_POST['selected_id'];
        $vehicleId = $_POST['vehicle_id'];

        // Implement your logic to delete the specific service from the database
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($connection, "DELETE FROM select_service WHERE user_id = ? AND selected_id = ? AND vehicle_id = ?");
        
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "iii", $userId, $selectedId, $vehicleId); // Assuming all IDs are integers
        $success = mysqli_stmt_execute($stmt);

        // Check if deletion was successful
        if ($success) {
            // Fetch user and vehicle data for redirection
            $query = "SELECT * FROM vehicles WHERE user_id = '$userId' AND vehicle_id = '$vehicleId'";
            $result = mysqli_query($connection, $query);
            $vehicleData = mysqli_fetch_assoc($result);
            $userID = isset($vehicleData['user_id']) ? $vehicleData['user_id'] : '';
            $vehicle_id = isset($vehicleData['vehicle_id']) ? $vehicleData['vehicle_id'] : '';

            // Redirect to csprocess3.php with user_id and vehicle_id parameters
            echo '<script>
            setTimeout(function() {
            window.location.href = "csprocess3_view.php?vehicle_id=' . $vehicle_id . '&user_id=' . $userID . '";
            }, 100); // Redirect after 1 second
            </script>';
            exit(); // Ensure script stops execution after redirection
        } else {
            // Deletion failed
        }

        // Close statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
    } else {
        // Missing parameters
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Missing userId, serviceId, or vehicleId']);
    }

    exit();
}
?>
