<?php
// Assuming you have established a database connection

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the vehicle_id and user_id from the POST request
    $vehicle_id = $_POST['vehicle_id'];
    $user_id = $_POST['user_id'];
    
    // Perform the deletion operation in the database
    // Here, replace 'slots' with the actual table name where slot numbers are stored
    // Also, ensure proper validation and sanitization of user input to prevent SQL injection

    // Execute the deletion query to remove the slot number
    $query = "DELETE FROM slots WHERE vehicle_id = '$vehicle_id' AND user_id = '$user_id'";
    $result = mysqli_query($connection, $query);

    // Check if deletion was successful
    if ($result) {
        // Return a success message
        echo json_encode(array("status" => "success", "message" => "Slot number deleted successfully"));
    } else {
        // Return an error message if deletion failed
        echo json_encode(array("status" => "error", "message" => "Error deleting slot number: " . mysqli_error($connection)));
    }
} else {
    // Return an error message if the request method is not POST
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
