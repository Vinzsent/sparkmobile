<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_id = isset($_POST["vehicle_id"]) ? $_POST["vehicle_id"] : "";
    $userID = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
    $shop_id = isset($_POST["shop_id"]) ? $_POST["shop_id"] : "";
    $body = isset($_POST["body"]) ? $_POST["body"] : "";
    $windshield = isset($_POST["windshield"]) ? $_POST["windshield"] : "";
    $interior = isset($_POST["interior"]) ? $_POST["interior"] : "";
    $sidemirror = isset($_POST["sidemirror"]) ? $_POST["sidemirror"] : "";
    $tires = isset($_POST["tires"]) ? $_POST["tires"] : "";

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO carappearance (vehicle_id, user_id, shop_id, body, windshield, interior, sidemirror, tires) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iiisssss", $vehicle_id, $userID, $shop_id, $body, $windshield, $interior, $sidemirror, $tires);

        // Execute the statement
        try {
            // Check if vehicle exists before inserting
            $vehicleQuery = "SELECT * FROM vehicles WHERE vehicle_id = ?";
            $vehicleStmt = mysqli_prepare($connection, $vehicleQuery);
            mysqli_stmt_bind_param($vehicleStmt, "i", $vehicle_id);
            mysqli_stmt_execute($vehicleStmt);
            $result = mysqli_stmt_get_result($vehicleStmt);
            $vehicleData = mysqli_fetch_assoc($result);

            // Execute the insert statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect after successful insertion
                header('Location: csrequest_slot.php?vehicle_id=' . (isset($vehicleData['vehicle_id']) ? $vehicleData['vehicle_id'] : '') .
                    '&user_id=' . (isset($userID) ? $userID : '') .
                    '&shop_id=' . (isset($shop_id) ? $shop_id : ''));
                exit;
            } else {
                echo "Error executing insert query: " . mysqli_stmt_error($stmt);
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            // Close vehicle statement
            mysqli_stmt_close($vehicleStmt);
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
