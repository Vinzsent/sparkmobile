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
$user_id = $_SESSION['user_id'];


// Fetch user information from the database based on the user's ID
$query = "SELECT application.user_id, 
                application.application_id,
                users.profile,
                users.role, 
                users.firstname, 
                users.lastname, 
                application.position, 
                application.email, 
                application.contact 
FROM application INNER JOIN users ON application.user_id = users.user_id WHERE users.role ='User'";
$result = mysqli_query($connection, $query);


if (!$result) {
  echo 'Error: ' . mysqli_error($connection);
  exit;
}

$applicationData = [];
while ($row = mysqli_fetch_assoc($result)) {
  $applicationData[] = $row;
}

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

  .profile-picture {
    width: 300px;
    /* Adjust the size as needed */
    height: 150px;
    object-fit: cover;
    border-radius: 10%;
  }

  .applicants-container {
    padding: 30px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin: 20px;
  }

  .section-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
  }

  .section-title {
    color: #072797;
    font-weight: 600;
    margin: 0;
    font-size: 1.8rem;
  }

  .applicant-cards {
    background-color: #fff;
    border-radius: 12px;
    padding: 20px;
  }

  .applicant-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    overflow: hidden;
  }

  .applicant-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }

  .card-header {
    background-color: #072797;
    color: white;
    padding: 15px 20px;
    border-bottom: none;
  }

  .card-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 500;
  }

  .card-body {
    padding: 20px;
  }

  .profile-picture-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 20px;
  }

  .profile-picture {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .applicant-info {
    margin-bottom: 20px;
  }

  .info-label {
    color: #666;
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 0.9rem;
  }

  .info-value {
    color: #333;
    margin-bottom: 15px;
  }

  .view-details-btn {
    background-color: #072797;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
  }

  .view-details-btn:hover {
    background-color: orangered;
    transform: translateY(-2px);
  }

  .no-applicants {
    text-align: center;
    color: #666;
    padding: 40px;
    font-size: 1.1rem;
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
          <h5 class="text-center">Welcome back Owner <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li class="">
          <a href="owner-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span>DASHBOARD</span>
          </a>
        </li>
        <li>
        <li class="">
          <a href="owner-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>

        <li>
          <a href="cars-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-money-bill"></i></i></span>
            <span>MY SHOPS</span>
          </a>
        </li>
        <li class="">
          <a
            class="nav-link px-3 sidebar-link"
            data-bs-toggle="collapse"
            href="#layouts">
            <span class="me-2"><i class="fas fa-calendar"></i></i></span>
            <span>INVENTORY</span>
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
                <span class="me-2">Cleaning Products</span>
              </a>
            </li>
            <li class="v-1">
              <a href="checkingcar.php" class="nav-link px-3">
                <span class="me-2">Equipments</span>
              </a>
            </li>
            <li class="v-1">
              
            </li>
            <li class="v-1">
              
            </li>
            <li class="v-1">
             
            </li>
            <li class="v-1">
              
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
            <span class="me-2"><i class="fas fa-user"></i>
              </i></i></span>
            <span>EMPLOYEES</span>
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
        <li class="v-1">
          <a href="owner-application.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-medal"></i>
              </i></span>
            <span>APPLICATION</span>
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
    <div class="applicants-container">
        <div class="section-header">
            <h2 class="section-title">Applicants</h2>
        </div>

        <div class="applicant-cards">
            <div class="row">
                <?php
                if (!empty($applicationData)) {
                    $count = count($applicationData);
                    $colClass = $count > 1 ? 'col-md-6' : 'col-md-6 offset-md-3';

                    foreach ($applicationData as $row) {
                        echo '<div class="' . $colClass . '">';
                        echo '<div class="applicant-card">';
                        
                        // Header
                        echo '<div class="card-header">';
                        echo '<h5>' . htmlspecialchars($row['position']) . '</h5>';
                        echo '</div>';
                        
                        // Body
                        echo '<div class="card-body">';
                        
                        // Profile Picture
                        echo '<div class="profile-picture-container">';
                        echo '<img src="' . htmlspecialchars($row['profile']) . '" alt="Profile Picture" class="profile-picture">';
                        echo '</div>';
                        
                        // Applicant Information
                        echo '<div class="applicant-info">';
                        echo '<div class="info-label">Name</div>';
                        echo '<div class="info-value">' . htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']) . '</div>';
                        
                        echo '<div class="info-label">Contact</div>';
                        echo '<div class="info-value">' . htmlspecialchars($row['contact']) . '</div>';
                        
                        echo '<div class="info-label">Email</div>';
                        echo '<div class="info-value">' . htmlspecialchars($row['email']) . '</div>';
                        echo '</div>';
                        
                        // View Details Button
                        echo '<a href="owner-application-profile.php?application_id=' . htmlspecialchars($row['application_id']) . '" class="btn view-details-btn">View More Details</a>';
                        
                        echo '</div>'; // End card-body
                        echo '</div>'; // End applicant-card
                        echo '</div>'; // End column
                    }
                } else {
                    echo '<div class="col-12">';
                    echo '<div class="no-applicants">';
                    echo '<p>No applicants available at this time.</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
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