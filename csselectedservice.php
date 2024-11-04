    <?php
include('config.php');

// Assuming you have a database connection established already

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted
        // Get user and vehicle IDs from the form
        $user_id = $_POST['user_id'];
        $slotNumber = $_POST['slotNumber'];
        $vehicle_id = $_POST['vehicle_id'];
        $servicename_id = $_POST['servicename_id'];
        $status = $_POST['status'];
        $is_deleted = $_POST['is_deleted'];
        $shop_id = $_POST['shop_id'];
        $service = $_POST['service'];
        $price = $_POST['price'];

    // Insert each selected service into the database
    $query = "INSERT INTO service_details (user_id, servicename_id, vehicle_id,  shop_id, service, price, status, slotNumber, is_deleted) VALUES ('$user_id', '$servicename_id', '$vehicle_id',  '$shop_id',  '$service', '$price', '$status','$slotNumber', $is_deleted)";
    $result = mysqli_query($connection, $query);

    // Check if the insertion was successful
    if(!$result) {
        // Handle insertion error
        echo '<p class="text-danger">Error: ' . mysqli_error($connection) . '</p>';
    }
}

        if($result) {
            // Redirect to the view page
            header("Location: csservice_view.php?user_id=$user_id&vehicle_id=$vehicle_id&shop_id=$shop_id&servicename_id=$servicename_id");
            exit; // Make sure to exit after redirection
        } else {
            // Handle insertion error
            echo '<p class="text-danger">Error: Failed to insert service data.</p>';
        }

?>
