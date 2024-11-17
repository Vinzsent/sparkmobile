<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

$userID = $_SESSION['user_id'];

$userquery = "SELECT * FROM users WHERE user_id = '$userID'";
$userresult = mysqli_query($connection, $userquery);
$userData = mysqli_fetch_assoc($userresult);

// Use a JOIN query to fetch data from multiple tables
$query = "SELECT 
sd.*, v.platenumber, v.brand, v.color, v.model, sn.service_name,co.firstname,co.lastname, sn.shop_id, sd.servicename_id, sd.total_price
FROM finish_jobs sd
INNER JOIN vehicles v ON sd.vehicle_id = v.vehicle_id
INNER JOIN service_names sn ON sd.servicename_id = sn.servicename_id
INNER JOIN users co ON sd.user_id = co.user_id
WHERE sd.user_id = '$userID' AND v.status = 'Currently Washing'";

$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
  die("Error: " . mysqli_error($connection));
}

// Fetch the data
$vehicleData = mysqli_fetch_assoc($result);

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
  <link rel="stylesheet" href="csdashboard.css" />
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

  .icons .fa {
    color: orangered;
    margin: 0 13px;
    cursor: pointer;
    padding: 18px 0;
  }

  .fa-heart {
    color: orangered;
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

  @media (max-width: 1407px) {
    .text-box {
      padding: 6px;
      background: orangered;
      border-radius: 10px;
      width: 50%;
      height: auto;
      position: absolute;
      top: 30%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      /* Center content horizontally */
    }

    .text-box h5 {
      margin-bottom: 15px;
    }

    .text-box .btn {
      background-color: #072797;
      text-decoration: none;
      width: 58%;
    }

  }

  @media (max-width: 414px) {

    .text-box {
      width: 300px;
    }
  }

  .appointment-container {
    padding: 30px;
    margin-top: 60px;
  }

  .service-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .service-card:hover {
    transform: translateY(-5px);
  }

  .card-header.v-1 {
    background: #072797;
    color: white;
    padding: 15px 20px;
    font-weight: 500;
    font-size: 1.1rem;
    border: none;
  }

  .card-body {
    padding: 25px;
    background: #fff;
    color: #333;
  }

  .card-title {
    color: #072797;
    font-weight: 600;
    margin-bottom: 15px;
  }

  .card-text {
    margin-bottom: 10px;
    color: #555;
  }

  .info-label {
    font-weight: 500;
    color: #072797;
    margin-right: 8px;
  }

  .service-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
  }

  .btn-view-service {
    background: #072797;
    color: white;
    padding: 12px 30px;
    border-radius: 5px;
    border: none;
    transition: all 0.3s ease;
    margin-top: 20px;
    display: inline-block;
  }

  .btn-view-service:hover {
    background: orangered;
    transform: translateY(-2px);
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .row {
      flex-direction: column;
    }
    .col {
      margin-bottom: 20px;
    }
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
            <a
              class="nav-link dropdown-toggle ms-2"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-person-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="csdashboard.html">Profile</a></li>
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


    <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar" <div class="offcanvas-body p-0">
        <nav class="">
            <ul class="navbar-nav">


                <div class=" welcome fw-bold px-3 mb-3">
                    <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?>!</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li>
                <li>
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
                </li">
                <li class="v-1">
                  <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
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
                            <li class="v-2">
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
  </div>
  <!-- main content -->
  <main>
    <div class="appointment-container">
        <div class="container-fluid">
            <h2 class="mb-4 text-dark"><i class="fas fa-calendar-check me-2"></i>Current Appointment</h2>
            
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $userID ?>">
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicleData['vehicle_id']; ?>">
            <input type="hidden" name="servicename_id" name="servicename_id" value="<?php echo $vehicleData['servicename_id']; ?>">

            <div class="service-card">
                <div class="card-body">
                    <div class="row">
                        <!-- User Information -->
                        <div class="col">
                            <div class="card-header v-1">
                                <i class="fas fa-user me-2"></i>User Information
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <span class="info-label">First Name:</span>
                                    <?php echo $vehicleData['firstname']; ?>
                                </p>
                                <p class="card-text">
                                    <span class="info-label">Last Name:</span>
                                    <?php echo $vehicleData['lastname']; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Vehicle Details -->
                        <div class="col">
                            <div class="card-header v-1">
                                <i class="fas fa-car me-2"></i>Vehicle Details
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <span class="info-label">Plate Number:</span>
                                    <?php echo $vehicleData['platenumber']; ?>
                                </p>
                                <p class="card-text">
                                    <span class="info-label">Color:</span>
                                    <?php echo $vehicleData['color']; ?>
                                </p>
                                <p class="card-text">
                                    <span class="info-label">Brand:</span>
                                    <?php echo $vehicleData['brand']; ?>
                                </p>
                                <p class="card-text">
                                    <span class="info-label">Model:</span>
                                    <?php echo $vehicleData['model']; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="col">
                            <div class="card-header v-1">
                                <i class="fas fa-tools me-2"></i>Services
                            </div>
                            <div class="card-body">
                                <div class="service-info">
                                    <p class="card-text">
                                        <span class="info-label">Service Name:</span>
                                        <?php echo $vehicleData['service_name']; ?>
                                    </p>
                                    <p class="card-text">
                                        <span class="info-label">Services:</span>
                                        <?php echo $vehicleData['services']; ?>
                                    </p>
                                    <p class="card-text">
                                        <span class="info-label">Price:</span>
                                        ₱<?php echo number_format($vehicleData['total_price'], 2, '.', ','); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- button to view service details -->
             <a href="csservice_view1.php?user_id=<?php echo $userID; ?>&vehicle_id=<?php echo $vehicleData['vehicle_id']; ?>&shop_id=<?php echo $vehicleData['shop_id']; ?>&servicename_id=<?php echo $vehicleData['servicename_id']; ?>" 
               class="btn-view-service" style="text-decoration: none;">
                <i class="fas fa-eye me-2"></i>View Service Details
            </a>
        </div>
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