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
$vehicle_id = $_SESSION['vehicle_id'];
$application_id = $_GET['application_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$application_query = "SELECT application.user_id,
users.user_id,
users.role,
application.application_id, 
application.firstname,
application.lastname,
application.contact,
application.email,
application.position,
application.interviewdate,
application.coverletter,
application.resume,
application.otherdocuments,
users.profile FROM application INNER JOIN users ON application.user_id = users.user_id WHERE application.application_id = '$application_id'";

$application_result = mysqli_query($connection, $application_query);
$applicationData = mysqli_fetch_assoc($application_result);





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

    .img-account-file {
        width: 200px;
        /* Adjust the size as needed */
        height: 200px;
        object-fit: cover;
        border-radius: 2px;
    }

    .img-fluid {
        width: 700px;
        height: 700px;
        object-fit: cover;
        border-radius: 3px;
    }

    .img-account-permit {
        width: 200px;
        /* Adjust the size as needed */
        height: 200px;
        object-fit: cover;
    }

    .profile-btn {

        margin-left: 50%;
    }

    .owner-btn {
        margin-left: 51%
    }

    .accept-btn {
        margin-left: 50%;
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
                    <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?>!</h5>
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
                <li class="">
                    <a href="user-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li class="">
                    <a href="cars-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-money-bill"></i></i></span>
                        <span>MY SHOPS</span>
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

                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
                        <span class="me-2"><i class="fas fa-money-bill"></i>
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

        <div class="personal-details">
            <div class="container-fluid py-3">
                <div class="row">
                    <div class="container mt-3">
                        <div class="d-flex">
                            <h2 class="mb-0 text-dark">Applicant Details</h2>
                            <a href="owner-application.php" class="owner-btn btn btn-primary">
                                <i class="me-3 fas fa-arrow-left"></i>Back
                            </a>

                        </div>
                    </div>
                    <!-- Account page navigation-->
                    <hr class="mt-0 mb-4">
                    <div class="row">
                        <!-- Profile picture card -->
                        <div class="col-xl-4 mb-4 mb-xl-4">
                            <div class="card">
                                <center>
                                    <div class="v-1 card-header text-light"><?php echo $applicationData['firstname']; ?>'s profile</div>
                                </center>
                                <div class="card-body text-center">
                                    <img class="img-account-profile mb-3" src="<?php echo $applicationData['profile']; ?>" alt="">

                                    <label for="profile"></label>

                                </div>
                            </div>
                        </div>

                        <!-- First Name, Phone Number, Username and Gender -->
                        <div class=" col-md-4 mb-4">
                            <form action="owner-application-profile-backend.php" method="POST">
                                <div class="form-group mb-3 text-dark">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $applicationData['user_id']; ?>">
                                    <input type="hidden" name="application_id" id="application_id" value="<?php echo $applicationData['application_id'];?>">
                                    <input type="hidden" name="position" id="position" value="<?php echo $applicationData['role']; ?>">
                                    <label for="shop_name">First Name:</label>
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Edit Shop Name" value=" <?php echo isset($applicationData['firstname']) ? htmlspecialchars($applicationData['firstname']) : ''; ?>" readonly>
                                </div>

                                <div class="form-group mb-3 text-dark">
                                    <label for="shop_contact">Contact Number:</label>
                                    <input type="text" class="form-control" id="shop_contact" name="shop_contact" placeholder="Edit Shop Contact Number" value="<?php echo isset($applicationData['contact']) ? htmlspecialchars($applicationData['contact']) : ''; ?>" readonly>
                                </div>
                                <div class="form-group mb-3 text-dark">
                                    <label for="description">Interview Date:</label>
                                    <input class="form-control" id="description" name="description" placeholder="Edit Shop Description" value="<?php echo isset($applicationData['interviewdate']) ? htmlspecialchars($applicationData['interviewdate']) : ''; ?>" readonly></input>
                                </div>

                        </div>
                        <!-- Last Name, Email, Password, User Type and User Type -->
                        <div class="col-md-4 mb-4">
                            <div class="form-group mb-3 text-dark">
                                <label for="shop_email">Last Name:</label>
                                <input type="text" class="form-control" id="shop_email" name="shop_email" placeholder="Edit Shop Email" value="<?php echo isset($applicationData['lastname']) ? htmlspecialchars($applicationData['lastname']) : ''; ?>" readonly>
                            </div>

                            <div class="form-group mb-3 text-dark">
                                <label for="website">Desired Position:</label>
                                <input type="email" class="form-control" id="website" name="website" placeholder="Edit Shop Website Link" value="<?php echo isset($applicationData['position']) ? htmlspecialchars($applicationData['position']) : ''; ?>" readonly>
                            </div>

                        </div>
                        <!-- Address, Address Line 2, Barangay, City,  and Province  -->
                        <div class="container mt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 text-dark">Other Information</h2>
                                <button type="submit" class="accept-btn btn btn-primary">
                                    Accept Application
                                </button>

                            </div>
                        </div>
                        </form>

                        <div class="form-group mt-5 text-dark">
                            <input type="hidden" name="application_id" id="application_id" value="<?php echo $applicationData['application_id']; ?>">
                            <label for="street_address">Cover Letter:</label>
                            <img class="img-account-file mb-3" src="<?php echo $applicationData['coverletter']; ?>" alt="">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileModal" onclick="viewFile('<?php echo $applicationData['coverletter']; ?>')">View Cover Letter</button>
                        </div>

                        <div class="form-group mt-5 text-dark">
                            <label for="optional_address">Resume:</label>
                            <img class="img-account-file mb-3" src="<?php echo $applicationData['resume']; ?>" alt="">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileModal" onclick="viewFile('<?php echo $applicationData['resume']; ?>')">View Resume</button>
                        </div>
                        <div class="form-group mt-5 text-dark">
                            <label for="otherdocuments">Other Documents:</label>
                            <img class="img-account-file mb-3" src="<?php echo $applicationData['otherdocuments']; ?>" alt="">

                            <!-- Download Button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileModal" onclick="viewFile('<?php echo $applicationData['otherdocuments']; ?>')">View Other Documents</button>
                        </div>

                        <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="fileModalLabel">Document</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <!-- Image will be loaded here -->
                                        <img id="filePreview" class="img-fluid" alt="File Preview">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            function viewFile(fileSrc) {
                // Set the source of the image inside the modal
                document.getElementById('filePreview').src = fileSrc;
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>