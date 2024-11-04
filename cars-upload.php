<?php
    include('config.php');
    include('session.php');
    
    

    if (isset($_FILES['profile']['tmp_name'])) {
        $file = $_FILES['profile']['tmp_name'];
        $profile = addslashes(file_get_contents($_FILES['profile']['tmp_name']));
        $profile_name = addslashes($_FILES['profile']['name']);
        $profile_size = getimagesize($_FILES['profile']['tmp_name']);
        $vehicle_id = $_POST['vehicle_id']; // Assigning the value of vehicle_id from the form

        if ($profile_size == FALSE) {
            echo "That's not an image!";
        } else {
            move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $_FILES['profile']['name']);
            $profile = "uploads/" . $_FILES['profile']['name'];

            // Update the profile picture for the specified vehicle_id and user_id
            $update_query = "UPDATE vehicles SET profile = '$profile' WHERE vehicle_id = '$vehicle_id'";

            if (!$update_result = mysqli_query($connection, $update_query)) {
                echo "Error: " . mysqli_error($connection);
            } else {
                header("Location: cars-profile-info.php?vehicle_id=" . $vehicle_id); // Redirect to the specified page
                exit();
            }
        }
    } else {
        echo "No photo uploaded";
    }
?>
