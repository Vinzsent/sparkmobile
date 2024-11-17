<?php
session_start();
include('config.php'); // Ensure you include the correct path to your config.php

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch user information based on ID
$user_id = $_SESSION['user_id'];

$user_query = "SELECT * FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($connection, $user_query);
$userData  = mysqli_fetch_assoc($user_result);


// Retrieve the shop_id from session or any other method you're using
$shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : '';

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Check if shop_id is set
if (!isset($shop_id) || empty($shop_id)) {
    echo "Shop ID is not set.";
    exit; // Stop further execution
}

// Base query to fetch products
$product_query = "SELECT *FROM inventory_records WHERE shop_id = '$shop_id'";

// Add search conditions if the user has entered a search term
if ($search != '') {
    $product_query .= " AND (product_name LIKE '%$search%' 
    OR description LIKE '%$search%' 
    OR category LIKE '%$search%' 
    OR stock_size LIKE '%$search%' 
    OR price LIKE '%$search%')";
}

// Execute the query and get the result
$product_result = mysqli_query($connection, $product_query);

// Check for query execution errors
if (!$product_result) {
    echo "Error executing query: " . mysqli_error($connection);
    exit; // Stop if there is an error
}


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
        width: 50px;
        /* Adjust the size as needed */
        height: 50px;
        object-fit: cover;
        border-radius: 1%;
    }

    .product-table {
        margin-top: 50px;
    }

    .table thead th {
        border-bottom: none;
    }

    .status-active {
        color: white;
        background-color: #8e44ad;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .status-soldout {
        color: white;
        background-color: #e74c3c;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .status-lowstock {
        color: white;
        background-color: #f39c12;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .btn-rectangle {
        padding: 10px 20px;
        /* Increase horizontal padding */
        border-radius: 5px;
        /* Remove rounded corners */
    }

    .product-container {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 30px 0 30px 220px;
        width: calc(100% - 240px);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .section-title {
        color: #072797;
        font-weight: 600;
        font-size: 1.8rem;
        margin: 0;
    }

    .search-section {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-input {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        width: 300px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #072797;
        box-shadow: 0 0 0 0.2rem rgba(7, 39, 151, 0.25);
    }

    .search-btn {
        background-color: #072797;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background-color: orangered;
        transform: translateY(-2px);
    }

    .add-product-btn {
        background-color: orangered;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .add-product-btn:hover {
        background-color: #072797;
        transform: translateY(-2px);
    }

    .product-table {
        width: 100%;
        margin-top: 20px;
    }

    .product-table thead {
        background-color: #072797;
        color: white;
    }

    .product-table th {
        padding: 15px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .product-table td {
        padding: 15px;
        vertical-align: middle;
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }

    .product-name {
        font-weight: 500;
        color: #072797;
    }

    .stock-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-full {
        background-color: #e6f4ea;
        color: #1e7e34;
    }

    .status-low {
        background-color: #fff3e0;
        color: #f39c12;
    }

    .status-none {
        background-color: #fde8e8;
        color: #e74c3c;
    }

    .edit-btn {
        background-color: #072797;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .edit-btn:hover {
        background-color: orangered;
        transform: translateY(-2px);
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .product-table {
        min-width: 800px;
        width: 100%;
    }

    .product-table th,
    .product-table td {
        padding: 15px 10px;
        white-space: nowrap;
    }

    .product-table th:first-child,
    .product-table td:first-child {
        width: 80px;
        min-width: 80px;
    }

    .product-table th:nth-child(2),
    .product-table td:nth-child(2) {
        min-width: 150px;
    }

    .product-table th:nth-child(3),
    .product-table td:nth-child(3) {
        min-width: 100px;
    }

    .product-table th:nth-child(4),
    .product-table td:nth-child(4) {
        min-width: 100px;
    }

    .product-table th:nth-child(5),
    .product-table td:nth-child(5) {
        min-width: 100px;
    }

    .product-table th:nth-child(6),
    .product-table td:nth-child(6) {
        min-width: 100px;
    }

    .product-table th:nth-child(7),
    .product-table td:nth-child(7) {
        min-width: 100px;
    }

    @media (max-width: 992px) {
        .product-container {
            margin-left: 0;
            width: 100%;
            padding: 15px;
        }

        .section-header {
            flex-direction: column;
            gap: 15px;
        }

        .search-section {
            flex-direction: column;
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .search-btn,
        .add-product-btn {
            width: 100%;
        }
    }

    .section-header {
        padding: 0 15px;
    }

    .edit-btn {
        min-width: 80px;
        padding: 10px 16px;
    }

    .stock-status {
        display: inline-block;
        min-width: 90px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .product-container {
            margin: 15px;
            padding: 15px;
            width: auto;
        }

        .product-table {
            min-width: unset;
        }

        .product-table thead {
            display: none; /* Hide table header on mobile */
        }

        .product-table, 
        .product-table tbody, 
        .product-table tr, 
        .product-table td {
            display: block;
            width: 100%;
        }

        .product-table tr {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
        }

        .product-table td {
            padding: 8px 0;
            text-align: left;
            border: none;
        }

        /* Add labels for each cell */
        .product-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #072797;
            display: block;
            margin-bottom: 5px;
        }

        /* Adjust image display */
        .product-image {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            display: block;
        }

        /* Adjust status badge */
        .stock-status {
            display: inline-block;
            margin-top: 5px;
        }

        /* Make buttons full width */
        .edit-btn {
            width: 100%;
            margin-top: 10px;
        }

        /* Adjust search section */
        .search-section {
            width: 100%;
        }

        .search-input {
            width: 100%;
            margin-bottom: 10px;
        }

        .search-btn,
        .add-product-btn {
            width: 100%;
            margin-bottom: 10px;
        }
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
                    <h5 class="text-center">Welcome back Owner <?php echo $userData['firstname']; ?> !</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li>
                <li class="v-1">
                    <a href="owner-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="owner-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                        <span class="me-2"><i class="fas fa-building"></i></i></span>
                        <span>MY SHOPS</span>
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
                                <a href="owner-dashboard-inventory-cleaning-products.php" class="nav-link px-3">
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
        <div class="product-container">
            <div class="section-header">
                <h2 class="section-title">Cleaning Products</h2>
                <div class="search-section">
                    <form class="d-flex" action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="search-input" placeholder="Search products...">
                            <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                    <a href="owner-dashboard-inventory-cleaning-products-add.php?shop_id=<?php echo $shop_id; ?>" class="mt-2">
                        <button class="add-product-btn">
                            <i class="fas fa-plus" > </i> Add Product
                        </button>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table product-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Status</th>
                            <th>Stock Info</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($product_result) > 0) {
                            while ($row = mysqli_fetch_assoc($product_result)) {
                                // Determine stock status and class
                                if ($row['stock_size'] <= 0) {
                                    $status = "No stock";
                                    $status_class = "status-none";
                                } elseif ($row['stock_size'] < 50) {
                                    $status = "Low stock";
                                    $status_class = "status-low";
                                } else {
                                    $status = "In stock";
                                    $status_class = "status-full";
                                }
                                ?>
                                <tr>
                                    <td data-label="Image">
                                        <img src="<?php echo htmlspecialchars($row['profile']); ?>" 
                                             alt="Product" 
                                             class="product-image">
                                    </td>
                                    <td data-label="Product Name" class="product-name">
                                        <?php echo htmlspecialchars($row['product_name']); ?>
                                    </td>
                                    <td data-label="Status">
                                        <span class="stock-status <?php echo $status_class; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                    <td data-label="Stock Info">
                                        <?php echo htmlspecialchars($row['stock_size']); ?> in stock
                                    </td>
                                    <td data-label="Category">
                                        <?php echo htmlspecialchars($row['category']); ?>
                                    </td>
                                    <td data-label="Price">
                                        ₱<?php echo htmlspecialchars($row['price']); ?>.00
                                    </td>
                                    <td data-label="Action">
                                        <a href="owner-dashboard-inventory-cleaning-products-edit.php?shop_id=<?php echo $shop_id; ?>&inventory_id=<?php echo $row['inventory_id']; ?>">
                                            <button type="button" class="edit-btn">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center text-muted">No products found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php
    // Close the database connection
    mysqli_close($connection);
    ?>


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