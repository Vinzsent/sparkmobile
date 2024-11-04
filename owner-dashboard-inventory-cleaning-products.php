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
    <main class="container product-table text-dark" style="margin-left: 15.6%;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Products</h2>
            <div class="" style="margin-right: 10%;">
                <form class="d-flex" action="" method="GET">
                    <input type="text" name="search" class="form-control me-3" placeholder="Search">
                    <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                    <button type="submit" class="btn btn-secondary me-3">Search</button>
                </form>
                <a href="owner-dashboard-inventory-cleaning-products-add.php?shop_id=<?php echo $shop_id; ?>">
                    <button class="btn btn-primary btn-sm me-3">+ Add Product</button>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <thead class="v-2 text-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name of Product</th>
                    <th scope="col">Status</th>
                    <th scope="col">Stock Info</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price per Pieces</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are results
                if (mysqli_num_rows($product_result) > 0) {
                    // Loop through the results and populate the table
                    while ($row = mysqli_fetch_assoc($product_result)) {
                        // Determine stock status and corresponding color classes
                        if ($row['stock_size'] <= 0) {
                            $status = "No stock";
                            $status_class = "text-danger"; // Red color for no stock
                        } elseif ($row['stock_size'] < 50) {
                            $status = "Low on stock";
                            $status_class = "text-warning"; // Warning color (yellow/orange) for low stock
                        } else {
                            $status = "Full stocks";
                            $status_class = "text-success"; // Green color for full stock
                        }

                        echo "  </td>
                         <td><img src='{$row['profile']}' alt='Profile Picture' class= 'img-account-profile' 'img-fluid' width='150' height='150'></td>
                        <td>{$row['product_name']}</td>
                        <td><span class='{$status_class}'>{$status}</span></td>
                        <td>{$row['stock_size']} in stock</td>
                        <td>{$row['category']}</td>
                        <td>₱ {$row['price']} .00</td>
                        <td><a href='owner-dashboard-inventory-cleaning-products-edit.php?shop_id={$shop_id}&inventory_id={$row['inventory_id']}'><button type='button' class='btn btn-primary btn-sm'>Edit Product</button></a></td>
                    </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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