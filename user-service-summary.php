<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// At the top of your file, after database connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to ensure proper character encoding
mysqli_set_charset($connection, "utf8mb4");

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];





$query1 = "SELECT * FROM users WHERE user_id = $userID";
// Execute the query and fetch the user data
$result1 = mysqli_query($connection, $query1);
$userData = mysqli_fetch_assoc($result1);

$service_query = "SELECT sd.*, u.firstname, u.lastname, i.product_name 
                 FROM service_details sd
                 LEFT JOIN users u ON sd.user_id = u.user_id
                 LEFT JOIN inventory_records i ON sd.inventory_id = i.inventory_id
                 WHERE sd.user_id = '$userID'";
$result2 = mysqli_query($connection, $service_query);

// Check if query was successful
if (!$result2) {
    die("Query failed: " . mysqli_error($connection));
}

$servicedone_query = "SELECT * FROM finish_jobs WHERE user_id = '$userID'";
$result3 = mysqli_query($connection, $servicedone_query);
$servicedoneData = mysqli_fetch_assoc($result3);

$service_query = "SELECT vehicle_id, shop_id, selected_id, servicename_id FROM service_details WHERE user_id = '$userID'";
$result4 = mysqli_query($connection, $service_query);
$serviceData = mysqli_fetch_assoc($result4);

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

    .v-4 {
      background-color: #d9d9d9;
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

    .my-6:hover {
      background-color: #d9d9d9;
      color: #000
    }

    .navbar {
      background-color: #072797;
    }

    .btn:hover {
      background-color: #072797;
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
      font-size: 20px;
    }

    .my-5 {
      margin-left: -20px;
    }

    /* Custom style to resize the checkbox */
    .checkbox-container {
      display: flex;
      /* Use flexbox for layout */
      align-items: center;
      /* Center items vertically */
    }

    .checkbox {
      /* Optional: Customize checkbox size */
      width: 1.5em;
      height: 1.5em;
      margin-right: 10px;
      /* Adjust spacing between checkbox and label */
    }


    .ex-1 {
      color: red;
    }

    /* Main Content Styling */
    main {
      padding: 2rem;
      background-color: #f8f9fa;
      min-height: calc(100vh - 60px);
    }

    .content-wrapper {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .page-title {
      color: #072797;
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
    }

    /* Table Styling */
    .table-container {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .table {
      margin-bottom: 0;
    }

    .table thead {
      background: linear-gradient(135deg, #072797, #0a3acf);
    }

    .table thead th {
      color: white;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 0.85rem;
      padding: 1rem;
      border: none;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: #f8f9fa;
      transform: translateY(-2px);
    }

    .table td {
      padding: 1rem;
      vertical-align: middle;
      border-bottom: 1px solid #f0f0f0;
    }

    /* Status Badge */
    .status-badge {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-done {
      background-color: #d4edda;
      color: #155724;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .btn-custom {
      padding: 0.6rem 1.5rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-add {
      background: linear-gradient(135deg, #28a745, #20c997);
      border: none;
      color: white;
    }

    .btn-proceed {
      background: linear-gradient(135deg, #072797, #0a3acf);
      border: none;
      color: white;
    }

    /* Service Item Styling */
    .service-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .service-icon {
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      background: #e8f0fe;
      color: #072797;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 3rem;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      main {
        padding: 1rem;
      }

      .content-wrapper {
        padding: 1rem;
      }

      .action-buttons {
        flex-direction: column;
      }

      .btn-custom {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
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


    class="offcanvas-body p-0">
    <nav class="">
      <ul class="navbar-nav">


        <div class=" welcome fw-bold px-3 mb-3">
          <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li class="">
          <a href="user-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li class="">
          <a href="csdashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>

        <li>
          <a href="cscars1.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-car"></i></i></span>
            <span>MY CARS</span>
          </a>
        </li>
        <li class="v-1">
          <a
            class="nav-link px-3 sidebar-link"
            data-bs-toggle="collapse"
            href="#layouts">
            <span class="me-2"><i class="fas fa-calendar"></i></i></span>
            <span>BOOKINGS</span>
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
              <a href="setappoinment.php" class="nav-link px-3">
                <span class="me-2">Set Appointment</span>
              </a>
            </li>
            <li class="v-1">
              <a href="checkingcar.php" class="nav-link px-3">
                <span class="me-2">Checking car condition</span>
              </a>
            </li>
            <li class="v-1">
              <a href="#" class="nav-link px-3">
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
            <li class="v-1 v-2">
              <a href="#" class="nav-link px-3">
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
  <?php
  if (mysqli_num_rows($result2) > 0) {
  ?>
    <main>
    <div class="content-wrapper">
        <h1 class="page-title">
            <i class="fas fa-car me-2"></i>
            Vehicle Service Status
        </h1>

        <div class="action-buttons">
            <a href="csprocess3-4.php?user_id=<?php echo $userData['user_id']; ?>&vehicle_id=<?php echo $serviceData['vehicle_id']; ?>&shop_id=<?php echo $serviceData['shop_id']; ?>&selected_id=<?php echo $serviceData['selected_id']; ?>&servicename_id=<?php echo $serviceData['servicename_id']; ?>" 
               class="btn btn-custom btn-add">
                <i class="fas fa-plus-circle"></i>
                Add Services
            </a>
            <a href="cspayment.php?vehicle_id=<?php echo $serviceData['vehicle_id']; ?>" 
               id="proceedButton" 
               class="btn btn-custom btn-proceed">
                <i class="fas fa-arrow-right"></i>
                Proceed to Payment
            </a>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>SERVICES</th>
                        <th>DURATION</th>
                        <th>PRODUCTS</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Debug line to check if data exists
                    echo "Number of rows: " . mysqli_num_rows($result2);
                    
                    if ($result2 && mysqli_num_rows($result2) > 0): 
                        while ($serviceData = mysqli_fetch_assoc($result2)): 
                    ?>
                        <tr>
                            <td>
                                <div class="service-item">
                                    <i class="fas fa-tools me-2"></i>
                                    <?php echo htmlspecialchars($serviceData['service'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                if (isset($servicedoneData['timer'])) {
                                    echo htmlspecialchars($servicedoneData['timer']);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if (!empty($serviceData['product_name'])): ?>
                                    <div class="service-item">
                                        <i class="fas fa-spray-can me-2"></i>
                                        <?php echo htmlspecialchars($serviceData['product_name']); ?>
                                    </div>
                                <?php else: ?>
                                    <a href="user-dashboard-select-products.php?user_id=<?php echo $userID; ?>&vehicle_id=<?php echo $serviceData['vehicle_id']; ?>&shop_id=<?php echo $serviceData['shop_id']; ?>&selected_id=<?php echo $serviceData['selected_id']; ?>&servicename_id=<?php echo $serviceData['servicename_id']; ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus-circle me-1"></i>
                                        Add Products
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge <?php echo ($serviceData['status'] ?? '') === 'Done' ? 'status-done' : 'status-pending'; ?>">
                                    <i class="fas <?php echo ($serviceData['status'] ?? '') === 'Done' ? 'fa-check-circle' : 'fa-clock'; ?> me-1"></i>
                                    <?php echo htmlspecialchars($serviceData['status'] ?? 'Pending'); ?>
                                </span>
                            </td>
                            <td>
                                <form action="user-delete_service.php" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    <input type="hidden" name="selected_id" value="<?php echo $serviceData['selected_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                                    <input type="hidden" name="shop_id" value="<?php echo $serviceData['shop_id']; ?>">
                                    <input type="hidden" name="vehicle_id" value="<?php echo $serviceData['vehicle_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt me-1"></i>
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox mb-3"></i>
                                    <p>No services found. Please add a service.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

  <?php
  } else {
    // No data found message
    echo "<p>No data found.</p>";
  }

  // Close database connection
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