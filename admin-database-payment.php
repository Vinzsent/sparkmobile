<?php
session_start();
// Include database connection file
include('config.php'); // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID' AND role='$role'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$shopownerData = mysqli_fetch_assoc($result);

// Assuming you have already established a database connection

// Query to retrieve all data from the database
$query1 = "SELECT *FROM payment_details";

$result1 = mysqli_query($connection, $query1);
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
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>SPARK MOBILE</title>
    <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
    <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
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
        --offcanvas-width: 200px;
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

    li :hover {
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

    .section {
        margin-left: 200px;
    }

    .text-box {
        padding: 6px 6px 6px 230px;
        background: orangered;
        border-radius: 10px;
        width: 50%;
        height: auto;
        position: absolute;
        top: 20%;
        left: 30%;
    }

    .text-box .btn {
        background-color: #072797;
        text-decoration: none;
        width: 58%;

    }

    .container-vinfo {
        margin-left: 20px
    }

    .v-3 {
        font-weight: bold;
    }

    .profile-picture {
        width: 300px;
        /* Adjust the size as needed */
        height: 150px;
        object-fit: cover;
        border-radius: 10%;
    }

    .container-table {

        margin-left: 15.5%;
        margin-bottom: 10%;
    }
</style>

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a
                class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
                href="smweb.html"><img src="NEW SM LOGO.png" alt=""></a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#topNavBar"
                aria-controls="topNavBar"
                aria-expanded="false"
                aria-label="Toggle navigation">
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

                    <a
                        class="nav-link dropdown-toggle ms-2"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
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
    <div
        class="offcanvas offcanvas-start sidebar-nav"
        tabindex="-1"
        id="sidebar"


        <div class="offcanvas-body p-0">
        <nav class="">
            <ul class="navbar-nav">


                <div class=" welcome fw-bold px-3 mb-3">
                    <h5 class="text-center">Welcome back <?php echo isset($userData['username']) ? $userData['username'] : ''; ?>!</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li class="v-1">
                    <a href="admin-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                <li class="">
                    <a href="owner-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li class="">
                    <a
                        class="nav-link px-3 sidebar-link"
                        data-bs-toggle="collapse"
                        href="#layouts">
                        <span class="me-2"><i class="fas fa-database"></i></i></span>
                        <span>DATABASE</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                </li>
                <div class="collapse" id="layouts">
                    <ul class="navbar-nav ps-3">
                        <li class="v-1">
                            <a href="admin-database.php" class="nav-link px-3">
                                <span class="me-2">Users</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="admin-database-vehicle.php" class="nav-link px-3">
                                <span class="me-2">Vehicles</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="admin-database-service-details.php" class="nav-link px-3">
                                <span class="me-2">Service Details</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="admin-database-payment.php" class="nav-link px-3">
                                <span class="me-2">Payment Details</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="admin-database-finish-jobs.php" class="nav-link px-3">
                                <span class="me-2">Finish jobs</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="admin-database-payment.php" class="nav-link px-3">
                                <span class="me-2">Car Appearance</span>
                            </a>
                        </li>
                        <li class="v-1">
                            <a href="#" class="nav-link px-3">
                                <span class="me-2"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                </li>
                <li>
                    <a
                        class="nav-link px-3 sidebar-link"
                        data-bs-toggle="collapse"
                        href="#layouts2">
                        <span class="me-2"><i class="fas fa-money-bill"></i>
                            </i></i></span>
                        <span>PAYMENTS</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="layouts2">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Payment options</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Car wash invoice</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Payment History</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="admin-database-car-appearance.php" class="nav-link px-3">
                                    <span class="me-2">Car Appearance</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                <li>
                    <a href="csreward.html" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-medal"></i>
                            </i></span>
                        <span>REWARDS</span>
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
    <main class="container-table text-dark">
        <!-- Page Title -->
        <h1 class="col-md-9">DATABASE</h1>

        <!-- Section Title -->
        <h3 class="text-center">Payment</h3>

        <div class="row">
            <?php
            if (mysqli_num_rows($result1) > 0) {
                echo '<div class="table-responsive">'; // Bootstrap responsive table wrapper
                echo '<table class="table table-striped table-hover table-bordered">'; // Bootstrap 5 table classes
                echo '<thead class="table-dark">'; // Dark header for table
                echo '<tr>';
                echo '<th>Payment ID</th>';
                echo '<th>Amount Paid</th>';
                echo '<th>Change Amount</th>';
                echo '<th>Payment Method</th>';
                echo '<th>Date</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Loop through each row of the result set
                while ($row = mysqli_fetch_assoc($result1)) {
                    echo '<tr>';
                    echo '<td>' . $row['payment_id'] . '</td>';
                    echo '<td>' . $row['amount'] . '</td>';
                    echo '<td>' . $row['change_amount'] . '</td>';
                    echo '<td>' . $row['payment_method'] . '</td>';
                    echo '<td>' . $row['date'] . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-primary btn-sm me-2">Edit</button>'; // Smaller edit button with margin
                    echo '<form action="csadmin_database-payment-delete.php" method="POST" class="d-inline">'; // Inline form to keep buttons together
                    echo '<input type="hidden" name="payment_id" id="payment_id" value="' . $row['payment_id'] . '">';
                    echo '<button class="btn btn-danger btn-sm">Delete</button>'; // Smaller delete button
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>'; // End of table-responsive
            } else {
                echo '<div class="alert alert-warning">No data found.</div>'; // Bootstrap alert for no data
            }
            ?>
        </div><!-- /row -->
    </main>



    <!-- Custom JavaScript to display the range value -->
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>