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
$vehicleID = $_SESSION['vehicle_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM vehicles WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);
// Close the database connection

$FirstNameQuery = "SELECT *FROM users WHERE user_id = '$userID'";
$FirstNameResult = mysqli_query($connection, $FirstNameQuery);
$UserFirstName = mysqli_fetch_assoc($FirstNameResult);

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
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
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
  margin-top:20px;
  background-color:#fff;
  color:#fff;
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


.welcome{
    font-size: 15px;
    text-align: center;
    margin-top: 20px;
    margin-right: 15px;
}
.me-2{
  color: #fff;
  font-weight: normal;
  font-size: 13px;

}
.me-2:hover{
  background: orangered;
}
span{
  color: #fff;
  font-weight: bold;
  font-size: 20px;
}
img{
  width: 30px;
  border-radius: 50px;
  display: block;
  margin: auto;

}
li :hover{
  background: #072797;
}
.v-1{
  background-color: #072797;
  color: #fff;
}
.v-2{
  background-color: orangered;
}
.main {
  margin-left: 200px;
}
.form-group{
  color: black;
}
.dropdown-item:hover{
  background-color: orangered;
  color: #fff;
}
.my-4:hover{
  background-color: #fff;
}
.navbar{
  background-color: #072797;
}
.btn:hover{
  background-color: orangered;
}
.nav-links ul li:hover a {
  color: white;
}
.section{
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
.container-vinfo{
  margin-left: 20px
}
.v-3{
  font-weight: bold;
}
.profile-picture {
  width: 300px; /* Adjust the size as needed */
  height: 150px;
  object-fit: cover;
  border-radius: 10%;
}
.profile-pic{
  width: 300px; /* Adjust the size as needed */
  height: 150px;
}

.garage-container {
    padding: 40px;
    margin: 80px auto 20px auto;
    max-width: 1200px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header-content h2 {
    color: #072797;
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-content p {
    margin: 15px 0 0 0;
    font-size: 14px;
}

.garage-btn {
    background: #072797;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.garage-btn:hover {
    background: orangered;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 350px));
    gap: 24px;
    padding: 20px 0;
    justify-content: center;
}

.vehicle-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    width: 100%;
    max-width: 350px;
}

.vehicle-card:hover {
    transform: translateY(-5px);
}

.vehicle-header {
    background: #072797;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px 12px 0 0;
}

.vehicle-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.vehicle-status {
    background: orangered;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.vehicle-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
    padding: 20px;
}

.vehicle-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.vehicle-details {
    padding: 20px;
    color: #333;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    font-size: 14px;
}

.detail-item i {
    color: #072797;
    width: 20px;
    font-size: 16px;
}

.detail-item strong {
    color: #072797;
    min-width: 100px;
}

.edit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 12px;
    background: #072797;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    margin-top: 15px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.edit-btn:hover {
    background: orangered;
    color: white;
    text-decoration: none;
}

.no-vehicles {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    background: #f8f9fa;
    border-radius: 12px;
    color: #6c757d;
}

.no-vehicles i {
    font-size: 48px;
    margin-bottom: 16px;
    color: #072797;
}

@media (max-width: 768px) {
    .garage-container {
        padding: 20px;
        margin-top: 70px;
        width: 95%;
    }

    .section-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .garage-btn {
        width: 100%;
        justify-content: center;
    }

    .vehicles-grid {
        grid-template-columns: minmax(280px, 350px);
        padding: 10px;
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
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
          href="smweb.html"
          ><img src="NEW SM LOGO.png" alt=""></a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
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
    <li class="my-4"><hr class="dropdown-divider bg-primary" /></li>
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
              <h5 class="text-center">Welcome back <?php echo isset($UserFirstName['firstname']) ? $UserFirstName['firstname'] : ''; ?>!</h5>
              </div>
              <div class="ms-3"id="dateTime"></div>
            </li>
            <li class="">
              <a href="user-dashboard.php" class="nav-link px-3">
                <span class="me-2"><i class="fas fa-home"></i></i></span>
                <span>DASHBOARD</span>
              </a>
            </li>
            <li>
                <li class="">
                    <a href="user-profile.php" class="nav-link px-3">
                      <span class="me-2"><i class="fas fa-user"></i></i></span>
                      <span class="start">PROFILE</span>
                    </a>
                </li>
                
            <li class="v-1">
              <a href="cars-profile.php" class="nav-link px-3">
                <span class="me-2"><i class="fas fa-car"></i></i></span>
                <span>MY CARS</span>
              </a>
            </li>
            <li class="">
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
                        <span class="me-2"
                            >Set Appointment</span>
                        </a>
                    </li>  
                    <li class="v-1">
                        <a href="checkingcar.php" class="nav-link px-3">
                        <span class="me-2"
                            >Checking car condition</span>
                        </a>
                    </li>
                    <li class="v-1">
                        <a href="csrequest_slot.php" class="nav-link px-3">
                        <span class="me-2"
                          >Request Slot</span>
                        </a>
                    </li>
                    <li class="v-1">
                      <a href="csprocess3.php" class="nav-link px-3">
                      <span class="me-2"
                        >Select Service</span>
                      </a>
                   </li>
                    <li class="v-1">
                    <a href="#" class="nav-link px-3">
                    <span class="me-2"
                      >Register your car</span>
                    </a>
                  </li>
                    <li class="v-1">
                    <a href="#" class="nav-link px-3">
                    <span class="me-2"
                      >Booking Summary</span>
                  </a>
                  </li>
                  <li class="v-1">
                    <a href="#" class="nav-link px-3">
                    <span class="me-2"
                      >Booking History</span>
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
                        <span class="me-2"
                        >Payment options</span>
                      </a>
                    </li>
                    <li class="v-1">
                      <a href="#" class="nav-link px-3">
                        <span class="me-2"
                        >Car wash invoice</span>
                      </a>
                    </li>
                    <li class="v-1">
                      <a href="#" class="nav-link px-3">
                        <span class="me-2"
                        >Payment History</span>
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
    <div class="garage-container">
        <div class="section-header">
            <div class="header-content">
                <h2><i class="fas fa-warehouse"></i> My Garage</h2>
                <p class="text-muted">Manage your registered vehicles</p>
            </div>
            <a href="cars-register.php" class="garage-btn">
                <i class="fas fa-plus-circle"></i>Add Vehicle
            </a>
        </div>

        <div class="vehicles-grid">
            <?php
            if ($result) {
                $count = mysqli_num_rows($result);
                foreach ($result as $row) {
                    echo '<div class="vehicle-card">';
                    echo '<div class="vehicle-header">';
                    echo '<h3>' . (isset($row['label']) ? $row['label'] : 'label') . '</h3>';
                    echo '<div class="vehicle-status">Active</div>';
                    echo '</div>';
                    
                    echo '<div class="vehicle-image">';
                    echo '<img src="' . (isset($row['profile']) ? $row['profile'] : 'N/A') . '" alt="Vehicle Image"/>';
                    echo '</div>';
                    
                    echo '<div class="vehicle-details">';
                    echo '<div class="detail-item">';
                    echo '<i class="fas fa-id-card"></i>';
                    echo '<strong>Plate Number:</strong>';
                    echo '<span class="text-dark">' . (isset($row['platenumber']) ? $row['platenumber'] : 'N/A') . '</span>';
                    echo '</div>';
                    
                    echo '<div class="detail-item">';
                    echo '<i class="fas fa-building"></i>';
                    echo '<strong>Brand:</strong>';
                    echo '<span class="text-dark">' . (isset($row['brand']) ? $row['brand'] : 'N/A') . '</span>';
                    echo '</div>';
                    
                    echo '<div class="detail-item">';
                    echo '<i class="fas fa-car"></i>';
                    echo '<strong>Model:</strong>';
                    echo '<span class="text-dark">' . (isset($row['model']) ? $row['model'] : 'N/A') . '</span>';
                    echo '</div>';
                    
                    echo '<div class="detail-item">';
                    echo '<i class="fas fa-palette"></i>';
                    echo '<strong>Color:</strong>';
                    echo '<span class="text-dark">' . (isset($row['color']) ? $row['color'] : 'N/A') . '</span>';
                    echo '</div>';
                    
                    echo '<a href="cars-profile-info.php?vehicle_id=' . (isset($row['vehicle_id']) ? $row['vehicle_id'] : '') . '" class="edit-btn">';
                    echo '<i class="fas fa-edit me-2"></i>Edit Vehicle';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-vehicles">';
                echo '<i class="fas fa-car-alt"></i>';
                echo '<p>No vehicles found. Add your first vehicle to get started!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>


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
