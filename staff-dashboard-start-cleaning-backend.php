<?php
// Include your database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $servicename_id = isset($_POST['servicename_id']) ? $_POST['servicename_id'] : '';
    $selected_id = isset($_POST['selected_id']) ? $_POST['selected_id'] : '';
    $vehicle_id = isset($_POST['vehicle_id']) ? $_POST['vehicle_id'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $services = isset($_POST['services']) ? $_POST['services'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';

    // Clean and convert total_price
    $total_price = $_POST['total_price'];
    // Remove any non-numeric characters except decimal point
    $total_price = preg_replace('/[^0-9.]/', '', $total_price);
    // Convert to float to handle decimal places
    $total_price = floatval($total_price);

    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : null;
    $is_finished = isset($_POST['is_finished']) ? $_POST['is_finished'] : '0';
    $is_deleted = isset($_POST['is_deleted']) ? $_POST['is_deleted'] : '';
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
    $slotNumber = isset($_POST['slotNumber']) ? $_POST['slotNumber'] : '';


    // Debug output to check values being submitted
    error_log("Total Price: " . $total_price);
    error_log("Form Data: " . print_r($_POST, true));

    // Soft delete data from the queuing_slots table
    $slotNumber_delete = "DELETE FROM queuing_slots WHERE slotNumber = '$slotNumber'";
    if (mysqli_query($connection, $slotNumber_delete)) {
        // Debug message for successful deletion
        error_log("Successfully deleted slot number: " . $slotNumber);
    } else {
        // Error occurred while deleting
        echo "Error deleting slot: " . mysqli_error($connection);
    }

    // Soft delete data from service_details table
    $soft_delete_query = "UPDATE service_details SET is_deleted = 1 WHERE vehicle_id = '$vehicle_id'";
    if (mysqli_query($connection, $soft_delete_query)) {
        // Debug message for successful soft delete
        error_log("Successfully updated is_deleted for vehicle_id: " . $vehicle_id);
    } else {
        // Error occurred while soft deleting
        echo "Error soft deleting record: " . mysqli_error($connection);
    }

    // Format the datetime strings
    if ($start_time) {
        $start_time = date('Y-m-d H:i:s', strtotime($start_time));
    }
    if ($end_time) {
        $end_time = date('Y-m-d H:i:s', strtotime($end_time));
    }

    // Insert data into the database
    $insert_query = "INSERT INTO finish_jobs (
        selected_id, 
        vehicle_id, 
        user_id, 
        servicename_id, 
        services, 
        price, 
        total_price, 
        start_time,
        end_time,
        is_finished,
        is_deleted, 
        product_name, 
        product_price
    ) VALUES (
        '$selected_id', 
        '$vehicle_id', 
        '$user_id', 
        '$servicename_id', 
        '$services', 
        '$price', 
        '$total_price', 
        '$start_time',
        '$end_time',
        '$is_finished',
        '$is_deleted', 
        '$product_name', 
        '$product_price'
    )";

    if (mysqli_query($connection, $insert_query)) {
        // Data inserted successfully
        echo '<script>alert("Service Finish.");</script>';
        echo '<script>window.location.href = "staff-dashboard.php";</script>';
    } else {
        // Error occurred while inserting data
        echo '<script>alert("Error inserting data: ' . mysqli_error($connection) . '");</script>';
    }

    // Close database connection
    mysqli_close($connection);
}
