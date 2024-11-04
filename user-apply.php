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

$shop_query = "SELECT * FROM shops";
$shop_result = mysqli_query($connection, $shop_query);




// Close the database connection

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

    .card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .textorange {
        color: orangered;
    }


    .card {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .apply-staff:hover {
        background-color: orangered;
    }

    .bi-star-fill {
        color: orangered;
    }

    .ratings {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .ratings .star {
        color: orangered;
        font-size: 1.5em;
        margin-right: 5px;
    }

    .ratings .rating-value {
        font-size: 1.2em;
        margin-left: 12px;
        color: #666;
    }
    .card {
        width: 18rem; /* Set a smaller width for the card */
        height: auto; /* Let the height adjust based on content */
        margin: 0 auto; /* Center the card horizontally if needed */
    }
    
    .card-img-top {
        height: 200px; /* Adjust the height of the image */
        object-fit: cover; /* Crop the image if necessary */
    }
    
    .card-body {
        padding: 10px; /* Adjust padding inside the card */
    }
    
    .card-title {
        font-size: 1.2rem; /* Adjust the title font size */
    }
    
    .btn {
        padding: 5px 10px; /* Adjust button size */
        font-size: 0.9rem; /* Reduce button font size */
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
                    <div class="dropdown">
                        <a class="apply-staff navbar-brand me-5 ms-lg-5 text-uppercase dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Apply as Staff
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="user-apply.php?role=cashier">Cashier</a></li>
                            <li><a class="dropdown-item" href="user-apply.php?role=manager">Manager</a></li>
                            <li><a class="dropdown-item" href="user-apply.php?role=car_wash_staff">Car Wash Staff</a></li>
                        </ul>
                    </div>

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
                    <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?>!</h5>
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

                <li class="">
                    <a href="cars-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-car"></i></i></span>
                        <span>MY CARS</span>
                    </a>
                </li>
                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                        <span class="me-2"><i class="fas fa-calendar"></i></i></span>
                        <span>BOOKINGS</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="layouts">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="user-appoinment.php" class="nav-link px-3">
                                    <span class="me-2">Appointments</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="checkingcar.php" class="nav-link px-3">
                                    <span class="me-2">Checking car condition</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="csrequest_slot.php" class="nav-link px-3">
                                    <span class="me-2">Request Slot</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="csprocess3.php" class="nav-link px-3">
                                    <span class="me-2">Select Service</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Register your car</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="csservice_view.php?vehicle_id=<?php echo $vehicleData['vehicle_id']; ?>" class="nav-link px-3">
                                    <span class="me-2">Booking Summary</span>
                                </a>

                            </li>
                            <li class="v-1">
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Booking History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
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
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Payment options</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Car wash invoice</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Payment History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-medal"></i>
                            </i></span>
                        <span>REWARDS</span>
                    </a>
                </li>
                <li class="nav-link px-3" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <span class="me-2"><i class="fas fa-sign-out-alt"></i>
                        </i></span>
                    <span>LOG OUT</span>
                </li>

            </ul>
        </nav>
    </div>
    <div class="modal fade text-dark" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="logoutModalLabel">Logout</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure you want to Logout?</h4>
                </div>
                <div class="modal-footer">
                    <a href=""><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button></a>
                    <a href="logout.php"><button type="button" class="btn btn-primary" id="confirmLogout">Logout</button></a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- main content -->
    <main>
        <div class="container mt-3">
            <form action="" method="GET" id="search-form">
                <div class="input-group input-group-sm">
                    <input type="text" name="query" class="form-control form-control-sm" placeholder="Search Car Wash Shop">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-lg ms-4" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container mt-3">
            <?php
            if (isset($_GET['query'])) {
                // Include the config.php file to connect to the database


                // Get the search query
                $query = $connection->real_escape_string($_GET['query']);

                $sql = "SELECT * FROM shops WHERE shop_name LIKE '%$query%' OR barangay LIKE '%$query%'";
                $result = $connection->query($sql);

                echo '<h3 class="text-dark">Search Results for "' . htmlspecialchars($query) . '"</h3>';
                if ($result->num_rows > 0) {
                    echo '<ul class="list-group">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="list-group-item">';
                        echo '<a href="user-dashboard-select-shop.php?shop_id=' . urlencode($row["shop_id"]) . '" class="text-decoration-none list-group-item-action">';
                        echo '<h5>' . htmlspecialchars($row["shop_name"]) . '</h5>';
                        echo '<p>' . htmlspecialchars($row["barangay"]) . '</p>';
                        echo '</div>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="text-dark">No results found.</p>';
                }

                mysqli_close($connection);
            }
            ?>
        </div>



        <div>
            <h2 class="ms-3 text-dark text-center mt-3">Hiring Shops Near You</h2>
        </div>

        <div class="container mt-3 text-dark">

            <div class="row">
                <?php if ($shop_result && mysqli_num_rows($shop_result) > 0) : ?>
                    <?php while ($shopData = mysqli_fetch_assoc($shop_result)) : ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">

                                <img src="<?php echo htmlspecialchars($shopData['profile']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($shopData['shop_name']); ?> Profile Image">
                                <h5 class="card-title text-center mb-5"><?php echo htmlspecialchars($shopData['shop_name']); ?></h5>
                                <p>Hiring</p>
                                <div class="container">
                                    <div class="ratings justify-content-center">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <span class="rating-value">5.0</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <center><a class="btn btn-primary" href="user-apply-staff.php?shop_id=<?php echo $shopData['shop_id']; ?>">Apply Shop</a></center>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>

                    <p class="text-center">No shops available.</p>
                <?php endif; ?>

            </div>
        </div>

        </div>


    </main>


    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>




    <script>
        $(document).ready(function() {
            $('#confirmLogout').on('click', function() {
                // Replace with your actual logout URL or logic
                window.location.href = 'logout.php';
            });
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





</body>

</html>