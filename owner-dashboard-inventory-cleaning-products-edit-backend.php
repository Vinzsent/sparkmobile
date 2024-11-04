<?php
session_start();
require_once "config.php";

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID and product details from the form
    $shop_id = $_POST['shop_id'];
    $product_name = $_POST["product_name"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $item_code = $_POST["item_code"];
    $stock_size = $_POST["stock_size"];
    
    // Get the unique ID or item_code to identify the record to update
    $inventory_id = $_POST['inventory_id'];

    // Initialize $profile_path as an empty string
    $profile_path = '';

    // Handle profile picture upload
    if (isset($_FILES['profile']['tmp_name']) && $_FILES['profile']['tmp_name'] != '') {
        $file = $_FILES['profile']['tmp_name'];
        $profile_name = addslashes($_FILES['profile']['name']);
        $profile_size = getimagesize($_FILES['profile']['tmp_name']);

        if ($profile_size == FALSE) {
            echo "Error: The uploaded file is not an image!";
            exit;
        } else {
            // Move the uploaded file to the 'uploads' directory
            move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $_FILES['profile']['name']);
            $profile_path = "uploads/" . $_FILES['profile']['name'];
        }
    }

    // Construct the update query based on whether a new profile picture is uploaded
    if ($profile_path != '') {
        // Update everything including the new profile picture
        $query = "UPDATE inventory_records 
                  SET shop_id='$shop_id', 
                      product_name='$product_name', 
                      description='$description', 
                      category='$category', 
                      price='$price', 
                      item_code='$item_code', 
                      stock_size='$stock_size', 
                      profile='$profile_path'
                  WHERE inventory_id='$inventory_id'";
    } else {
        // Update without modifying the profile picture
        $query = "UPDATE inventory_records 
                  SET shop_id='$shop_id', 
                      product_name='$product_name', 
                      description='$description', 
                      category='$category', 
                      price='$price', 
                      item_code='$item_code', 
                      stock_size='$stock_size'
                  WHERE inventory_id='$inventory_id'";
    }

    // Execute the update query
    try {
        mysqli_query($connection, $query);
        echo '<script>alert("Product updated successfully!");</script>';
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
