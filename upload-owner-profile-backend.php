<?php
    include('config.php');
    include('session.php');
    
    $user_id = $_SESSION['user_id']; // Assuming you have 'user_id' in your session

    if (isset($_FILES['profile']['tmp_name'])) {
        $file = $_FILES['profile']['tmp_name'];
        $profile = addslashes(file_get_contents($_FILES['profile']['tmp_name']));
        $profile_name = addslashes($_FILES['profile']['name']);
        $profile_size = getimagesize($_FILES['profile']['tmp_name']);

        if ($profile_size == FALSE) {
            echo "That's not an image!";
        } else {
            move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $_FILES['profile']['name']);
            $profile = "uploads/" . $_FILES['profile']['name'];

            if (!$update = mysqli_query($connection, "UPDATE users SET profile = '$profile' WHERE user_id='$user_id'")) {
                echo mysqli_error($connection);
            } else {
                header("location: owner-edit-profile.php");
                exit();
            }
        }
    } else {
        echo "No photo uploaded";
    }
?>
