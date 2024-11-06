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
$vehicle_id = $_SESSION['vehicle_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$total_users_query = "SELECT COUNT(*) as total_count FROM users WHERE role = 'User'";
$total_result = mysqli_query($connection, $total_users_query);
$total_users_in_db = mysqli_fetch_assoc($total_result)['total_count'];

// Count online users (keep existing code)
$online_users_query = "SELECT COUNT(*) as online_count FROM users WHERE status = 'online' AND role = 'User'";
$online_result = mysqli_query($connection, $online_users_query);
$online_count = mysqli_fetch_assoc($online_result)['online_count'];

// Count offline users (keep existing code)
$offline_users_query = "SELECT COUNT(*) as offline_count FROM users WHERE status = 'offline' AND role = 'User'";
$offline_result = mysqli_query($connection, $offline_users_query);
$offline_count = mysqli_fetch_assoc($offline_result)['offline_count'];

// Calculate percentages based on total users in database
$online_percentage = ($total_users_in_db > 0) ? round(($online_count / $total_users_in_db) * 100) : 0;
$offline_percentage = ($total_users_in_db > 0) ? round(($offline_count / $total_users_in_db) * 100) : 0;

// Count occupied slots (users currently online)
$occupied_slots_query = "SELECT COUNT(*) as occupied_slots FROM users WHERE status = 'online' AND role = 'User'";
$occupied_slots_result = mysqli_query($connection, $occupied_slots_query);
$occupied_slots = mysqli_fetch_assoc($occupied_slots_result)['occupied_slots'];

// Calculate vacant slots
$max_slots = 5;
$vacant_slots = $max_slots - $occupied_slots;
$vacant_slots = max(0, $vacant_slots); // Ensure we don't show negative slots

// Calculate vacancy percentage
$vacancy_percentage = ($max_slots > 0) ? round(($vacant_slots / $max_slots) * 100) : 0;


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

    .sidebar {
        height: 100vh;
        position: fixed;
        width: 220px;
        background-color: #343a40;
    }

    .sidebar a {
        color: #fff;
        padding: 15px;
        display: block;
        text-decoration: none;
    }

    .sidebar a:hover {
        background-color: #495057;
    }

    .card-header {
        font-weight: bold;
    }

    .chart {
        min-height: 300px;
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
    <main class="text-dark">
        <!-- Main Content -->
        <div class="dashboard-content">
            <div class="container-fluid">
                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $total_users_in_db; ?></h4>
                                <p class="card-text">Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $online_percentage; ?>%</h4>
                                <p class="card-text">Users Online (<?php echo $online_count; ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $offline_percentage; ?>%</h4>
                                <p class="card-text">Users Offline (<?php echo $offline_count; ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $vacant_slots; ?></h4>
                                <p class="card-text">Vacant Slot Number</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                User Distribution
                            </div>
                            <div class="card-body">
                                <canvas id="visitsChart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Slot Availability
                            </div>
                            <div class="card-body">
                                <canvas id="regionChart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Chart for User Status
    const ctxVisits = document.getElementById('visitsChart').getContext('2d');
    const visitsChart = new Chart(ctxVisits, {
        type: 'bar',  // Changed to bar graph
        data: {
            labels: ['Total Users', 'Online Users', 'Offline Users'],
            datasets: [{
                label: 'Number of Users',
                data: [<?php echo $total_users_in_db; ?>, <?php echo $online_count; ?>, <?php echo $offline_count; ?>],
                backgroundColor: [
                    '#072797',  // Blue for total
                    'orangered',  //  for online
                    '#dc3545'   // Red for offline
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'User Distribution'
                },
                legend: {
                    display: false
                }
            }
        }
    });

    // Chart for Slot Usage
    const ctxRegion = document.getElementById('regionChart').getContext('2d');
    const regionChart = new Chart(ctxRegion, {
        type: 'bar',  // Changed to bar graph
        data: {
            labels: ['Maximum Slots', 'Occupied Slots', 'Vacant Slots'],
            datasets: [{
                label: 'Slots',
                data: [<?php echo $max_slots; ?>, <?php echo $occupied_slots; ?>, <?php echo $vacant_slots; ?>],
                backgroundColor: [
                    '#072797',  // Blue for max
                    '#ffc107',  // Yellow for occupied
                    '#17a2b8'   // Light blue for vacant
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Slot Availability'
                },
                legend: {
                    display: false
                }
            }
        }
    });
</script>


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
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>