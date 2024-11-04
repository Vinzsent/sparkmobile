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


// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);



// Use a JOIN query to fetch data from multiple tables
$invoice_query = "
SELECT 
    users.*, 
    service_details.*
FROM 
    service_details
INNER JOIN 
    users ON users.user_id = service_details.user_id
WHERE 
    service_details.user_id = '$userID'
";


$invoice_result = mysqli_query($connection, $invoice_query);


// Check if the query was successful
if (!$invoice_result) {
  die("Error: " . mysqli_error($connection));
}

// Fetch the data
$invoiceData = mysqli_fetch_assoc($invoice_result);

$query2 = "SELECT *FROM payment_details WHERE user_id = '$userID'";
$result2 = mysqli_query($connection, $query2);
$paymentData = mysqli_fetch_assoc($result2);

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
      visibility: hidden;
      /* Hide everything */
    }

    #invoice,
    #invoice * {
      visibility: visible;
      /* Show only the invoice */
    }

    #invoice {
      position: absolute;
      left: 0;
      top: 0;
      /* Position it for print */
    }

    #print-button {
      display: none;
      /* Hide the print button */
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
        <li class="v-1">
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
              <li class="v-2">
                <a href="csinvoice.php" class="nav-link px-3">
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
  <!-- main content -->
  <main>
    <?php
    // Initialize an array to store all the invoice data
    $invoiceDataArray = array();

    // Fetch data from the database and store it in the array
    mysqli_data_seek($invoice_result, 0);
    while ($invoiceData = mysqli_fetch_assoc($invoice_result)) {
      $invoiceDataArray[] = $invoiceData;
    }

    // Calculate subtota
    ?>

    <div class="container" id="invoice">
      <div class="row">
        <h2 class="mb-4 text-dark text-center">INVOICE</h2>
        <div class="col-md-6 text-dark mb-5">
          <h5>Invoice to:</h5>
          <p><?php echo isset($invoiceDataArray[0]['firstname']) ? $invoiceDataArray[0]['firstname'] : ''; ?> <?php echo isset($invoiceDataArray[0]['lastname']) ? $invoiceDataArray[0]['lastname'] : ''; ?></p>
          <p><?php echo isset($invoiceDataArray[0]['barangay']) ? $invoiceDataArray[0]['barangay'] : ''; ?></p>
          <p><?php echo isset($invoiceDataArray[0]['email']) ? $invoiceDataArray[0]['email'] : ''; ?></p>
        </div>
        <div class="col-md-6 text-dark">
          <h5>Invoice No: # <?php echo $paymentData['payment_id'] ?></h5>
          <h5>Date: <?php echo $paymentData['date']; ?></h5>
          <h5>Mode of Payment: <?php echo $paymentData['payment_method']; ?></h5>
        </div>
      </div>

      <div class="table-responsive">
        <!-- First Table: Services -->
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th class="text-center" style="width: 40%;">Services</th>
              <th class="text-center" style="width: 20%;">Quantity</th>
              <th class="text-center" style="width: 40%;">Price</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($invoiceDataArray as $invoiceData) {
              // Explode services and prices into arrays
              $services = explode(',', $invoiceData['service']); // Split services
              $prices = explode(',', $invoiceData['price']); // Split prices

              // Ensure the arrays have the same count
              $count = max(count($services), count($prices));

              // Loop through each service and its corresponding price
              for ($i = 0; $i < $count; $i++) {
                // Get the service and price; use empty string as fallback
                $service = isset($services[$i]) ? trim($services[$i]) : 'N/A';

                // Clean up the price and convert to float
                $price = isset($prices[$i]) ? trim($prices[$i]) : '';
                $priceFloat = floatval(str_replace(['₱', ' ', ','], '', $price)); // Remove currency symbol, spaces, and commas
            ?>
                <tr>
                  <td class="text-center"><?php echo htmlspecialchars($service); ?></td> <!-- Display service -->
                  <td class="text-center">1</td> <!-- Set quantity to always be '1' -->
                  <td class="text-center">₱<?php echo number_format($priceFloat, 2); ?></td> <!-- Display price -->
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>

        <!-- Second Table: Cleaning Products -->
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th class="text-center" style="width: 40%;">Cleaning Products</th>
              <th class="text-center" style="width: 20%;">Quantity</th>
              <th class="text-center" style="width: 40%;">Product Price</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Flag to track if any products exist
            $hasProducts = false;

            foreach ($invoiceDataArray as $invoiceData) {
              // Explode product names and prices into arrays
              $product_names = explode(',', $invoiceData['product_name']); // Split product names
              $product_prices = explode(',', $invoiceData['product_price']); // Split product prices

              // Ensure both arrays have the same count
              $count = max(count($product_names), count($product_prices));

              // Loop through each product name and its corresponding price
              for ($j = 0; $j < $count; $j++) {
                // Get the product name and price; use empty string as fallback
                $productName = isset($product_names[$j]) ? trim($product_names[$j]) : 'N/A';

                // Clean up the product price and convert to float
                $productPrice = isset($product_prices[$j]) ? trim($product_prices[$j]) : '';
                $productPriceFloat = floatval(str_replace(['₱', ' ', ','], '', $productPrice)); // Remove currency symbol, spaces, and commas

                // Check if product name is not empty
                if (!empty($productName)) {
                  $hasProducts = true; // Set flag to true if at least one product exists
            ?>
                  <tr>
                    <td class="text-center"><?php echo htmlspecialchars($productName); ?></td> <!-- Display product name -->
                    <td class="text-center"><?php echo htmlspecialchars($invoiceData['quantity']); ?></td> <!-- Display quantity -->
                    <td class="text-center">₱<?php echo number_format($productPriceFloat, 2); ?></td> <!-- Display product price -->
                  </tr>
              <?php
                }
              }
            }

            // If no products exist, display empty placeholders
            if (!$hasProducts) {
              ?>
              <tr>
                <td class="text-center" colspan="3">No cleaning products available.</td>
              </tr>
            <?php
            }
            ?>
            <tr class="thick-border">
              <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
              <td class="text-center">₱<?php echo number_format($paymentData['subtotal'], 2); ?></td>
            </tr>
            <tr>
              <td colspan="2" class="text-end"><strong>Amount Paid:</strong></td>
              <td class="text-center">₱<?php echo number_format($paymentData['amount'], 2); ?></td> <!-- Use the float for amount paid -->
            </tr>
            <tr>
              <td colspan="2" class="text-end"><strong>Change:</strong></td>
              <td class="text-center">₱<?php echo number_format($paymentData['change_amount'], 2); ?></td> <!-- Ensure to use the calculated change -->
            </tr>
          </tbody>
        </table>
      </div>
      <button id="print-button" class="btn btn-primary" type="button" onclick="printInvoice()">Print Invoice</button>
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

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-dark" id="logoutModalLabel">Confirm Logout</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        <h4>Are you sure you want to log out?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        <a href="logout.php" class="btn btn-primary">Logout</a>
      </div>
    </div>
  </div>
</div>