<?php
session_start();

include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}



$userID = $_SESSION['user_id'];

$user_query = "SELECT * FROM users WHERE user_id = '$userID'";
$user_result = mysqli_query($connection, $user_query);
$userData = mysqli_fetch_assoc($user_result);   


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
    background-color: #072797;
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

.progress {
    background-color: rgba(0,0,0,0.1);
    border-radius: 5px;
    margin-top: 8px;
}

.progress-bar {
    transition: width 0.3s ease;
    border-radius: 5px;
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
            <li class="nav-item">
                <a href="notification.php" class="nav-link px-3">
                    <span class="me-2">
                        <i class="fas fa-bell"></i>
                        <span id="notification-count" class="badge bg-danger"></span>
                    </span>
                </a>
            </li>
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
                    <h5 class="text-center">Welcome back Owner <?php echo $userData['firstname']; ?> !</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li>
                <li class="v-1">
                    <a href="owner-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="owner-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li class="">
                    <a href="owner-dashboard-sales-report.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-book"></i></i></span>
                        <span class="start">SALES</span>
                    </a>
                </li>
                <li>

                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                        <span class="me-2"><i class="fas fa-building"></i></i></span>
                        <span>MY SHOPS</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="layouts">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="owner-shop-profile1.php" class="nav-link px-3">
                                    <span class="me-2">Profile</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="ower-shop-service.php" class="nav-link px-3">
                                    <span class="me-2">Services</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#inventory">
                        <span class="me-2"><i class="fas fa-calendar"></i></i></span>
                        <span>INVENTORY</span>
                        <span class="ms-auto">
                            <span class="right-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </span>
                    </a>
                    <div class="collapse" id="inventory">
                        <ul class="navbar-nav ps-3">
                            <li class="v-1">
                                <a href="owner-dashboard-cleaning-products-shops.php" class="nav-link px-3">
                                    <span class="me-2">Cleaning Products</span>
                                </a>
                            </li>
                            <li class="v-1">
                                <a href="checkingcar.php" class="nav-link px-3">
                                    <span class="me-2">Equipments</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
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
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Staff</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Manager</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <span class="me-2">Cashier</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
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
        <div class="container mt-5 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="v-2">
                    <i class="fas fa-bell me-2"></i>Notifications
                </h2>
                <button class="btn btn-outline-secondary btn-sm" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            </div>

            <?php
            // Fetch notifications from database
            $userID = $_SESSION['user_id'];
            $today = date('Y-m-d');
            
            // Get today's notifications
            $today_query = "SELECT * FROM notifications 
                           WHERE user_id = '$userID' 
                           AND DATE(created_at) = '$today' 
                           ORDER BY created_at DESC";
            $today_result = mysqli_query($connection, $today_query);

            // Get earlier notifications
            $earlier_query = "SELECT * FROM notifications 
                             WHERE user_id = '$userID' 
                             AND DATE(created_at) < '$today' 
                             ORDER BY created_at DESC";
            $earlier_result = mysqli_query($connection, $earlier_query);
            ?>

            <!-- Today's Notifications -->
            <h6 class="text-muted mb-3">Today</h6>
            <div class="notification-group mb-4">
                <?php if (mysqli_num_rows($today_result) > 0): ?>
                    <?php while ($notification = mysqli_fetch_assoc($today_result)): ?>
                        <div onclick="window.location.href='redirect.php?id=<?php echo $notification['id']; ?>&type=<?php echo $notification['type']; ?>'" 
                             class=" alert alert-info notification-card" 
                             role="alert" 
                             style="cursor: pointer;">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon me-3">
                                    <?php
                                    $icon = 'Good Quality.png';
                                    if ($notification['type'] == 'service_update') {
                                        $icon = 'Number1.png';
                                    } elseif ($notification['type'] == 'welcome') {
                                        $icon = 'Verified Account.png';
                                    }
                                    ?>
                                    <img src="<?php echo $icon; ?>" class="icon-v1" alt="Notification Icon">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="alert-heading text-dark mb-1"><?php echo htmlspecialchars($notification['title']); ?></h5>
                                        <?php if (!$notification['is_read']): ?>
                                            <span class="badge bg-primary">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-dark mb-1">
                                        <?php echo htmlspecialchars($notification['message']); ?>
                                    </p>
                                    <div class="click-request d-inline-flex align-items-center">
                                        <span class="v-2">Click to view details</span>
                                        <i class=" v-2 fas fa-chevron-right ms-1 small"></i>
                                    </div>
                                    <div class="text-muted mt-2">
                                        <small><i class="far fa-clock me-1"></i><?php echo timeAgo($notification['created_at']); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-muted">No new notifications today</div>
                <?php endif; ?>
            </div>

            <!-- Earlier Notifications -->
            <h6 class="text-muted mb-3">Earlier</h6>
            <div class="notification-group">
                <?php if (mysqli_num_rows($earlier_result) > 0): ?>
                    <?php while ($notification = mysqli_fetch_assoc($earlier_result)): ?>
                        <div class="v-1 alert alert-info notification-card" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon me-3">
                                    <?php
                                    $icon = 'Good Quality.png';
                                    if ($notification['type'] == 'service_update') {
                                        $icon = 'Number1.png';
                                    } elseif ($notification['type'] == 'welcome') {
                                        $icon = 'Verified Account.png';
                                    }
                                    ?>
                                    <img src="<?php echo $icon; ?>" class="icon-v1" alt="Notification Icon">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading text-dark mb-1"><?php echo htmlspecialchars($notification['title']); ?></h5>
                                    <p class="text-dark mb-1"><?php echo htmlspecialchars($notification['message']); ?></p>
                                    <div class="text-muted mt-2">
                                        <small><i class="far fa-clock me-1"></i><?php echo timeAgo($notification['created_at']); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-muted">No earlier notifications</div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <section class="modal-footer"></section>

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
    <?php
    // Add this function at the bottom of your file
    function timeAgo($datetime) {
        $timestamp = strtotime($datetime);
        $difference = time() - $timestamp;
        
        if ($difference < 60) {
            return "Just now";
        } elseif ($difference < 3600) {
            $minutes = floor($difference / 60);
            return $minutes . " min" . ($minutes > 1 ? "s" : "") . " ago";
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
        } else {
            $days = floor($difference / 86400);
            return $days . " day" . ($days > 1 ? "s" : "") . " ago";
        }
    }
    ?>
    <script>
    // Function to check if it's time for monthly notifications
    function checkMonthlyNotifications() {
        // Get current date
        const currentDate = new Date();
        const currentDay = currentDate.getDate();
        
        // Only check on the first day of the month
        if (currentDay === 1) {
            fetch('trigger_monthly_notifications.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Monthly notifications generated:', data.date);
                        // Refresh notification display
                        updateNotificationCount();
                    }
                })
                .catch(error => console.error('Error checking monthly notifications:', error));
        }
    }

    // Check for monthly notifications when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        checkMonthlyNotifications();
        updateNotificationCount();
    });

    // Check every hour (you can adjust this interval)
    setInterval(checkMonthlyNotifications, 3600000); // 1 hour in milliseconds
    </script>
    <script>
    // Add this to your existing JavaScript
    function updateNotificationCount() {
        fetch('get_notification_count.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countElement = document.getElementById('notification-count');
                    if (countElement) {
                        countElement.textContent = data.count;
                        
                        // Update the notification icon/badge
                        if (data.count > 0) {
                            countElement.style.display = 'inline';
                            // You can also update category-specific counts if needed
                            Object.entries(data.categories).forEach(([type, count]) => {
                                const typeElement = document.getElementById(`${type}-count`);
                                if (typeElement) {
                                    typeElement.textContent = count;
                                }
                            });
                        } else {
                            countElement.style.display = 'none';
                        }
                    }
                    
                    // Update latest notification time if needed
                    if (data.latest) {
                        const latestElement = document.getElementById('latest-notification');
                        if (latestElement) {
                            const timeAgo = getTimeAgo(new Date(data.latest));
                            latestElement.textContent = `Latest: ${timeAgo}`;
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching notification count:', error));
    }

    // Helper function to format time ago
    function getTimeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " years ago";
        
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " months ago";
        
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " days ago";
        
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " hours ago";
        
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes ago";
        
        return Math.floor(seconds) + " seconds ago";
    }

    // Update notification count every 30 seconds
    setInterval(updateNotificationCount, 30000);

    // Initial update
    document.addEventListener('DOMContentLoaded', updateNotificationCount);
    </script>
  </body>
</html>
