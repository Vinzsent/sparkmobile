<?php
    include('config.php');
    include('session.php');
    
    $shop_id = $_POST['shop_id']; // Assuming you have 'user_id' in your session

    if (isset($_FILES['permit']['tmp_name'])) {
        $file = $_FILES['permit']['tmp_name'];
        $permit = addslashes(file_get_contents($_FILES['permit']['tmp_name']));
        $permit_name = addslashes($_FILES['permit']['name']);
        $permit_size = getimagesize($_FILES['permit']['tmp_name']);

        if ($permit_size == FALSE) {
            echo "That's not an image!";
        } else {
            move_uploaded_file($_FILES['permit']['tmp_name'], "uploads/" . $_FILES['permit']['name']);
            $permit = "uploads/" . $_FILES['permit']['name'];

            if (!$update = mysqli_query($connection, "UPDATE shops SET permit = '$permit' WHERE shop_id='$shop_id'")) {
                echo mysqli_error($connection);
            } else {
                header("location: owner-shop-profile-edit.php?shop_id=" . $shop_id);
                exit();
            }
        }
    } else {
        echo "No photo uploaded";
    }
?>
