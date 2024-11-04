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
$user_id = $_GET['user_id'];
$servicedone_id = $_GET['servicedone_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);



$query = "SELECT finish_jobs.*, users.firstname, users.lastname, 
service_names.service_name, vehicles.vehicle_id, finish_jobs.services, service_details.service
FROM finish_jobs
INNER JOIN service_details ON service_details.selected_id = finish_jobs.selected_id
INNER JOIN vehicles ON vehicles.vehicle_id = finish_jobs.vehicle_id
INNER JOIN users ON finish_jobs.user_id = users.user_id
INNER JOIN service_names ON finish_jobs.servicename_id = service_names.servicename_id WHERE finish_jobs.user_id = $user_id AND finish_jobs.is_deleted = '0'";
// Ordering by first name in ascending order
$result = mysqli_query($connection, $query);
$paymentData = mysqli_fetch_assoc($result);




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
                <li class="">
                    <a href="cashier-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="cashier-dashboard-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li class="v-1">
                    <a href="cashier-dashboard-payment.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-money-bill"></i></i></span>
                        <span>PAYMENTS</span>
                    </a>
                </li>

                <li class="">
                    <a href="cashier-dashboard-records.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-book"></i></i></span>
                        <span>RECORDS</span>
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
        <div class="col-md-9 text-dark ms-5">
            <!-- column 2 -->
            <h2><strong><?php echo $paymentData['firstname']; ?> <?php echo $paymentData['lastname']; ?></strong></h2>
            <p>Below is the services and the prices of the customer.</p>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>All services</strong></div>
                        <div class="card-body">
                            <form action="cspayment_managerconfirm.php" method="POST">




                                <?php
                                $totalPrice = 0; // Initialize total price variable

                                if ($result) {
                                    // Loop through the results to create cards
                                    foreach ($result as $row) {
                                        echo '<div class="col-md-4 mb-3">';
                                        echo '<div class="card">';
                                        echo '<div class="card-header">' . (isset($row['firstname']) ? $row['firstname'] : 'N/A') . " " . (isset($row['lastname']) ? $row['lastname'] : 'N/A') . '</div>';
                                        echo '<div class="card-body">';
                                        echo '<p><strong>Services:</strong> ';

                                        // Explode the services and display each one individually
                                        $services = isset($row['services']) ? explode(',', $row['services']) : array();
                                        foreach ($services as $service) {
                                            echo htmlspecialchars($service) . '<br>'; // Added htmlspecialchars for safety
                                        }
                                        echo '<p><strong>Cleaning Product:</strong> ';

                                        $services = isset($row['product_name']) ? explode(',', $row['product_name']) : array();
                                        foreach ($services as $service) {
                                            echo htmlspecialchars($service) . '<br>'; // Added htmlspecialchars for safety
                                        }

                                        echo '<p><strong>Price:</strong> ₱ ' . number_format($paymentData['total_price'] / 100, 2) . '</p>'; // Display the total price directly
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<div class="col-md-12">';
                                    echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($connection) . '</div>';
                                    echo '</div>';
                                }
                                ?>

                                <!-- Modal -->
                                <div class="modal fade" id="changeModal" tabindex="-1" aria-labelledby="changeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeModalLabel">Calculating Payment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date of Payment:</label>
                                                    <input type="text" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $paymentData['user_id']; ?>">
                                                    <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $paymentData['vehicle_id']; ?>">
                                                    <input type="hidden" name="firstname" id="firstname" value="<?php echo $paymentData['firstname']; ?>">
                                                    <input type="hidden" name="lastname" id="lastname" value="<?php echo $paymentData['lastname']; ?>">
                                                    <input type="hidden" name="servicedone_id" id="servicedone_id" value="<?php echo $servicedone_id;?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_method" class="form-label">Payment Method:</label>
                                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                                        <option value="None">Select</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="G Cash">G Cash</option>
                                                        <option value="Maya">Maya</option>
                                                        <option value="Paypal">Paypal</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <?php
                                                    // Convert the total price to a float
                                                    $totalPriceFloat = $paymentData['total_price'] / 100;
                                                    ?>
                                                    <h4>Total Price: <span id="modalTotalPrice"class="price text-dark" data-price="<?php echo $totalPriceFloat; ?>">₱<?php echo number_format($paymentData['total_price'] / 100, 2); ?></span></h4>
                                                    <label for="modalAmount" class="form-label">Amount Paid (&#x20B1;): </label>
                                                    <input type="number" class="form-control" name="modalAmount" id="modalAmount" value=".00" step="0.01" required>
                                                    <h1 id="changeResult" style="color:red; font-weight: bold;"></h1>
                                                    <input type="hidden" name="change_amount" id="change_amount">
                                                    <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $totalPriceFloat; ?>">₱<?php echo number_format($paymentData['total_price'] / 100, 2); ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" id="confirmChangeBtn">Accept</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="margin-left: 10px; margin-bottom: 10px;">
                                    <h4>Total Price: ₱<?php echo number_format($paymentData['total_price'] / 100, 2); ?></h4>

                                </div>

                                <button type="button" class="btn btn-primary" id="calculateChangeBtn" style="margin-left: 10px;">
                                    Confirm
                                </button>
                        </div>
                    </div>
                </div>
    </main>

    <script>
        // Show modal when Confirm button is clicked
        document.getElementById('calculateChangeBtn').addEventListener('click', function() {
            var changeModal = new bootstrap.Modal(document.getElementById('changeModal'));
            changeModal.show();
        });

        // Calculate change on Accept button click
        document.getElementById('confirmChangeBtn').addEventListener('click', function() {
            var totalPrice = parseFloat(document.getElementById('modalTotalPrice').dataset.price); // Ensure this is a float
            var amountPaid = parseFloat(document.getElementById('modalAmount').value); // Get amount paid

            // Validate amount paid
            if (isNaN(amountPaid) || amountPaid < 0) {
                alert('Please enter a valid amount.');
                return;
            }

            var change = amountPaid - totalPrice; // Calculate change
            var changeResult = document.getElementById('changeResult');
            var changeAmountInput = document.getElementById('change_amount'); // Hidden input field for change amount

            // Display change or insufficient funds message
            if (change >= 0) {
                changeResult.innerHTML = 'Change: &#x20B1;' + change.toFixed(2);
                changeAmountInput.value = change.toFixed(2); // Set the hidden input with the change amount
            } else {
                changeResult.innerHTML = 'Insufficient amount paid.';
                changeAmountInput.value = ''; // Clear the hidden input if no change
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>