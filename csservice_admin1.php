<?php
// Database connection parameters
include('config.php');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the service name
    if (isset($_POST['service_name'])) {
        $service_name = $connection->real_escape_string($_POST['service_name']);
        $price = $connection->real_escape_string($_POST['price']);
        $duration = $connection->real_escape_string($_POST['duration']);
        $priceperservice = $connection->real_escape_string($_POST['priceperservice']);
        $durationperservice = $connection->real_escape_string($_POST['durationperservice']);

        // Process the services array
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            // You should perform proper validation and sanitation here
            $services = implode(", ", array_map(array($connection, 'real_escape_string'), $_POST['services']));

            // Insert the service name and services into the database
            $query = "INSERT INTO services (service_name, services, price, duration, priceperservice, durationperservice) VALUES ('$service_name', '$services', '$price', '$duration', '$priceperservice', '$durationperservice')";

            // Execute the query and check for success
            if ($connection->query($query) === TRUE) {
                echo '<script>alert("Service Added Successfully!"); window.location.href = "csservice_adminview.php";</script>';
                exit;
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }
        }
    }
}

// Close the database connection
$connection->close();
?>
