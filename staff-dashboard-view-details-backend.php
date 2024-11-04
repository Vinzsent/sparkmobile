<?php
// Include your database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selected_id = isset($_POST['selected_id']) ? $_POST['selected_id'] : '';
    $vehicle_id = isset($_POST['vehicle_id']) ? $_POST['vehicle_id'] : '';
    $servicename_id = isset($_POST['servicename_id']) ? $_POST['servicename_id'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $slotNumber = isset($_POST['slotNumber']) ? $_POST['slotNumber'] : '';
    $inventory_id = isset($_POST['inventory_id']) ? $_POST['inventory_id'] : ''; // The imploded inventory_id list
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0; // Ensure quantity is an integer
    

    // Explode the inventory_ids back into an array
    $inventory_id_array = explode(', ', $inventory_id);

    // Update the status column in the vehicles table
    $query = "UPDATE vehicles SET status = 'Currently Washing' WHERE vehicle_id = $vehicle_id";
    $status_query = "UPDATE service_details SET status = 'Finish' WHERE vehicle_id = $vehicle_id";
    $queuing_query = "UPDATE queuing_slots SET is_serving = 1 WHERE slotNumber = $slotNumber";

    // Execute the queuing query
    if (mysqli_query($connection, $queuing_query)) {
        // Execute the first query for updating vehicle status
        if (mysqli_query($connection, $query)) {
            // Execute the second query for updating service details status
            if (mysqli_query($connection, $status_query)) {
                // Now iterate over each inventory_id and update the stock_size
                foreach ($inventory_id_array as $inventory_id) {
                    $inventory_id = trim($inventory_id); // Clean any extra spaces

                    // Correct the inventory query to subtract quantity from stock_size
                    $inventory_query = "UPDATE inventory_records SET stock_size = stock_size - $quantity WHERE inventory_id = '$inventory_id'";

                    // Execute the inventory query
                    if (!mysqli_query($connection, $inventory_query)) {
                        // Error in updating the inventory stock size
                        echo "Error updating inventory stock size for inventory_id: $inventory_id. " . mysqli_error($connection);
                    }
                }

                // If all inventory updates are successful, redirect the user
                ?>
                <script>
                    var selected_id = "<?php echo $selected_id; ?>";
                    var servicename_id = "<?php echo $servicename_id; ?>";
                    var user_id = "<?php echo $user_id; ?>";
                    window.location.href = 'staff-dashboard-start-cleaning.php?selected_id=' + selected_id + '&servicename_id=' + servicename_id + '&user_id=' + user_id;
                </script>
                <?php
            } else {
                // Error in updating the service details status
                echo "Error updating service status: " . mysqli_error($connection);
            }
        } else {
            // Error in updating the vehicle status
            echo "Error updating vehicle status: " . mysqli_error($connection);
        }
    } else {
        echo "Error updating queuing slot number: " . mysqli_error($connection);
    }

    // Close database connection
    mysqli_close($connection);
}
?>
