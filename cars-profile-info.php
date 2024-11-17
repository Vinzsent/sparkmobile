<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location index.php");
  exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$vehicle_id = $_GET['vehicle_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM vehicles WHERE vehicle_id = '$vehicle_id'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
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

  .img-account-profile {
    width: 300px;
    /* Adjust the size as needed */
    height: 150px;
    object-fit: cover;
    border-radius: 10%;
  }

  li:hover {
    background: #072797;
  }

  .v-1 {
    background-color: #072797;
    color: #fff;
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
  .garage-btn{
  margin-left: 50%;
  }

  .profile-container {
    padding: 40px;
    margin-top: 80px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    color: orangered;
  }

  .profile-btn, .save-btn, .upload-btn {
    background: #072797;
    color: white;
    padding: 12px 25px;
    border-radius: 5px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }

  .profile-btn:hover, .save-btn:hover, .upload-btn:hover {
    background: orangered;
    color: white;
    transform: translateY(-2px);
  }

  .profile-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    overflow: hidden;
  }

  .profile-card .card-header {
    background: #072797;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 1.2rem;
  }

  .img-vehicle-profile {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin: 20px auto;
    border: 5px solid #f8f9fa;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group label {
    color: #072797;
    font-weight: 500;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-control, .form-select {
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #072797;
    box-shadow: 0 0 0 0.2rem rgba(7, 39, 151, 0.25);
  }

  .upload-section {
    padding: 20px;
  }

  @media (max-width: 768px) {
    .profile-container {
        padding: 20px;
    }
    
    .section-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .profile-btn, .save-btn {
        width: 100%;
        justify-content: center;
    }
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
            <a href="csnotification.html" class="nav-link px-3">
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
              <a class="dropdown-item" href="index.php">Log out</a>
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
          <h5 class="text-center">Welcome back <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li>
          <a href="user-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li>
          <a href="user-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>
        <li>
        <li class="v-1">
          <a href="cars-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-car"></i></i></span>
            <span>MY CARS</span>
          </a>
        </li>
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
              <a href="csrequest_slot.php" class="nav-link px-3">
                <span class="me-2">Request Slot</span>
              </a>
            </li>
            <li class="v-1">
              <a href="process3.php" class="nav-link px-3">
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
    <div class="profile-container">
        <div class="section-header">
            <h2><i class="fas fa-car"></i> Vehicle Details</h2>
            <a href="cars-profile.php" class="profile-btn">
                <i class="fas fa-arrow-left"></i>Back to Garage
            </a>
        </div>

        <div class="row">
            <!-- Vehicle Image Card -->
            <div class="col-xl-4 mb-4">
                <div class="profile-card">
                    <div class="card-header">
                        <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>'s Vehicle
                    </div>
                    <form action="cars-upload.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="vehicle_id" value="<?php echo $vehicleData['vehicle_id']; ?>">
                        <div class="card-body text-center">
                            <img class="img-vehicle-profile mb-3" src="<?php echo $vehicleData['profile']; ?>" alt="Vehicle Image">
                            <div class="upload-section">
                                <small class="text-muted mb-3 d-block">JPG or PNG no larger than 5 MB</small>
                                <input type="file" class="form-control mb-3" id="profile" name="profile" accept="image/*">
                                <button type="submit" class="upload-btn">
                                    <i class="fas fa-upload"></i>Update Image
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="col-xl-8">
                <form action="cars-profile-info-backend.php" method="POST">
                    <input type="hidden" name="vehicle_id" value="<?php echo $vehicleData['vehicle_id']; ?>">
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label"><i class="fas fa-tag"></i>Label</label>
                                <select class="form-select" id="label" name="label" required>
                                    <option value="<?php echo $vehicleData['label']; ?>" selected><?php echo $vehicleData['label']; ?></option>
                                    <option value="Personal">Personal</option>
                                    <option value="Work">Work</option>
                                    <option value="Rent">Rent</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="platenumber"><i class="fas fa-id-card"></i>Plate Number</label>
                                <input type="text" class="form-control" id="platenumber" name="platenumber" 
                                    value="<?php echo $vehicleData['platenumber']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="chassisnumber"><i class="fas fa-fingerprint"></i>Chassis Number</label>
                                <input type="text" class="form-control" id="chassisnumber" name="chassisnumber" 
                                    value="<?php echo $vehicleData['chassisnumber']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="enginenumber"><i class="fas fa-cog"></i>Engine Number</label>
                                <input type="text" class="form-control" id="enginenumber" name="enginenumber" 
                                    value="<?php echo $vehicleData['enginenumber']; ?>">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brand"><i class="fas fa-building"></i>Brand</label>
                                <select class="form-select" id="brand" name="brand" onchange="updateModels()" required>
                                    <option value="<?php echo $vehicleData['brand']; ?>" selected><?php echo $vehicleData['brand']; ?></option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Suzuki">Suzuki</option>
                                    <!-- ... other brand options ... -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="model"><i class="fas fa-car-side"></i>Model</label>
                                <select class="form-select" id="model" name="model" required>
                                    <option value="<?php echo $vehicleData['model']; ?>" selected><?php echo $vehicleData['model']; ?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="color"><i class="fas fa-palette"></i>Color</label>
                                <select class="form-select" id="color" name="color" required>
                                    <option value="<?php echo $vehicleData['color']; ?>" selected><?php echo $vehicleData['color']; ?></option>
                                    <option value="Red">Red</option>
                                    <option value="Black">Black</option>
                                    <!-- ... other color options ... -->
                                </select>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="save-btn">
                                    <i class="fas fa-save"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </main>

  <script>
    function updateModels() {
      var brandSelect = document.getElementById("brand");
      var modelSelect = document.getElementById("model");

      // Clear existing options
      modelSelect.innerHTML = '<option value="#" selected>Choose</option>';

      // Get selected brand
      var selectedBrand = brandSelect.value;

      // Add models based on the selected brand
      switch (selectedBrand) {
        case "Toyota":
          addModels(["Vios", "Fortuner", "Innova", "Hilux"]);
          break;
        case "Suzuki":
          addModels(["Swift", "Dzire", "Ertiga", "Jimny"]);
          break;
        case "Honda":
          addModels(["Civic", "City", "CR-V", "BR-V"]);
          break;
        case "Mitsubishi":
          addModels(["Montero Sport", "Mirage", "Strada", "Xpander"]);
          break;
        case "Ford":
          addModels(["Everest", "Ranger", "EcoSport", "Explorer"]);
          break;
        case "Nissan":
          addModels(["Almera", "Terra", "Navara", "X-Trail"]);
          break;
        case "Hyundai":
          addModels(["Accent", "Kona", "Tucson", "Santa Fe"]);
          break;
        case "Isuzu":
          addModels(["mu-X", "D-MAX"]);
          break;
        case "Chevrolet":
          addModels(["Trailblazer", "Spark", "Malibu"]);
          break;
        case "Mazda":
          addModels(["Mazda2", "Mazda3", "CX-5"]);
          break;
          // Add cases for other brands
          // ...

        default:
          // Handle default case or add default models
          break;
      }
    }

    function addModels(models) {
      var modelSelect = document.getElementById("model");

      // Add models to the select element
      models.forEach(function(model) {
        var option = document.createElement("option");
        option.value = model;
        option.text = model;
        modelSelect.add(option);
      });
    }
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