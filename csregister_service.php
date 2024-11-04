<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
	$service_id = isset($_POST["service_id"]) ? $_POST["service_id"] : '';
	$vehicle_id = isset($_POST["vehicle_id"]) ? $_POST["vehicle_id"] : '';

	$query = "INSERT INTO registered (user_id, service_id, vehicle_id) 
	VALUES ('$user_id', '$service_id', '$vehicle_id')";

    $result = mysqli_query($connection, $query);
	
	if ($result) {
        $query1 = "SELECT * FROM registered WHERE user_id= '$user_id' AND vehicle_id= '$vehicle_id' AND service_id= '$service_id'";
        $result1 = mysqli_query($connection, $query1); // Corrected the function name to mysqli()
        $registeredData = mysqli_fetch_assoc($result1);
        
		echo '<script>alert("Registration successful!"); 
        window.location.href = "csprocess5.php?vehicle_id=' . (isset($registeredData['vehicle_id']) ? $registeredData['vehicle_id'] : '') . '&user_id=' . (isset($registeredData['user_id']) ? $registeredData['user_id'] : '') . '&selected_id=' . (isset($registeredData['selected_id']) ? $registeredData['selected_id'] : '') . '";
      </script>';
		exit;
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($connection);
	}
}	
?>
