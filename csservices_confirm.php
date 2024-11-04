<?php
session_start();
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $servicename_id = mysqli_real_escape_string($connection, $_POST['servicename_id']);
    $service_id = mysqli_real_escape_string($connection, $_POST['service_id']);
    $services = mysqli_real_escape_string($connection, $_POST['services']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $shop_id = $_POST['shop_id'];

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE offered_services SET services=?, price=? WHERE service_id=?";
    $stmt = mysqli_prepare($connection, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ssi", $services, $price, $service_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect with success message
        echo '<script language="javascript">';
        echo 'alert("Service details successfully updated!");';

        // Fetch the updated service data
        $query = "SELECT s.*, sn.service_name 
          FROM offered_services s
          JOIN service_names sn ON s.servicename_id = sn.servicename_id
          WHERE s.service_id = '$service_id'";

        // Execute the query and fetch the service data
        $result = mysqli_query($connection, $query);

        if ($result) {
            $servicenameData = mysqli_fetch_assoc($result);
            echo 'window.location.href = "owner-shop-service-list.php?servicename_id=' 
            . (isset($servicenameData['servicename_id']) ? $servicenameData['servicename_id'] : '') 
            . (isset($servicenameData['service_id']) ? '&service_id=' . $servicenameData['service_id'] : '') 
            . (isset($servicenameData['shop_id']) ? '&shop_id=' . $servicenameData['shop_id'] : '') 
            . '"';
        
        } else {
            echo 'alert("Error fetching updated service data!");';
            echo 'window.location.href = "csservice_adminedit3.php";';
        }
        echo '</script>';
    } else {
        // Redirect with error message
        echo '<script language="javascript">';
        echo 'alert("Error updating service details!");';
        echo 'window.location.href = "csservice_adminedit3.php";';
        echo '</script>';
    }
} else {
    // Handle the case where the form is not submitted
    echo '<script language="javascript">';
    echo 'alert("Form submission error!");';
    echo 'window.location.href = "csservice_adminedit3.php";';
    echo '</script>';
}
?>
