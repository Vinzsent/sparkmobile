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
$selected_id = $_GET['selected_id'];
$servicename_id = $_GET['servicename_id'];
$user_id = $_GET['user_id'];


$staff_query = "SELECT *FROM users WHERE user_id = '$userID'";
$staff_result = mysqli_query($connection, $staff_query);
$staffData = mysqli_fetch_assoc($staff_result);

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM vehicles WHERE user_id = '$user_id'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);


$selected_query = "SELECT ss.*, sn.service_name, u.firstname, u.lastname, ss.status,
qs.slotNumber
FROM service_details ss
INNER JOIN queuing_slots qs ON ss.slotNumber = qs.slotNumber
INNER JOIN service_names sn ON ss.servicename_id = sn.servicename_id
INNER JOIN users u ON ss.user_id = u.user_id
WHERE ss.selected_id = '$selected_id' AND ss.servicename_id = '$servicename_id'";


// Execute the query and fetch the user data
$selected_result = mysqli_query($connection, $selected_query);
$selectedData = mysqli_fetch_assoc($selected_result);



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
    width: 400px;
    /* Adjust the size as needed */
    height: 200px;
    object-fit: cover;
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


  .game-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
  }

  .game-logo {
    width: 80px;
    height: 80px;
    border-radius: 16px;
  }

  .ratings .star {
    color: gold;
  }

  /* Main Content Styling */
  main {
    background: #f8f9fa;
    padding: 2rem 0;
    min-height: 100vh;
  }

  /* Card Styling */
  .card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 30px;
    background: #fff;
  }

  .card-header {
    background: linear-gradient(135deg, #072797, #0a2d99) !important;
    padding: 1.5rem;
    border-bottom: none;
  }

  .card-header h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
  }

  .card-body {
    padding: 2rem;
  }

  /* Vehicle Image Styling */
  .img-account-profile {
    width: 500px;
    height: 300px;
    object-fit: contain;
    border-radius: 12px;
    border: 1px solid rgba(7, 39, 151, 0.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    margin: 1rem auto 2rem;
    background-color: #fff;
    padding: 15px;
    transition: all 0.3s ease;
    display: block;
  }

  /* Form Elements */
  .form-label {
    color: #072797;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
  }

  .form-control {
    border: 1px solid rgba(7, 39, 151, 0.1);
    border-radius: 12px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    color: #444;
    margin-bottom: 1rem;
  }

  .form-control:focus {
    border-color: #072797;
    box-shadow: 0 0 0 0.2rem rgba(7, 39, 151, 0.1);
  }

  /* Timer Section Styling */
  .form-group.mb-3.text-dark {
    background: rgba(7, 39, 151, 0.03);
    padding: 1.5rem;
    border-radius: 15px;
    margin-top: 2rem;
  }

  #startTime, #endTime {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    font-weight: 600;
    text-align: center;
    background: #fff;
    color: #072797;
    border: 2px solid rgba(7, 39, 151, 0.1);
  }

  /* Toggle Button Styling */
  #toggleBtn {
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 12px;
    transition: all 0.3s ease;
    margin: 1rem 0;
    width: 200px;
  }

  #toggleBtn.btn-primary {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
  }

  #toggleBtn.btn-danger {
    background: linear-gradient(135deg, #dc3545, #ef5350);
    border: none;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
  }

  #toggleBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  /* Price Display */
  #total_price_1 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #FF5722;
    background: rgba(255, 87, 34, 0.05);
    border: 2px solid rgba(255, 87, 34, 0.1);
    text-align: center;
  }

  /* Service Details Box */
  .detail-box {
    background: rgba(7, 39, 151, 0.03);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
  }

  .detail-title {
    color: #072797;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
  }

  /* Animation Effects */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .card {
    animation: fadeIn 0.5s ease-out;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .img-account-profile {
      width: 100%;
      max-width: 450px;
      height: auto;
      aspect-ratio: 16/9;
    }
    
    .card-body {
      padding: 1.5rem;
    }
    
    #toggleBtn {
      width: 100%;
    }
    
    .form-group.mb-3.text-dark {
      padding: 1rem;
    }
  }

  /* Customer Name Styling */
  h4.text-black {
    color: #072797;
    font-weight: 600;
    font-size: 1.5rem;
    margin: 1.5rem 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(7, 39, 151, 0.1);
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
          <h5 class="text-center">Welcome back <?php echo $staffData['firstname']; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li class="v-1">
          <a href="staff-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li class="">
          <a href="staff-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>
        <li>

        <li class="">
          <a href="owner-shop-profile1.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-calendar"></i></i></span>
            <span>HISTORY</span>
          </a>
        </li>

        <li>
          <a href="#" class="nav-link px-3">
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
  <main>
    <div class="personal-details text-dark">
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <!-- Customer Info Card -->
            <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Customer Profile</h3>
              </div>
              <div class="card-body text-center">
                <!-- Profile Image -->
                <img src="<?php echo $userData['profile']; ?>" alt="Profile Image" class="img-account-profile mb-3">

                <!-- Customer Name -->
                <h4 class="text-black">Customer Name: <?php echo $selectedData['firstname']; ?> <?php echo $selectedData['lastname']; ?></h4>

                <hr class="mt-4 mb-4">

                <!-- Form to display services, prices, products, and total price -->
                <form action="staff-dashboard-start-cleaning-backend.php" method="POST">
                  <!-- Hidden inputs -->
                  <input type="hidden" name="selected_id" value="<?php echo $selectedData['selected_id']; ?>">
                  <input type="hidden" name="vehicle_id" value="<?php echo $selectedData['vehicle_id']; ?>">
                  <input type="hidden" name="servicename_id" value="<?php echo $selectedData['servicename_id']; ?>">
                  <input type="hidden" name="user_id" value="<?php echo $selectedData['user_id']; ?>">
                  <input type="hidden" name="status" id="status" value="<?php echo $selectedData['status']; ?>">
                  <input type="hidden" name="is_deleted" id="is_deleted" value="0">
                  <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $staffData['staff_id']; ?>">
                  <input type="hidden" name="slotNumber" id="slotNumber" value="<?php echo $selectedData['slotNumber']; ?>">

                  <?php
                  // Fetch all services and prices grouped by slotNumber for the current user
                  $user_id = $selectedData['user_id'];
                  $service_query = "SELECT slotNumber, 
                                                   GROUP_CONCAT(service) AS service, 
                                                   GROUP_CONCAT(price) AS prices, 
                                                   GROUP_CONCAT(product_name) AS product_names, 
                                                   GROUP_CONCAT(product_price) AS product_prices,
                                                   GROUP_CONCAT(inventory_id) AS inventory_id,
                                                   GROUP_CONCAT(quantity) AS quantity    
                                                   FROM service_details 
                                                   WHERE user_id = '$user_id' 
                                                   GROUP BY slotNumber";

                  $service_result = mysqli_query($connection, $service_query);

                  // Initialize total price
                  $totalPrice = 0;

                  // Loop through the results and display services and prices per slot
                  while ($row = mysqli_fetch_assoc($service_result)) {
                    $slotNumber = $row['slotNumber'];
                    $services = explode(',', $row['service']);
                    $inventory_id = explode(',', $row['inventory_id']);
                    $quantity = explode(',', $row['quantity']);
                    $prices = explode(',', $row['prices']);
                    $product_names = array_filter(explode(',', $row['product_names']), function ($name) {
                      return $name != ''; // Filter out empty product names to remove unnecessary commas
                    });
                    $product_prices = explode(',', $row['product_prices']);

                    // Calculate total price for each slot
                    $service_total = array_sum($prices); // Array of service prices
                    $product_total = array_sum($product_prices); // Sum of product prices

                    // Calculate the total price (services + product)
                    $total_price = $service_total + $product_total;
                  ?>
                    <!-- Display grouped services by slot -->
                    <div class="row mb-3">
                      <input type="hidden" name="inventory_id" id="services_<?php echo $slotNumber; ?>" value="<?php echo implode(', ', $inventory_id); ?>">
                      <input type="hidden" name="quantity" id="services_<?php echo $slotNumber; ?>" value="<?php echo implode(', ', $quantity); ?>">
                      <!-- Services -->
                      <div class="col-md-6">
                        <strong><label for="services_<?php echo $slotNumber; ?>" class="form-label">Services:</label></strong>
                        <textarea class="form-control" name="services" id="services_<?php echo $slotNumber; ?>" rows="3" readonly><?php echo implode(', ', $services); ?></textarea>
                      </div>


                      <!-- Prices -->
                      <div class="col-md-6">
                        <strong><label for="prices_<?php echo $slotNumber; ?>" class="form-label">Prices:</label></strong>
                        <textarea class="form-control" name="price" id="prices_<?php echo $slotNumber; ?>" rows="3" readonly>₱ <?php echo implode(', ₱ ', $prices); ?></textarea>
                      </div>

                      <!-- Products and Product Prices -->
                      <?php if (!empty($product_names)) { ?>
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <strong><label for="product_<?php echo $slotNumber; ?>" class="form-label">Cleaning Products:</label></strong>
                            <textarea class="form-control" name="product_name" id="product_<?php echo $slotNumber; ?>" rows="3" readonly><?php echo implode(', ', $product_names); ?></textarea>
                          </div>
                          <div class="col-md-6">
                            <strong><label for="product_price_<?php echo $slotNumber; ?>" class="form-label">Product Prices:</label></strong>
                            <textarea class="form-control" name="product_price" id="product_price_<?php echo $slotNumber; ?>" rows="3" readonly>₱ <?php
                                                                                                                                                  $formatted_product_prices = array_map(function ($price) {
                                                                                                                                                    if (!empty($price)) {
                                                                                                                                                      return number_format(floatval(str_replace(['₱', ' ', ','], '', $price)), 2);
                                                                                                                                                    }
                                                                                                                                                    return '';
                                                                                                                                                  }, $product_prices);
                                                                                                                                                  echo implode(', ₱ ', array_filter($formatted_product_prices));
                                                                                                                                                  ?></textarea>
                          </div>
                        </div>
                      <?php } ?>

                    <?php } ?>

                    <!-- Total Price -->
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <strong><label for="total_price_<?php echo $slotNumber; ?>" class="form-label">Total Price:</label></strong>
                        <input type="text" class="form-control" name="total_price" id="total_price_<?php echo $slotNumber; ?>" value="₱ <?php echo number_format($total_price, 2); ?>" readonly>
                      </div>
                    </div>

                    <!-- Timer -->
                    <div class="form-group mb-3 text-dark">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Start Time:</label>
                          <input type="text" id="startTime" name="start_time" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                          <label>End Time:</label>
                          <input type="text" id="endTime" name="end_time" class="form-control" readonly>
                        </div>
                      </div>
                    </div>

                    <!-- Single toggle button -->
                    <button id="toggleBtn" type="button" class="btn btn-primary btn-md mb-3">Start</button>
                    <input type="hidden" id="isFinished" name="is_finished" value="0">
                </form>
              </div>
            </div> <!-- End of Card -->
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      var isStarted = false;
      var startTimeValue = '';
      
      // Function to get current time in MySQL datetime format
      function getCurrentDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      }

      $('#toggleBtn').click(function() {
        if (!isStarted) {
          // Start button clicked
          isStarted = true;
          $(this).text('Stop');
          $(this).removeClass('btn-primary').addClass('btn-danger');
          
          // Record start time
          startTimeValue = getCurrentDateTime();
          $('#startTime').val(startTimeValue);
          $('#endTime').val('');
          
        } else {
          // Stop button clicked
          if (confirm('Are you sure you want to finish this service?')) {
            isStarted = false;
            $(this).prop('disabled', true);
            
            // Record end time
            const endTimeValue = getCurrentDateTime();
            $('#endTime').val(endTimeValue);
            $('#isFinished').val('1');
            
            // Submit the form
            $(this).closest('form').submit();
          }
        }
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






  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>