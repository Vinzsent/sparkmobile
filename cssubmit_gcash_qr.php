<?php
// Include the database configuration file
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set and not empty
    if(isset($_POST['qrcode']) && !empty($_POST['qrcode']) && ($_POST['user_id']) && !empty($_POST['user_id'])) {
        // Retrieve the G-Cash QR code from the form submission
        $qrcode = $_POST['qrcode'];
        $user_id = $_POST['user_id'];

        // Prepare and execute the SQL query to insert the G-Cash QR code into the database
        $query = "INSERT INTO gcash_qr_codes (qrcode, user_id) VALUES ('$qrcode', '$user_id')";
        $result = mysqli_query($connection, $query);

        // Check if the insertion was successful
        if($result) {
            // Insertion successful
           // Replace the existing success message with this line:
            // Replace the existing success message with these lines:
            echo '<script>alert("G-Cash QR code inserted successfully.");</script>';
            echo '<script>window.location.href = "csgcash.php";</script>';

        } else {
            // Insertion failed
            echo '<p class="text-danger">Error: Failed to insert G-Cash QR code data.</p>';
        }
    } else {
        // Required form fields are missing
        echo '<p class="text-danger">Error: Please provide the G-Cash QR code.</p>';
    }
}
?>
