<?php
// edit_vehicle.php
session_start();
include('config.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input data
    $userID = $_POST['edit_user_id'] ?? '';
    $label = $_POST['edit_label'] ?? '';
    $platenumber =$_POST['edit_platenumber'] ?? '';
    $chassisnumber = $_POST['edit_chassisnumber'] ?? '';
    $enginenumber = $_POST['edit_enginenumber'] ?? '';
    $model = $_POST['edit_model'] ?? '';
    $color = $_POST['edit_color'] ?? '';
    $size = $_POST['edit_size'] ?? '';

    // Perform additional validation as needed (e.g., checking if required fields are not empty)

    // Prepare and execute the UPDATE query using parameterized statements
    $query = "UPDATE vehicles SET user_id = ?,label = ?, platenumber = ?, chassisnumber = ?, enginenumber = ?, model = ?, color = ?, size = ? WHERE vehicle_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "isssssssi", $label, $platenumber, $chassisnumber, $enginenumber, $model, $color, $size, $vehicleID);

    $response = array();

    if (mysqli_stmt_execute($stmt)) {
        // Update successful
        $response['success'] = true;
    } else {
        // Update failed
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Send the JSON response back to the client
    header("cars-profile.php");
    echo json_encode($response);
}
?>