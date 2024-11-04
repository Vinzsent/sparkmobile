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


    // Clean and convert total_price
    $total_price = $_POST['total_price'];
    $total_price = intval(preg_replace('/[^\d]/', '', $total_price)); // Ensure it's an integer

    $timer = isset($_POST['timer']) ? $_POST['timer'] : '';
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

    // Insert data into the database
    $insert_query = "INSERT INTO finish_jobs (selected_id, vehicle_id, user_id, servicename_id, services, price, total_price, timer, is_deleted, product_name, product_price) 
                     VALUES ('$selected_id', '$vehicle_id', '$user_id', '$servicename_id', '$services', '$price', '$total_price', '$timer', '$is_deleted', '$product_name', '$product_price')";

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
