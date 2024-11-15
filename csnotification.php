<?php
session_start();

include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
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
    li:hover{
    background: #072797;
    }
    .v-1{
    background-color: #d9d9d9;
    color: #fff;
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
    .v-2{
    color: orangered;
    }
    .icon-v1{
    width: 50%;
    }
    .click-request{
      text-decoration: none;
      color: orangered;
    }
    @media (max-width: 320px) {
    .icon-v1 {
        max-width: 50%; /* Adjust the max-width for smaller image */
        margin-right: 2%; /* Adjust the margin as needed */
        margin-top: -10%; /* Adjust the margin as needed */
        float: left; /* Ensure the image stays on the left */
    }
  }

.notification-card {
    transition: all 0.2s ease-in-out;
    border: 1px solid rgba(0,0,0,0.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.notification-card:hover {
    transform: translateX(5px);
    background-color: #f8f9fa;
}

.notification-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #fff;
    padding: 8px;
}

.notification-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.click-request {
    color: #072797;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.click-request:hover {
    color: orangered;
}

.badge {
    font-size: 0.7rem;
    padding: 0.35em 0.65em;
}

.notification-group .notification-card + .notification-card {
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .notification-icon {
        width: 40px;
        height: 40px;
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
                <a href="notifiation.html" class="nav-link px-3">
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
              <h5 class="text-center">Welcome back <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>!</h5>
              </div>
            </li>
            <li>
                <li class="">
                    <a href="csdashboard.php" class="nav-link px-3">
                      <span class="me-2"><i class="fas fa-user"></i></i></span>
                      <span class="start">PROFILE</span>
                    </a>
                  </li>
                <li>
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
                        <a href="#" class="nav-link px-3">
                        <span class="me-2"
                          >Request Slot</span>
                        </a>
                    </li>
                    <li class="v-1">
                      <a href="#" class="nav-link px-3">
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
            <li class="">
              <a href="cars.php" class="nav-link px-3">
                <span class="me-2"><i class="fas fa-car"></i></i></span>
                <span>MY CARS</span>
              </a>
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
                  <li>
                    <a href="#" class="nav-link px-3">
                      <span class="me-2"
                      >Payment options</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link px-3">
                      <span class="me-2"
                      >Car wash invoice</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link px-3">
                      <span class="me-2"
                      >Payment History</span>
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
        <div class="container mt-5 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="v-2">
                    <i class="fas fa-bell me-2"></i>Notifications
                </h2>
                <button class="btn btn-outline-secondary btn-sm" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            </div>

            <!-- Today's Notifications -->
            <h6 class="text-muted mb-3">Today</h6>
            <div class="notification-group mb-4">
                <div class="v-1 alert alert-info notification-card" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon me-3">
                            <img src="Good Quality.png" class="icon-v1" alt="Payment Icon">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="alert-heading text-dark mb-1">Payment Received</h5>
                                <span class="badge bg-primary">New</span>
                            </div>
                            <p class="text-dark mb-1">Your payment has been received!</p>
                            <a href="csinvoice.php" class="click-request d-inline-flex align-items-center">
                                <span>View invoice</span>
                                <i class="fas fa-chevron-right ms-1 small"></i>
                            </a>
                            <div class="text-muted mt-2">
                                <small><i class="far fa-clock me-1"></i>2 mins ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earlier Notifications -->
            <h6 class="text-muted mb-3">Earlier</h6>
            <div class="notification-group">
                <div class="v-1 alert alert-info notification-card" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon me-3">
                            <img src="Number1.png" class="icon-v1" alt="Achievement Icon">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading text-dark mb-1">First Booking Achievement!</h5>
                            <p class="text-dark mb-1">Congratulations on your first booking! Thank you for trusting us!</p>
                            <div class="text-muted mt-2">
                                <small><i class="far fa-clock me-1"></i>2 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="v-1 alert alert-info notification-card" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon me-3">
                            <img src="Verified Account.png" class="icon-v1" alt="Welcome Icon">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading text-dark mb-1">Welcome to Spark Mobile!</h5>
                            <p class="text-dark mb-1">Make your first booking today.</p>
                            <div class="text-muted mt-2">
                                <small><i class="far fa-clock me-1"></i>12 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <section class="modal-footer"></section>
    
    <script>
      function displayOption(option) {
          document.getElementById('selectedOption').innerText = 'Selected Option: ' + option;
      }
    </script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    <script>
    function markAllAsRead() {
        document.querySelectorAll('.badge').forEach(badge => {
            badge.style.display = 'none';
        });
    }
    </script>
  </body>
</html>
