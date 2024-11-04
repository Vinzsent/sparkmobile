<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Define $vehicleData outside the if-else block






// Function to check if a slot number is available
function isSlotAvailable($userID, $slotNumber, $connection) {
    $checkQuery = "SELECT * FROM queuing_slots WHERE slotNumber = '$slotNumber'";
    $checkResult = mysqli_query($connection, $checkQuery);

    return mysqli_num_rows($checkResult) == 0;
}

// Function to book a slot
function bookSlot($userID, $vehicle_id, $shop_id, $slotNumber, $connection) {
    date_default_timezone_set('Asia/Manila');
    $currentDateTime = new DateTime();
    $currentDateTime->setTimezone(new DateTimeZone('Asia/Manila'));
    $date = $currentDateTime->format('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO queuing_slots (user_id, vehicle_id, shop_id, slotNumber, date) VALUES ('$userID', '$vehicle_id', '$shop_id', '$slotNumber', '$date')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if ($insertResult) {
        echo '<script>alert("Slot requested successfully!");</script>';

        // Fetch user information from the database based on the user's ID
        // Replace this with your actual database query
        $query = "SELECT * FROM queuing_slots WHERE user_id = '$userID' AND vehicle_id = '$vehicle_id'";
        $result = mysqli_query($connection, $query);
        $vehicleData = mysqli_fetch_assoc($result);
        echo '<script>
        setTimeout(function() {
            window.location.href = "csrequestslot_output.php?vehicle_id=' . (isset($vehicleData['vehicle_id']) ? $vehicleData['vehicle_id'] : '') . (isset($vehicleData['user_id']) ? '&user_id=' . $vehicleData['user_id'] : '') . (isset($vehicleData['shop_id']) ? '&shop_id=' . $vehicleData['shop_id'] : '').'";
        }, 100); // Redirect after 1 second
         </script>';

    } else {
        echo '<script>alert("Error requesting slot: ' . mysqli_error($connection) . '");</script>';
    }
}

// Clear slot-related session data
unset($_SESSION['slotNumber']);
unset($_SESSION['date']);

// Main code to handle slot request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $vehicle_id = isset($_POST['vehicle_id']) ? (int)$_POST['vehicle_id'] : 0;
    $shop_id = isset($_POST['shop_id']) && is_numeric($_POST['shop_id']) ? (int)$_POST['shop_id'] : NULL;  // Modified to handle shop_id correctly
    $is_serving = isset($_POST['is_serving']) ? (int)$_POST['is_serving'] : 0;
    


    // Generate slot numbers from 1 to 5 (adjust as needed)
    $availableSlots = [];
    for ($i = 1; $i <= 5; $i++) {
        if (isSlotAvailable($userID, $i, $connection)) {
            $availableSlots[] = $i;
        }
    }

    // Check if there are available slots
    if (count($availableSlots) > 0) {
        // Choose the first available slot
        $slotNumber = $availableSlots[0];

        // Book the selected slot
        bookSlot($userID, $vehicle_id, $shop_id, $slotNumber, $connection);
    } else {
        // Display an alert if all slots are occupied
         // Replace this with your actual database query
         $query = "SELECT * FROM vehicles WHERE user_id = '$userID' AND vehicle_id = '$vehicle_id'";
         $result = mysqli_query($connection, $query);
         $vehicleData = mysqli_fetch_assoc($result);
         
        echo '<script>alert("All slots are occupied. Please come back later.");</script>';
        echo '<script>
        setTimeout(function() {
            window.location.href = "csrequest_slot.php?vehicle_id=' . (isset($vehicleData['vehicle_id']) ? $vehicleData['vehicle_id'] : '') . (isset($vehicleData['user_id']) ? '&user_id=' . $vehicleData['user_id'] : '') . (isset($vehicleData['shop_id']) ? '&shop_id=' . $vehicleData['shop_id'] : '').'";
        }, 100); // Redirect after 1 second
         </script>';

    }
}
?>
