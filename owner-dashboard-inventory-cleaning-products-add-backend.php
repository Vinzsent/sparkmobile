<?php
session_start();
require_once "config.php";

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from the session
    $shop_id = $_POST['shop_id'];
    $product_name = $_POST["product_name"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $item_code = $_POST["item_code"];
    $stock_size = $_POST["stock_size"];

    // Handle profile picture upload
    if (isset($_FILES['profile']['tmp_name'])) {
        $file = $_FILES['profile']['tmp_name'];
        $profile = addslashes(file_get_contents($_FILES['profile']['tmp_name']));
        $profile_name = addslashes($_FILES['profile']['name']);
        $profile_size = getimagesize($_FILES['profile']['tmp_name']);

        if ($profile_size == FALSE) {
            echo "Error: That's not an image!";
            exit;
        } else {
            move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $_FILES['profile']['name']);
            $profile_path = "uploads/" . $_FILES['profile']['name'];
        }
    } else {
        $profile_path = ''; // Set default profile path if no file uploaded
    }

    // Insert car details into the vehicles table
    $query = "INSERT INTO inventory_records (shop_id, product_name, description, category, price, item_code, stock_size, profile) 
              VALUES ('$shop_id', '$product_name', '$description', '$category', '$price', '$item_code', '$stock_size', '$profile_path')";

    try {
        mysqli_query($connection, $query);
        echo '<script>alert("Product added successful!");</script>';
        echo "<script>
                    setTimeout(function() {
                       window.location.href = 'owner-dashboard-inventory-cleaning-products.php?shop_id=" . $shop_id . "';
                    }, 100); // Redirect after 1 second
                  </script>";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

mysqli_close($connection);
?>
