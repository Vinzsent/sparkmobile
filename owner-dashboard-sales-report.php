<?php
session_start();

// Include database connection file
include('config.php'); // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID

$userID = $_SESSION['user_id'];
$vehicle_id = $_SESSION['vehicle_id'];
$serviceID = $_SESSION['service_id'];
$servicename_id = $_SESSION['servicename_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);


// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT finish_jobs.*, users.firstname, users.lastname, vehicles.model, payment_details.*, service_names.service_name
FROM finish_jobs
INNER JOIN users ON finish_jobs.user_id = users.user_id
INNER JOIN vehicles ON finish_jobs.vehicle_id = vehicles.vehicle_id
INNER JOIN payment_details ON finish_jobs.user_id = payment_details.user_id
INNER JOIN service_names ON finish_jobs.servicename_id = service_names.servicename_id";


// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$servicenameData = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);
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

    .thick-border td {
        border-top: 3px solid #000;
        /* You can adjust the thickness and color here */
    }


    @media print {
        body * {
            visibility: visible;
            /* Hide everything */
        }

        #invoice,
        #invoice-totalAmount {
            visibility: visible;
            /* Show only the table and total amount */
        }

        #invoice,
        #invoice-totalAmount {
            position: absolute;
            /* Position elements for printing */
            left: 0;
            top: 0;
        }

        #invoice {
            visibility: hidden;
        }

        #print-button {
            visibility: hidden;
        }
    }
</style>

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
                <li class="">
                    <a href="owner-dashboard-sales-report.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-book"></i></i></span>
                        <span class="start">SALES REPORT</span>
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
        <div class="container-fluid text-dark">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="page-header">
                        <h1 class="text-center">Sales Report</h1>
                    </div>
                </div>
                <div class="">
                    <form action="cashier-dashboard-sales-report.php" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-6" id="invoice">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-6" id="invoice">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button id="invoice" class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                    <br>
                    <br>

                    <table class="table table-hover table-bordered table-striped table-responsive">
                        <thead class="v-2 text-light">
                            <tr>
                                <th class="px-4">Date</th>
                                <th class="px-4">Transaction ID</th>
                                <th class="px-4">Customer Name</th>
                                <th class="px-4">Vehicle Details</th>
                                <th class="px-4">Type of Service & Price</th>
                                <th class="px-4">Cleaning Products & Price</th>
                                <th class="px-4">Payment Method</th>
                                <th class="px-4">Transaction Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('config.php');

                            // Initialize search parameters
                            $whereClause = '';

                            // Check if search dates are provided
                            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                $start_date = $_GET['start_date'];
                                $end_date = $_GET['end_date'];

                                // Add the date range filter to the WHERE clause
                                $whereClause = " WHERE payment_details.date BETWEEN '$start_date' AND '$end_date'";
                            } elseif (isset($_GET['start_date'])) {
                                $start_date = $_GET['start_date'];
                                $whereClause = " WHERE payment_details.date >= '$start_date'";
                            } elseif (isset($_GET['end_date'])) {
                                $end_date = $_GET['end_date'];
                                $whereClause = " WHERE payment_details.date <= '$end_date'";
                            }

                            // Construct SQL query with search parameters
                            $query = "SELECT finish_jobs.*, users.firstname, users.lastname, vehicles.model, payment_details.*, service_names.service_name
                                  FROM finish_jobs
                                  INNER JOIN users ON finish_jobs.user_id = users.user_id
                                  INNER JOIN vehicles ON finish_jobs.vehicle_id = vehicles.vehicle_id
                                  INNER JOIN payment_details ON finish_jobs.user_id = payment_details.user_id
                                  INNER JOIN service_names ON finish_jobs.servicename_id = service_names.servicename_id $whereClause";

                            $result = mysqli_query($connection, $query);

                            // Initialize total amount variable
                            $totalAmount = 0;

                            // Check if any rows are returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through the results and display the table
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['date'] . '</td>';
                                    echo '<td>' . $row['payment_id'] . '</td>';
                                    echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                    echo '<td>' . $row['model'] . '</td>';

                                    // Displaying type of services and prices
                                    $services = explode(',', $row['services']); // Assuming service_name is comma-separated
                                    $prices = explode(',', $row['price']); // Assuming price is comma-separated


                                    // Check if both arrays have the same length to avoid errors
                                    $output = '';
                                    if (count($services) === count($prices)) {
                                        for ($i = 0; $i < count($services); $i++) {
                                            // Append each service and price with a line break
                                            $output .= trim($services[$i]) . ' - ' . trim($prices[$i]) . '<br>';

                                            // Sum the price to total amount, removing peso sign and converting to float
                                            $price = str_replace(['₱', ' '], '', $prices[$i]);  // Remove peso sign and spaces
                                            $totalAmount += (float)$price;  // Add to total amount
                                        }
                                    }

                                    echo '<td>' . $output . '</td>'; // Display the formatted output

                                    // Displaying type of services and prices
                                    $product_name = explode(',', $row['product_name']); // Assuming product_name is comma-separated
                                    $product_price = explode(',', $row['product_price']); // Assuming product_price is comma-separated

                                    // Check if both arrays have the same length to avoid errors
                                    $product_output = '';
                                    if (count($product_name) === count($product_price)) {
                                        for ($i = 0; $i < count($product_name); $i++) {
                                            // Append each product and price with a line break
                                            $product_output .= trim($product_name[$i]) . ' - ' . trim($product_price[$i]) . '<br>';

                                            // Create a new variable for cleaned price instead of overwriting the array
                                            $clean_price = str_replace(['₱', ' '], '', $product_price[$i]);  // Remove peso sign and spaces
                                            $totalAmount += (float)$clean_price;  // Add to total amount
                                        }
                                    } else {
                                        // Handle the case where the product_name and product_price arrays don't match in length
                                        $product_output = 'Error: Mismatch between product names and prices.';
                                    }

                                    echo '<td>' . $product_output . '</td>'; // Display the formatted output
                                    echo '<td>' . $row['payment_method'] . '</td>';
                                    echo '<td>Paid</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // Display a message if no data is found for the selected dates
                                echo '<tr><td colspan="8" class="text-center">No data found for the selected date range.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="alert alert-info">
                        Total Amount: ₱ <?php echo number_format($totalAmount, 2); ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="cashier-dashboard-sales-report1.php"><button class="btn btn-primary" id="invoice">View Next Page</button></a>
                        <button id="print-button" class="btn btn-primary" type="button" onclick="printInvoice()">Print Sales</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function printInvoice() {
                // Print the current window content (entire page)
                window.print();
            }
        </script>
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