<?php
// Include database configuration
include('config.php');

// Check if user ID or file type is provided
if (isset($_GET['application_id']) && isset($_GET['file_type'])) {
    $application_id = $_GET['application_id'];
    $coverletter = $_GET['coverletter']; // Can be 'coverletter', 'resume', 'otherdocuments'

    // Prepare SQL query to get the file
    $stmt = $connection->prepare("SELECT coverletter FROM application WHERE application_id = ?");
    $stmt->bind_param("i", $application_id);
    
    // Execute the query
    $stmt->execute();
    $stmt->store_result();
    
    // Check if the file exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($file_data);
        $stmt->fetch();

        // Specify headers to prompt download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_type . '-' . $application_id . '"');
        header('Content-Length: ' . strlen($file_data));

        // Output the file data
        echo $file_data;
        exit();
    } else {
        echo "File not found.";
    }
    
    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
