<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$vehicle_id = $_GET['vehicle_id'];
$vehicleID = $_SESSION['vehicle_id'];
$shop_id = $_GET['shop_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM vehicles WHERE vehicle_id = '$vehicle_id'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$vehicleData = mysqli_fetch_assoc($result);

$shop_query = "SELECT *FROM shops WHERE shop_id = '$shop_id'";
$shop_result = mysqli_query($connection, $shop_query);
$shopData = mysqli_fetch_assoc($shop_result);

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
          <h5 class="text-center">Welcome back <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>!</h5>
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
            <li class="v-1 v-2">
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
  <main>
    <div class="container-vinfo text-dark">
      <h2 class="mb-2 offset-md-4">Check Car Condition</h2>
      <h2 class="mb-2">Selected Vehicle</h2>
      <div class="row">
        <div class="col-md-4 mb-4">
          <label for="platenumber">Plate Number:</label>
          <input type="text" class="form-control" id="platenumber" name="platenumber" value="<?php echo $vehicleData['platenumber']; ?>" disabled>
        </div>
        <div class="col-md-4 mb-4">
          <label for="label">Label:</label>
          <input type="hidden" class="form-control" id="vehicle_id" name="id" value="<?php echo $vehicleData['vehicle_id']; ?>">
          <input type="text" class="form-control" id="label" name="label" value="<?php echo $vehicleData['label']; ?>" disabled>
        </div>
        <div class="col-md-4 mb-4">
          <label for="model">Model:</label>
          <input type="text" class="form-control" id="model" name="model" value="<?php echo $vehicleData['model']; ?>" disabled>
        </div>

        <div class="col-md-4 mb-4">
          <label for="enginenumber">Engine Number:</label>
          <input type="text" class="form-control" id="enginenumber" name="enginenumber" value="<?php echo $vehicleData['enginenumber']; ?>" disabled>
        </div>

        <div class="col-md-4 mb-4">
          <label for="chassisnumber">Chassis Number:</label>
          <input type="text" class="form-control" id="chassisnumber" name="chassisnumber" value="<?php echo $vehicleData['chassisnumber']; ?>" disabled>
        </div>

        <div class="col-md-4 mb-4">
          <label for="color">Color:</label>
          <input type="text" class="form-control" id="color" name="color" value="<?php echo $vehicleData['color']; ?>" disabled>
        </div>
      </div>
      <hr class="my-4 dropdown-divider bg-primary" />

      <div class="class mt-5 ms-lg-4 text-dark">
        <h2 class="mb-2">Car Condition</h2>
        <ul class="list-inline mt-5 text-start font-weight-bold">
          <li class="v-3 list-inline-item">LEGENDS:</li>
          <li class="v-3 list-inline-item">0 = NOT GOOD, 500 = GOOD, 1000 = VERY GOOD</li>
        </ul>
        <p>Slide the sliding bar to know if your vehicle has a damage before cleaning.</p>
        <form action="checkingcar_output.php" method="POST">
          <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicleData['vehicle_id']; ?>">
          <input type="hidden" name="user_id" value="<?php echo $userID ?>">
          <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">

          <div class="row g-3 needs-validation" novalidate>
            <!-- Each input group for a car condition -->
            <?php
            $conditions = ['battery', 'lights', 'oil', 'water', 'brake', 'air', 'gas', 'engine', 'tire', 'self'];

            foreach ($conditions as $condition) {
              echo '<div class="form-group col-md-2">';
              echo '<label for="' . $condition . 'Range">' . ucfirst($condition) . ':</label>';
              echo '<input type="range" class="form-range" id="' . $condition . 'Range" name="' . $condition . '" min="0" max="100" step="50" required>';
              echo '<label for="' . $condition . 'Range">' . ucfirst($condition) . ' Condition:</label>';
              echo '<input type="text" class="form-control" id="' . $condition . 'Value" readonly>';
              echo '</div>';
            }
            ?>
            <!-- Total Result -->
            <div class="form-group col-md-4">
              <label for="totalResult">Total Result:</label>
              <input class="form-control" id="totalResult" name="totalResult" readonly>
            </div>

            <div class="container-popup">
              <button type="submit" class="btn btn-primary col-md-4 mb-4 offset-md-3">Submit</button>
            </div>
          </div>
        </form>
      </div>

      <hr class="my-4 dropdown-divider bg-dark">
      </hr>
      <ul class="text-dark">

        <ul class="list-inline mt-5">
          <h2>Car Appearance</h2>
          <li class="list-inline-item">Slide the sliding bar to know if your vehicle is dirty or not.</li>
        </ul>
        <p class="v-3 list-inline-item">LEGENDS:</p>
        <p class="v-3 list-inline-item mt-3 text-danger">0 = NEED TO CLEAN<p class="v-3 list-inline-item mt-3 ms-2 text-success">500 = ALL CLEAN</p></p>
        <form action="checkingcar2-backend.php" method="POST">
          <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id; ?>">
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $userID; ?>">
          <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
          <div class="row g-3 needs-validation mt-5" novalidate>
            <!-- Each input group for a car condition -->
            <?php
            $appearances = ['body', 'windshield', 'interior', 'sidemirror', 'tires'];

            foreach ($appearances as $appearance) {
              echo '<div class="form-group col-md-3">';
              echo '<label for="' . $appearance . '">' . ucfirst($appearance) . ':</label>';

              // Dirty and Clean Labels
              echo '<div class="d-flex justify-content-between">';
              echo '<span class="text-dark">Dirty</span>';
              echo '<span class="text-dark">Clean</span>';
              echo '</div>';

              // Range input
              echo '<input type="range" class="form-range" id="' . $appearance . 'Range" name="' . $appearance . '" min="0" max="100" step="50" required>';

              echo '</div>';
            }

            // Total Result (can be removed if not needed)
            echo '<div class="form-group col-md-4">';
            echo '<label for="appearanceResult">Total Result:</label>';
            echo '<input class="form-control" id="appearanceResult" name="appearanceResult" readonly>';
            echo '</div>';

            // Submit Button
            echo '<div class="container-popup">';
            echo '<button type="submit" class="col-md-4 mb-4 mt-2 offset-md-3 btn btn-primary btn-md">PROCEED</button>';
            echo '</div>';
            ?>
          </div>

        </form>

    </div>



    </div>





  </main>

  <!-- Bootstrap JS and Popper.js -->


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

  <script>
    // Add an event listener for each range input
    <?php
    foreach ($conditions as $condition) {
      echo 'var ' . $condition . 'Range = document.getElementById("' . $condition . 'Range");';
      echo $condition . 'Range.addEventListener("input", updateConditionLabel);';
      echo $condition . 'Range.addEventListener("change", updateRangeInput);';
    }
    ?>

    // Function to update condition label and total result
    function updateConditionLabel() {
      <?php
      foreach ($conditions as $condition) {
        echo 'updateConditionLabelFor("' . $condition . '");';
      }
      ?>

      // Calculate the total result
      updateTotalResult();
    }

    // Function to update range input based on text input
    function updateRangeInput() {
      var conditionId = this.id.replace("Range", "");
      var conditionValue = parseInt(this.value);

      if (isNaN(conditionValue)) {
        conditionValue = 0;
      }

      document.getElementById(conditionId + 'Range').value = conditionValue;

      // Calculate the total result
      updateTotalResult();
    }

    // Function to update condition label for a specific condition
    function updateConditionLabelFor(condition) {
      var conditionRange = document.getElementById(condition + 'Range');
      var conditionValue = parseInt(conditionRange.value);
      var conditionLabel = document.getElementById(condition + 'Value');

      if (conditionValue <= 25) {
        conditionLabel.value = 'NOT GOOD';
      } else if (conditionValue <= 75) {
        conditionLabel.value = 'GOOD';
      } else {
        conditionLabel.value = 'VERY GOOD';
      }
    }

    // Function to update total result
    function updateTotalResult() {
      var totalResult = 0;
      <?php
      foreach ($conditions as $condition) {
        echo 'totalResult += parseInt(document.getElementById("' . $condition . 'Range").value);';
      }
      ?>
      document.getElementById("totalResult").value = totalResult;
    }
  </script>

  <!--CAR APPEARANCE-->

  <script>
    // Add an event listener for each range input
    <?php
    foreach ($appearances as $appearance) {
      echo 'var ' . $appearance . 'Range = document.getElementById("' . $appearance . 'Range");';
      echo $appearance . 'Range.addEventListener("input", updateConditionLabel);';
      echo $appearance . 'Range.addEventListener("change", updateRangeInput);';
    }
    ?>

    // Function to update condition label and total result
    function updateConditionLabel() {
      <?php
      foreach ($appearances as $appearance) {
        echo 'updateAppearanceLabelFor("' . $appearance . '");';
      }
      ?>

      // Calculate the total result
      updateAppearanceResult();
    }

    // Function to update range input based on text input
    function updateRangeInput() {
      var appearanceId = this.id.replace("Range", "");
      var appearanceValue = parseInt(this.value);

      if (isNaN(appearanceValue)) {
        appearanceValue = 0;
      }

      document.getElementById(appearanceId + 'Range').value = appearanceValue;

      // Calculate the total result
      updateAppearanceResult();
    }

    // Function to update condition label for a specific condition
    function updateAppearanceLabelFor(appearance) {
      var appearanceRange = document.getElementById(appearance + 'Range');
      var appearanceValue = parseInt(appearanceRange.value);
      var appearanceLabel = document.getElementById(appearance + 'Value');

      if (appearanceValue <= 25) {
        appearanceLabel.value = 'NEED TO CLEAN';
      } else if (appearanceValue <= 75) {
        appearanceLabel.value = 'CLEAN';
      } else {
        appearanceLabel.value = 'VERY CLEAN';
      }
    }

    // Function to update total result
    function updateAppearanceResult() {
      var appearanceResult = 0;
      <?php
      foreach ($appearances as $appearance) {
        echo 'appearanceResult += parseInt(document.getElementById("' . $appearance . 'Range").value);';
      }
      ?>
      document.getElementById("appearanceResult").value = appearanceResult;
    }
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