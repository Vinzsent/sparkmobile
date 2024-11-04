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
//$vehicle_id = $_SESSION['vehicle_id'];
$shop_id = $_GET['shop_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$query = "SELECT *FROM shops WHERE shop_id = '$shop_id'";
$result = mysqli_query($connection, $query);
$shopData = mysqli_fetch_assoc($result);

//$shop_query = "SELECT *FROM shops WHERE shop_id = '$shop_id'";
//$shop_result = mysqli_query($connection, $shop_query);
//$shopData = mysqli_fetch_assoc($shop_result);





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

  .profile-btn {

    margin-left: 50.1%;
  }
  .shop-btn {

    margin-left: 45.1%;
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
          <h5 class="text-center">Welcome back <?php echo $userData['firstname'];?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li class="">
          <a href="owner-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li class="v-1">
          <a href="user-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>
        <li>

        <li class="">
          <a href="cars-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-money-bill"></i></i></span>
            <span>MY SALES</span>
          </a>
        </li>
        <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
            <span class="me-2"><i class="fa fa-calendar"></i></span>
            <span>INVENTORY</span>
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
  
      <div class="personal-details">
        <div class="container-fluid py-3">
          <div class="row">
            <div class="container mt-3">
              <div class="d-flex">
                <h2 class="mb-0 text-dark">Edit Shop Details</h2>
                <a href="owner-shop-profile1.php?user_id=<?php echo $userData['user_id']; ?>" class="shop-btn btn btn-primary">
                  <i class="ms-2 fas fa-arrow-left me-3"></i>Cancel 
                </a>

              </div>
            </div>
            <!-- Account page navigation-->
            <hr class="mt-0 mb-4">
            <div class="row">
              <!-- Profile picture card -->
              <div class="col-xl-4 mb-4 mb-xl-4">
                    <div class="card">
                    <form action="owner-profile-upload-backend.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shopData['shop_id'];?>">
                        <center>
                        <div class="v-1 card-header text-light"><?php echo isset($shopData['shop_name']) ? htmlspecialchars($shopData['shop_name']) : ''; ?>'s permit</div>
                        </center>
                        <div class="card-body text-center">
                        <img class="img-account-profile mb-3" src="<?php echo $shopData['profile']; ?>" alt="">
                        <label for="profile"></label>
                        <div class="input-group">
                        <input type="file" class="form-control" id="profile" name="profile" accept="image/*">

                        </div>
                        <button type="submit" class="btn btn-primary">Submit Permit</button>

                        </div>
                    </form>
                    </div>
                </div>

              <!-- First Name, Phone Number, Username and Gender -->
                <div class=" col-md-4 mb-4">
                    <form action="owner-shop-profile-edit-backend.php" method="POST">
                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shopData['shop_id'];?>">
                        <div class="form-group mb-3 text-dark">
                        <label for="shop_name">Shop/Business Name:</label>
                        <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Edit Shop Name" value="<?php echo isset($shopData['shop_name']) ? htmlspecialchars($shopData['shop_name']) : ''; ?>" required>
                        </div>

                        <div class="form-group mb-3 text-dark">
                        <label for="shop_contact">Shop Contact Number:</label>
                        <input type="text" class="form-control" id="shop_contact" name="shop_contact" placeholder="Edit Shop Contact Number" value="<?php echo isset($shopData['shop_contact']) ? htmlspecialchars($shopData['shop_contact']) : ''; ?>" required>
                        </div>

                        <div class="form-group mb-3 text-dark">
                        <label for="operating">Operating Hours:</label>
                        <input type="time" class="form-control" id="operating" name="operating" placeholder="Edit Operating Hours " value="<?php echo isset($shopData['operating']) ? htmlspecialchars($shopData['operating']) : ''; ?>" required>
                        </div>

                        </div>
                        <!-- Last Name, Email, Password, User Type and User Type -->
                        <div class="col-md-4 mb-4">
                        <div class="form-group mb-3 text-dark">
                        <label for="shop_email">Shop Email:</label>
                        <input type="email" class="form-control" id="shop_email" name="shop_email" placeholder="Edit Shop Email" value="<?php echo isset($shopData['shop_email']) ? htmlspecialchars($shopData['shop_email']) : ''; ?>" required>
                        </div>

                        <div class="form-group mb-3 text-dark">
                        <label for="website">Website link (Optional):</label>
                        <input type="text" class="form-control" id="website" name="website" placeholder="Edit Shop Website Link" value="<?php echo isset($shopData['website']) ? htmlspecialchars($shopData['website']) : ''; ?>">
                        </div>

                        <div class="form-group mb-3 text-dark">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Edit Shop Description" required><?php echo isset($shopData['description']) ? htmlspecialchars($shopData['description']) : ''; ?></textarea>
                        </div>
                    


                            </div>
                        <!-- Address, Address Line 2, Barangay, City,  and Province  -->
                        <div class="container mt-3">
                            <div class="d-flex">
                            <h2 class="mb-0 text-dark">Shop Location</h2>
                            <button type="submit" class="profile-btn btn btn-primary"><i class=" me-3 fas fa-check"></i>Save Changes</button>
                            </div>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="street_address">Street Address:</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Edit your Complete Address" value="<?php echo isset($shopData['street_address']) ? htmlspecialchars($shopData['street_address']) : ''; ?>" required>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="optional_address">Address Line 2 (optional):</label>
                            <input type="text" class="form-control" id="optional_address" name="optional_address" placeholder="(e.g., apartment, suite, unit, building, floor, block, lot)" value="<?php echo isset($shopData['optional_address']) ? htmlspecialchars($shopData['optional_address']) : ''; ?>" required>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="barangay">Barangay:</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Edit your Barangay" value="<?php echo isset($shopData['barangay']) ? htmlspecialchars($shopData['barangay']) : ''; ?>" required>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Edit your City" value="<?php echo isset($shopData['city']) ? htmlspecialchars($shopData['city']) : ''; ?>" required>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="province">Province:</label>
                            <input type="text" class="form-control" id="province" name="province" placeholder="Edit your Province" value="<?php echo isset($shopData['province']) ? htmlspecialchars($shopData['province']) : ''; ?>" required>
                        </div>
                        <div class="form-group mb-3 text-dark">
                            <label for="postal">Postal/ZIP Code:</label>
                            <input type="text" class="form-control" id="postal" name="postal" placeholder="Edit your Postal Code" value="<?php echo isset($shopData['postal']) ? htmlspecialchars($shopData['postal']) : ''; ?>" required>
                        </div>
                    </form>
            
                <div class="col-xl-4 mb-4 mb-xl-4">
                    <h2 class="text-dark mt-3">Business Permit</h2>
                    <div class="card">
                    <form action="owner-shop-permit-upload.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shopData['shop_id'];?>">
                        <center>
                        <div class="v-1 card-header text-light"><?php echo isset($shopData['shop_name']) ? htmlspecialchars($shopData['shop_name']) : ''; ?>'s permit</div>
                        </center>
                        <div class="card-body text-center">
                        <img class="img-account-profile mb-3" src="<?php echo $shopData['permit']; ?>" alt="">
                        <label for="profile"></label>
                        <div class="input-group">
                        <input type="file" class="form-control" id="permit" name="permit" accept="image/*">

                        </div>
                        <button type="submit" class="btn btn-primary">Submit Permit</button>

                        </div>
                    </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

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