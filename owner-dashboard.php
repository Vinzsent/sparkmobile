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

$shop_query = "SELECT * FROM shops WHERE user_id = '$userID'";
$shop_result = mysqli_query($connection, $shop_query);
$shopData = mysqli_fetch_assoc($shop_result);

$total_users_query = "SELECT COUNT(*) as total_count FROM users WHERE role = 'User'";
$total_result = mysqli_query($connection, $total_users_query);
$total_users_in_db = mysqli_fetch_assoc($total_result)['total_count'];

// Update the online/offline status queries
$online_users_query = "SELECT COUNT(*) as online_count 
                      FROM users 
                      WHERE status = 'online' 
                      AND role = 'User'";  // Consider users inactive after 5 minutes

$offline_users_query = "SELECT COUNT(*) as offline_count 
                       FROM users 
                       WHERE (status = 'offline'  < NOW() - INTERVAL 5 MINUTE)
                       AND role = 'User'";

$online_result = mysqli_query($connection, $online_users_query);
$online_count = mysqli_fetch_assoc($online_result)['online_count'];

$offline_result = mysqli_query($connection, $offline_users_query);
$offline_count = mysqli_fetch_assoc($offline_result)['offline_count'];

// Calculate percentages based on total users in database
$online_percentage = ($total_users_in_db > 0) ? round(($online_count / $total_users_in_db) * 100) : 0;
$offline_percentage = ($total_users_in_db > 0) ? round(($offline_count / $total_users_in_db) * 100) : 0;

// Count occupied slots (users currently online)
$occupied_slots_query = "SELECT COUNT(*) as occupied_slots FROM queuing_slots WHERE is_serving = '1'";
$occupied_slots_result = mysqli_query($connection, $occupied_slots_query);
$occupied_slots = mysqli_fetch_assoc($occupied_slots_result)['occupied_slots'];

// Calculate vacant slots
$max_slots = 5;
$vacant_slots = $max_slots - $occupied_slots;
$vacant_slots = max(0, $vacant_slots); // Ensure we don't show negative slots

// Calculate vacancy percentage
$vacancy_percentage = ($max_slots > 0) ? round(($vacant_slots / $max_slots) * 100) : 0;

// Add this query near your other database queries
$monthly_logins_query = "SELECT 
    MONTH(login_time) as month,
    COUNT(*) as login_count
    FROM user_logs 
    WHERE YEAR(login_time) = YEAR(CURRENT_DATE)
    GROUP BY MONTH(login_time)
    ORDER BY month";
$monthly_result = mysqli_query($connection, $monthly_logins_query);

// Initialize arrays to store months and counts
$months = [];
$login_counts = [];

// Populate arrays with data for all months (including 0 for months with no logins)
for ($i = 1; $i <= 12; $i++) {
    $months[] = date('F', mktime(0, 0, 0, $i, 1));
    $login_counts[$i] = 0;
}

// Fill in actual login counts
while ($row = mysqli_fetch_assoc($monthly_result)) {
    $login_counts[$row['month']] = $row['login_count'];
}

// Convert login_counts to a simple array
$login_counts = array_values($login_counts);

// Fetch recent user login activities with user details
$user_activities_query = "SELECT 
    u.firstname,
    u.lastname,
    u.email,
    u.profile,
    ul.login_time,
    u.status
FROM user_logs ul
JOIN users u ON ul.user_id = u.user_id
WHERE u.role = 'User'
ORDER BY ul.login_time DESC
LIMIT 10"; // Limit to most recent 10 activities

$activities_result = mysqli_query($connection, $user_activities_query);
$user_activities = [];
while ($activity = mysqli_fetch_assoc($activities_result)) {
    $user_activities[] = $activity;
}

// Add this near your other database queries
$current_month = date('m');
$current_year = date('Y');

$service_count_query = "SELECT COUNT(*) as service_count 
                       FROM offered_services 
                       WHERE MONTH(last_updated) = '$current_month' 
                       AND YEAR(last_updated) = '$current_year'";

$service_count_result = mysqli_query($connection, $service_count_query);
$service_count = mysqli_fetch_assoc($service_count_result)['service_count'];

// Check if service count is less than minimum required (4)
if ($service_count < 4) {
    $notification_message = "This is a reminder to update your services on ". $shopData['shop_name'] .". Minimum requirement is 4 services per month. Current count: $service_count";
    
    // Insert notification into database
    $insert_notification = "INSERT INTO notifications 
                          (user_id, type, title, message, action_url, is_read, created_at) 
                          VALUES 
                          (
                              '$userID',
                              'service_update',
                              'Service Update Required',
                              '$notification_message',
                              'ower-shop-service.php',
                              0,
                              NOW()
                          )
                          ON DUPLICATE KEY UPDATE 
                              message = VALUES(message),
                              is_read = 0,
                              created_at = NOW()";
    
    mysqli_query($connection, $insert_notification);
}

// Check for services that need updates (older than 1 month)
$outdated_services_query = "SELECT 
    s.services,
    s.last_updated,
    DATEDIFF(NOW(), s.last_updated) as days_since_update
FROM offered_services s
WHERE s.last_updated < DATE_SUB(NOW(), INTERVAL 1 MONTH)
OR s.last_updated IS NULL";

$outdated_result = mysqli_query($connection, $outdated_services_query);

if (mysqli_num_rows($outdated_result) > 0) {
    while ($service = mysqli_fetch_assoc($outdated_result)) {
        $notification_message = "This is a reminder to update your services on ". $shopData['shop_name'] .". Minimum requirement is 4 services per month. Current count: $service_count";
        
        // Use INSERT ... ON DUPLICATE KEY UPDATE
        $insert_notification = "INSERT INTO notifications 
            (user_id, type, title, message, action_url, is_read, created_at) 
            VALUES 
            (
                $userID,
                'service_update',
                'Service Update Required',
                '$notification_message',
                'owner-shop-service.php',
                0,
                NOW()
            )
            ON DUPLICATE KEY UPDATE 
                message = VALUES(message),
                is_read = 0,
                created_at = NOW()";
        
        // Execute the query with error handling
        if (!mysqli_query($connection, $insert_notification)) {
            error_log("Notification insertion failed: " . mysqli_error($connection));
        }
    }
}

// Add this query near your other queries
$current_services_query = "SELECT 
    fj.slotNumber AS slot_number,
    u.firstname AS user_firstname,
    u.lastname AS user_lastname,
    s.firstname AS staff_firstname,
    s.lastname AS staff_lastname,
    v.brand AS vehicle_brand,
    v.model AS vehicle_model,
    v.color AS vehicle_color,
    fj.services AS service_name,
    fj.start_time,
    fj.end_time,
    fj.total_price,
    fj.timer,
    fj.is_finished
FROM finish_jobs fj
LEFT JOIN users u ON fj.user_id = u.user_id
LEFT JOIN users s ON fj.staff_id = s.user_id
LEFT JOIN vehicles v ON fj.vehicle_id = v.vehicle_id
WHERE fj.is_finished = 1
ORDER BY fj.slotNumber";

$current_services_result = mysqli_query($connection, $current_services_query);
$current_services = [];
while ($service = mysqli_fetch_assoc($current_services_result)) {
    $current_services[] = $service;
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
        --topNavbarHeight: 2px;
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

    /* Add to your existing styles */
    .table {
        color: #333;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
    }

    /* Responsive Table Styles */
    @media screen and (max-width: 767px) {
        .table-responsive {
            border: 0;
            padding: 15px;
        }

        .table {
            border: 0;
        }

        .table thead {
            display: none;
        }

        .table tr {
            margin-bottom: 1rem;
            display: block;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            background: #fff;
            padding: 15px;
        }

        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border: none;
            text-align: left;
        }

        .table td:before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: uppercase;
            padding-right: 10px;
            flex: 1;
            text-align: left;
        }

        .table td span, 
        .table td a {
            flex: 2;
            text-align: right;
        }

        /* Profile image styling */
        td:first-child {
            justify-content: center;
            padding: 15px 0;
        }

        td:first-child:before {
            display: none;
        }

        .profile-img {
            width: 80px !important;
            height: 80px !important;
            margin: 0;
        }

        /* Status badge styling */
        td[data-label="STATUS"] {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge {
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 80px;
            padding: 8px 16px;
            margin-left: auto;
            border-radius: 20px;
        }

        /* For online status specifically */
        .bg-success {
            text-align: center;
            width: 100px;
        }

        /* For offline status */
        .bg-danger {
            text-align: center;
            width: 100px;
        }

        /* Fix the ACTIVITY alignment */
        td[data-label="ACTIVITY"] {
            word-break: break-all;
        }

        /* Add spacing between rows */
        .table tbody tr + tr {
            margin-top: 20px;
        }

        /* Improve typography */
        .table td:before {
            font-size: 0.9rem;
            color: #666;
        }

        /* Fix LOGIN TIME alignment */
        td[data-label="LOGIN TIME"] {
            text-align: right;
        }
    }

    /* Badge Styles */
    .badge {
        padding: 0.5em 1em;
        font-size: 0.875em;
        border-radius: 30px;
    }

    /* Navbar icons styling */
    .navbar-nav .nav-item {
        display: flex;
        align-items: center;
    }

    .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
        color: white;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Ensure icons are properly aligned */
    .navbar-nav i {
        font-size: 1.2rem;
        vertical-align: middle;
    }

    /* Space between icons */
    .navbar-nav .nav-item:not(:last-child) {
        margin-right: 0.5rem;
    }

    /* Dropdown menu positioning */
    .dropdown-menu {
        margin-top: 0.5rem;
        right: 0;
        left: auto;
    }

    /* Adjust main content positioning */
    main {
        margin-top: 10px; /* Height of navbar */
        padding: 16px 16px 0 16px;
    }

    /* Adjust dashboard content */
    .dashboard-content {
        padding-top: 0;
        margin-top: 0;
    }

    /* Adjust container padding */
    .container-fluid {
        padding-top: 20px;
    }

    /* Adjust navbar */
    .navbar {
        height: 60px;
        padding: 0 16px;
    }

    /* Adjust sidebar positioning */
    .sidebar-nav {
        margin-top: 58px; /* Should match navbar height */
    }

    /* Remove any extra margins from first row */
    .row.mb-4:first-child {
        margin-top: 0;
    }

    /* Add to your existing styles */
    .notification-bell {
        position: relative;
        cursor: pointer;
    }

    .notification-bell .notification-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        min-width: 18px;
        text-align: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .notification-bell.has-notification i {
        animation: bell-ring 1s ease-in-out infinite;
        transform-origin: top center;
    }

    @keyframes bell-ring {
        0% { transform: rotate(0); }
        20% { transform: rotate(15deg); }
        40% { transform: rotate(-15deg); }
        60% { transform: rotate(7deg); }
        80% { transform: rotate(-7deg); }
        100% { transform: rotate(0); }
    }

    .toast-container {
        z-index: 1100;
    }

    .toast {
        background-color: white;
        color: #333;
    }

    .toast-header {
        color: #000;
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
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a href="notification.php" class="nav-link px-3 notification-bell">
                            <i class="fas fa-bell"></i>
                            <?php
                            // Check if connection is still valid
                            if ($connection && mysqli_ping($connection)) {
                                // Query to count unread notifications
                                $notif_count_query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = '$userID' AND is_read = 0";
                                $notif_result = mysqli_query($connection, $notif_count_query);
                                if ($notif_result) {
                                    $notif_count = mysqli_fetch_assoc($notif_result)['count'];
                                    
                                    if ($notif_count > 0) {
                                        echo "<span class='notification-count'>$notif_count</span>";
                                    }
                                }
                            } else {
                                // Reconnect if connection is lost
                                include('config.php');
                            }
                            ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Visual</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log out</a></li>
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
                                <h4 class="card-title total-users"><?php echo $total_users_in_db; ?></h4>
                                <p class="card-text">Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title online-percentage"><?php echo $online_percentage; ?>%</h4>
                                <p class="card-text online-count">Users Online (<?php echo $online_count; ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title offline-percentage"><?php echo $offline_percentage; ?>%</h4>
                                <p class="card-text offline-count">Users Offline (<?php echo $offline_count; ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h4 class="card-title vacant-slots"><?php echo $vacant_slots; ?></h4>
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

                <!-- User Activities Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Recent User Activities
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Profile</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Login Time</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($user_activities as $activity): ?>
                                                <tr>
                                                    <td data-label="PROFILE">
                                                        <img src="<?php echo $activity['profile']; ?>" 
                                                             alt="Profile Picture" 
                                                             class="img-fluid rounded-circle profile-img">
                                                    </td>
                                                    <td data-label="FIRST NAME">
                                                        <?php echo $activity['firstname']; ?>
                                                    </td>
                                                    <td data-label="LAST NAME">
                                                        <?php echo $activity['lastname']; ?>
                                                    </td>
                                                    <td data-label="LOGIN TIME">
                                                        <?php echo $activity['login_time']; ?>
                                                    </td>
                                                    <td data-label="STATUS">
                                                        <span class="badge <?php echo ($activity['status'] === 'online') ? 'bg-success' : 'bg-danger'; ?>">
                                                            <?php echo $activity['status']; ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add this after your User Activities Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Current Services
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Slot</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Staff Name</th>
                                                <th scope="col">Vehicle</th>
                                                <th scope="col">Service</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">End Time</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($current_services)): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No active services at the moment</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($current_services as $service): ?>
                                                    <tr>
                                                        <td data-label="SLOT"><?php echo $service['slot_number']; ?></td>
                                                        <td data-label="CUSTOMER NAME">
                                                            <?php echo $service['user_firstname'] . ' ' . $service['user_lastname']; ?>
                                                        </td>
                                                        <td data-label="STAFF NAME">
                                                            <?php echo $service['staff_firstname'] . ' ' . $service['staff_lastname']; ?>
                                                        </td>
                                                        <td data-label="VEHICLE">
                                                            <?php echo $service['vehicle_brand'] . ' ' . $service['vehicle_model']; ?>
                                                        </td>
                                                        <td data-label="SERVICE"><?php echo $service['service_name']; ?></td>
                                                        <td data-label="START TIME">
                                                            <?php echo date('h:i A', strtotime($service['start_time'])); ?>
                                                        </td>
                                                        <td data-label="END TIME">
                                                            <?php echo date('h:i A', strtotime($service['end_time'])); ?>
                                                        </td>
                                                        <td data-label="STATUS">
                                                            <span class="badge <?php echo ($service['is_finished'] === 1) ? 'bg-warning' : 'bg-success'; ?>">
                                                                <?php echo ($service['is_finished'] === 1) ? 'Ongoing' : 'Finished'; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // First, declare the contexts
    const ctxVisits = document.getElementById('visitsChart').getContext('2d');
    const ctxRegion = document.getElementById('regionChart').getContext('2d');

    // User Status Chart (Line Chart)
    const visitsChart = new Chart(ctxVisits, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'User Logins',
                data: <?php echo json_encode(array_values($login_counts)); ?>,
                borderColor: '#072797',
                backgroundColor: 'rgba(7, 39, 151, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#072797',
                pointRadius: 6,
                borderWidth: 2
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
                    text: 'Monthly User Login Frequency'
                },
                legend: {
                    display: true
                }
            }
        }
    });

    // Slot Usage Chart (Bar Chart)
    const regionChart = new Chart(ctxRegion, {
        type: 'bar',
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
                    display: true
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
    <script>
    // Function to update dashboard data
    function updateDashboardData() {
        $.ajax({
            url: 'fetch_dashboard_data.php',
            method: 'GET',
            success: function(response) {
                // Update stats
                $('.total-users').text(response.total_users);
                $('.online-percentage').text(response.online_percentage + '%');
                $('.online-count').text('Users Online (' + response.online_users + ')');
                $('.offline-percentage').text(response.offline_percentage + '%');
                $('.offline-count').text('Users Offline (' + response.offline_users + ')');
                $('.vacant-slots').text(response.vacant_slots);

                // Update user activities table
                let tableBody = '';
                response.user_activities.forEach(function(activity) {
                    tableBody += `
                        <tr>
                            <td data-label="PROFILE">
                                <img src="${activity.profile}" 
                                     alt="Profile Picture" 
                                     class="img-fluid rounded-circle profile-img">
                            </td>
                            <td data-label="FIRST NAME">${activity.firstname}</td>
                            <td data-label="LAST NAME">${activity.lastname}</td>
                            <td data-label="ACTIVITY">${activity.activity}</td>
                            <td data-label="LOGIN TIME">${activity.login_time}</td>
                            <td data-label="STATUS">
                                <span class="badge ${activity.status === 'online' ? 'bg-success' : 'bg-danger'}">
                                    ${activity.status}
                                </span>
                            </td>
                        </tr>
                    `;
                });
                $('.table tbody').html(tableBody);

                // Update charts
                updateCharts(response);

                // Update current services table
                if (response.current_services) {
                    let servicesTableBody = '';
                    response.current_services.forEach(function(service) {
                        const startTime = new Date(service.start_time);
                        const now = new Date();
                        const duration = Math.floor((now - startTime) / 1000); // duration in seconds
                        
                        const hours = Math.floor(duration / 3600);
                        const minutes = Math.floor((duration % 3600) / 60);
                        const seconds = duration % 60;
                        
                        servicesTableBody += `
                            <tr>
                                <td data-label="SLOT">${service.slot_number}</td>
                                <td data-label="CUSTOMER">${service.user_firstname} ${service.user_lastname}</td>
                                <td data-label="STAFF">${service.staff_firstname} ${service.staff_lastname}</td>
                                <td data-label="VEHICLE">${service.vehicle_brand} ${service.vehicle_model} (${service.vehicle_type})</td>
                                <td data-label="SERVICE">${service.service_name}</td>
                                <td data-label="START TIME">${new Date(service.start_time).toLocaleTimeString()}</td>
                                <td data-label="DURATION">${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}</td>
                            </tr>
                        `;
                    });
                    
                    if (servicesTableBody === '') {
                        servicesTableBody = '<tr><td colspan="7" class="text-center">No active services at the moment</td></tr>';
                    }
                    
                    $('.current-services-table tbody').html(servicesTableBody);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching dashboard data:', error);
            }
        });
    }

    // Function to update charts with new data
    function updateCharts(data) {
        // Update visitsChart if needed
        if (window.visitsChart) {
            // Update chart data here
            visitsChart.update();
        }

        // Update regionChart if needed
        if (window.regionChart) {
            regionChart.data.datasets[0].data = [5, 5 - data.vacant_slots, data.vacant_slots];
            regionChart.update();
        }
    }

    // Update data every 5 seconds (5000 milliseconds)
    setInterval(updateDashboardData, 5000);

    // Initial update
    updateDashboardData();
</script>

<script>
// Function to update dashboard stats
function updateDashboardStats() {
    fetch('get_dashboard_stats.php')
        .then(response => response.json())
        .then(data => {
            // Update stats
            document.querySelector('.total-users').textContent = data.total_users;
            document.querySelector('.online-percentage').textContent = data.online_percentage + '%';
            document.querySelector('.online-count').textContent = `Users Online (${data.online_count})`;
            document.querySelector('.offline-percentage').textContent = data.offline_percentage + '%';
            document.querySelector('.offline-count').textContent = `Users Offline (${data.offline_count})`;
            document.querySelector('.vacant-slots').textContent = data.vacant_slots;
            
            // Update charts
            visitsChart.data.datasets[0].data = [data.total_users, data.online_count, data.offline_count];
            visitsChart.update();
            
            regionChart.data.datasets[0].data = [data.max_slots, data.occupied_slots, data.vacant_slots];
            regionChart.update();
        });
}

// Update stats every 30 seconds
setInterval(updateDashboardStats, 30000);
</script>

<script>
function checkServiceUpdates() {
    $.ajax({
        url: 'check_service_updates.php',
        method: 'GET',
        success: function(response) {
            if (response.hasNotification) {
                // Update notification bell
                $('.notification-bell').addClass('has-notification');
                
                // Show notifications
                response.notifications.forEach(function(notification) {
                    let message;
                    if (notification.type === 'count_warning') {
                        message = notification.message;
                    } else {
                        message = `Service '${notification.service}' needs to be updated. Last update was ${notification.days_since_update} days ago.`;
                    }
                    showNotificationToast(message);
                });
            }
        }
    });
}

function showNotificationToast(message) {
    const toast = `
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning">
                    <strong class="me-auto">Service Update Required</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                    <div class="mt-2 pt-2 border-top">
                        <a href="ower-shop-service.php" class="btn btn-primary btn-sm">Update Services</a>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('body').append(toast);
    $('.toast').toast({
        delay: 10000 // Show for 10 seconds
    }).toast('show');
}

// Check for service updates every 5 minutes
setInterval(checkServiceUpdates, 300000);
// Initial check
checkServiceUpdates();
</script>

<script>
// Add this to your existing JavaScript
function updateNotificationBell() {
    $.ajax({
        url: 'get_notification_count.php',
        method: 'GET',
        success: function(response) {
            const count = parseInt(response.count);
            const bell = $('.notification-bell');
            const existingCount = bell.find('.notification-count');
            
            if (count > 0) {
                bell.addClass('has-notification');
                if (existingCount.length) {
                    existingCount.text(count);
                } else {
                    bell.append(`<span class="notification-count">${count}</span>`);
                }
            } else {
                bell.removeClass('has-notification');
                existingCount.remove();
            }
        }
    });
}

// Update notification bell every 30 seconds
setInterval(updateNotificationBell, 30000);
// Initial check
updateNotificationBell();
</script>
</body>

</html>