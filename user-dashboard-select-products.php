<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$user_id = $_GET['user_id'];
$vehicle_id = $_GET['vehicle_id'];
$shop_id = $_GET['shop_id'];
$servicename_id = $_GET['servicename_id'];
$selected_id = $_GET['selected_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$user_query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$user_result = mysqli_query($connection, $user_query);
$userData = mysqli_fetch_assoc($user_result);

$product_query = "SELECT *FROM inventory_records WHERE shop_id = '$shop_id'";
$product_result = mysqli_query($connection, $product_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
    <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <title>SPARK MOBILE </title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap");

    body,
    button {
        font-family: "Poopins", sans-serif;
        margin-top: 20px;
        background-color: #fff;
        color: #fff;
    }

    :root {
        --offcanvas-width: 220px;
        --topNavbarHeight: 56px;
    }

    .sidebar-nav {
        width: var(--offcanvas-width);
        background-color: orangered;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
    }

    .sidebar-link .right-icon {
        display: inline-flex;
    }

    .sidebar-link[aria-expanded="true"] .right-icon {
        transform: rotate(180deg);
    }

    @media (min-width: 992px) {
        body {
            overflow: auto !important;
        }

        main {
            margin-left: var(--offcanvas-width);
        }

        /* this is to remove the backdrop */
        .offcanvas-backdrop::before {
            display: none;
        }

        .sidebar-nav {
            -webkit-transform: none;
            transform: none;
            visibility: visible !important;
            height: calc(100% - var(--topNavbarHeight));
            top: var(--topNavbarHeight);
        }
    }


    .welcome {
        font-size: 15px;
        text-align: center;
        margin-top: 20px;
        margin-right: 15px;
    }

    .me-2 {
        color: #fff;
        font-weight: normal;
        font-size: 13px;

    }

    .me-2:hover {
        background: orangered;
    }

    span {
        color: #fff;
        font-weight: bold;
        font-size: 20px;
    }

    img {
        width: 30px;
        border-radius: 50px;
        display: block;
        margin: auto;
    }

    .img-account-profile {
        width: 80%;
        height: auto;
        border-radius: 50%;
        display: block;
        margin: auto;
    }

    li:hover {
        background: #072797;
    }

    .v-1 {
        background-color: #072797;
        color: #fff;
    }

    .v-2 {
        background-color: orangered;
    }

    .main {
        margin-left: 200px;
    }

    .form-group {
        color: black;
    }

    .dropdown-item:hover {
        background-color: orangered;
        color: #fff;
    }

    .my-4:hover {
        background-color: #fff;
    }

    .navbar {
        background-color: #072797;
    }

    .btn:hover {
        background-color: orangered;
    }

    .nav-links ul li:hover a {
        color: white;
    }

    .img-account-profile {
        width: 200px;
        /* Adjust the size as needed */
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
    }

    .star-icon {
        color: orangered;
    }
</style>

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="smweb.html"><img src="NEW SM LOGO.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <form class="d-flex ms-auto my-3 my-lg-0">
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                    <li class="">
                        <a href="csnotification.php" class="nav-link px-3">
                            <span class="me-2"><i class="fas fa-bell"></i></i></span>
                        </a>
                    </li>
                    <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Visual</a></li>
                        <li>
                            <a class="dropdown-item" href="logout.php">Log out</a>
                        </li>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <li class="my-4">
        <hr class="dropdown-divider bg-primary" />
    </li>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar" <div class="offcanvas-body p-0">
        <nav class="">
            <ul class="navbar-nav">


                <div class=" welcome fw-bold px-3 mb-3">
                    <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?> !</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li>
                <li class="v-1">
                    <a href="user-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="user-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                        <span class="me-2"><i class="fas fa-cars"></i></i></span>
                        <span>MY CARS</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="layouts">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="owner-shop-profile1.php" class="nav-link px-3">
                                    <span class="me-2">Profile</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="ower-shop-service.php" class="nav-link px-3">
                                    <span class="me-2">Services</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#inventory">
                        <span class="me-2"><i class="fas fa-calendar"></i></i></span>
                        <span>INVENTORY</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="inventory">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="owner-dashboard-cleaning-products-shops.php" class="nav-link px-3">
                                    <span class="me-2">Cleaning Products</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="checkingcar.php" class="nav-link px-3">
                                    <span class="me-2">Equipments</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
                        <span class="me-2"><i class="fas fa-user"></i>
                            </i></i></span>
                        <span>EMPLOYEES</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="layouts2">
                        <ul class="navbar-nav ps-3">
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Staff</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Manager</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Cashier</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="owner-application.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-medal"></i>
                            </i></span>
                        <span>APPLICATION</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-sign-out-alt"></i>
                            </i></span>
                        <span>LOG OUT</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    </div>
    <!-- main content -->
    <main>
        <div class="container my-4 text-dark">
            <!-- Top Navigation Bar -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="csservice_view.php?shop_id=<?php echo $shop_id; ?>&vehicle_id=<?php echo $vehicle_id; ?>&servicename_id=<?php echo $servicename_id; ?>&user_id=<?php echo $user_id; ?>">
                    <button class="btn btn-primary mb-5">
                        <i class="bi bi-arrow-left"></i> <!-- Back Icon -->
                        Cancel
                    </button>
                </a>
            </div>
            <h2 class="text-center">Cleaning Products</h2>

            <?php
            // Database connection
            require_once "config.php";

            // Get shop_id from session or request
            $shop_id = $_GET['shop_id']; // Assuming shop_id is stored in session

            // Initialize search term
            $searchTerm = '';
            if (isset($_POST['search'])) {
                $searchTerm = $_POST['search'];
            }

            // Fetch products from inventory_records table for the specific shop with optional search
            $query = "SELECT inventory_id, product_name, profile, price, category, stock_size FROM inventory_records WHERE shop_id = ? AND product_name LIKE ?";
            $stmt = $connection->prepare($query);
            $searchTermLike = "%" . $searchTerm . "%"; // Prepare for partial matches
            $stmt->bind_param("is", $shop_id, $searchTermLike); // Assuming shop_id is an integer and search term is a string
            $stmt->execute();
            $result = $stmt->get_result(); // Get the result set from the prepared statement
            ?>

            <!-- Search Bar -->
            <form method="POST" class="input-group mb-4">
                <input type="text" class="form-control" name="search" placeholder="Search Cleaning Products" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-lg v-2 text-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Product List -->
            <div class="container my-4 text-dark">
                <div class="list-group">
                    <?php
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        while ($productData = $result->fetch_assoc()) {
                            $inventory_id = $productData['inventory_id']; // Get inventory_id from fetched data
                            $product_name = $productData['product_name'];
                            $price = $productData['price'];
                            $profile = $productData['profile'];
                            $category = $productData['category'];
                            $stock_size = $productData['stock_size'];

                            // Display the data as needed
                            echo '<div class="list-group-item d-flex align-items-center mb-3" data-inventory-id="' . $inventory_id . '" data-bs-toggle="modal" data-bs-target="#productModal" ';
                            echo 'data-product-name="' . htmlspecialchars($product_name) . '" ';
                            echo 'data-price="' . htmlspecialchars($price) . '" ';
                            echo 'data-category="' . htmlspecialchars($category) . '" ';
                            echo 'data-stock_size="' . htmlspecialchars($stock_size) . '" ';
                            echo 'data-profile="' . htmlspecialchars($profile) . '">';
                            echo '<img src="' . htmlspecialchars($profile) . '" class="img-fluid me-3" alt="Product Image" style="width: 50px; height: 50px;">';
                            echo '<div class="flex-grow-1"><h6 class="mb-0">' . htmlspecialchars($product_name) . '</h6>';
                            echo '<small class="text-muted">Category: ' . htmlspecialchars($category) . '</small></div>';
                            echo '<div class="text-center me-3"><p class="mb-0">₱' . number_format($price, 2) . '</p></div>';
                            echo '<button class="btn btn-outline-danger"><i class="bi bi-eye"></i> View Product</button>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p class='text-center'>No products available</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Modal Structure -->
            <!-- Modal Structure -->
            <form action="user-dashboard-select-products-backend.php" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id; ?>">
                                <input type="hidden" name="servicename_id" id="servicename_id" value="<?php echo $servicename_id; ?>">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                                <input type="hidden" name="selected_id" id="selected_id" value="<?php echo $selected_id; ?>">
                                <img id="modalProfile" src="" alt="Product Image" class="img-fluid mb-2" style="width: 100%;">
                                <hr>
                                <h6 id="modalProductName"></h6>
                                <i class="bi bi-star-fill star-icon"></i>
                                <i class="bi bi-star-fill star-icon"></i>
                                <i class="bi bi-star-fill star-icon"></i>
                                <i class="bi bi-star-fill star-icon"></i>
                                <i class="bi bi-star-fill star-icon"></i>
                                <p class="mt-2" id="modalCategory"></p>

                                <!-- Updated quantity input group -->
                                <div class="input-group quantity-input mb-3">
                                    <button class="btn btn-danger" type="button" id="button-minus">-</button>
                                    <input type="number" class="form-control text-center" id="quantity-input" name="quantity" value="1" min="1" max="99" style="width: 50px; height: 40px; border-radius: 10px; margin-top: 20px;">
                                    <button class="btn btn-danger" type="button" id="button-plus">+</button>
                                </div>

                                <p id="modalPrice"></p>
                                <p id="modalStock"></p> <!-- Display stock size here -->

                                <input type="hidden" id="hiddenProductName" name="product_name">
                                <input type="hidden" id="hiddenInventoryId" name="inventory_id">
                                <input type="hidden" id="hiddenPrice" name="product_price">
                                <input type="hidden" id="hiddenCategory" name="category">
                                <input type="hidden" id="hiddenProfile" name="profile">
                                <input type="hidden" id="hiddenStock" name="stock_size"> <!-- Hidden input for stock_size -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Buy Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <script>
                document.getElementById('button-minus').addEventListener('click', function() {
                    var quantityInput = document.getElementById('quantity-input');
                    var currentValue = parseInt(quantityInput.value);

                    // Decrease the value, but prevent going below 1
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                document.getElementById('button-plus').addEventListener('click', function() {
                    var quantityInput = document.getElementById('quantity-input');
                    var currentValue = parseInt(quantityInput.value);

                    // Increase the value, but prevent exceeding 99
                    if (currentValue < 99) {
                        quantityInput.value = currentValue + 1;
                    }
                });
            </script>

            <!-- JavaScript to populate the modal dynamically -->
            <script>
    // This will run when the modal is shown
    var productModal = document.getElementById('productModal');
    productModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal

        // Extract the custom data attributes from the clicked element
        var productName = button.getAttribute('data-product-name');
        var productInventoryId = button.getAttribute('data-inventory-id'); // Get the inventory ID
        var price = button.getAttribute('data-price');
        var category = button.getAttribute('data-category');
        var profile = button.getAttribute('data-profile');
        var stock_size = button.getAttribute('data-stock_size'); // Get the stock size

        // Update the modal's content
        var modalProfile = productModal.querySelector('#modalProfile');
        var modalProductName = productModal.querySelector('#modalProductName');
        var modalCategory = productModal.querySelector('#modalCategory');
        var modalPrice = productModal.querySelector('#modalPrice');
        var modalStock = productModal.querySelector('#modalStock');

        // Set the values in the modal
        modalProfile.src = profile; // Set the profile image
        modalProductName.textContent = productName; // Set product name
        modalCategory.textContent = 'Category: ' + category; // Set category
        modalPrice.textContent = '₱' + parseFloat(price).toFixed(2); // Set price
        modalStock.textContent = 'Available Stock: ' + stock_size; // Display stock size

        // Set hidden inputs
        document.getElementById('hiddenProductName').value = productName;
        document.getElementById('hiddenPrice').value = price;
        document.getElementById('hiddenCategory').value = category;
        document.getElementById('hiddenProfile').value = profile;
        document.getElementById('hiddenStock').value = stock_size; // Set stock size

        // Set inventory ID in a hidden input field (if needed)
        document.getElementById('hiddenInventoryId').value = productInventoryId; // Make sure you have this hidden input in your form
    });
</script>


        </div>

    </main>


    <script>
        function updateDateTime() {
            // Get the current date and time
            var currentDateTime = new Date();

            // Format the date and time
            var date = currentDateTime.toDateString();
            var time = currentDateTime.toLocaleTimeString();

            // Display the formatted date and time
            document.getElementById('dateTime').innerHTML = '<p>Date: ' + date + '</p><p>Time: ' + time + '</p>';
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display date and time immediately
        updateDateTime();
    </script>






    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>