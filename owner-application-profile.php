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

    .personal-details {
        padding: 30px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin: 20px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        color: #072797;
        font-weight: 600;
        margin: 0;
        font-size: 1.8rem;
    }

    .back-btn {
        padding: 8px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        background-color: #072797;
    }

    .back-btn:hover {
        transform: translateY(-5px);
        background-color: orangered;
    }

    .back-btn i {
        margin-right: 8px;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .profile-card .card-header {
        background-color: #072797;
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 1.2rem;
    }

    .profile-card .card-body {
        padding: 25px;
    }

    .img-account-profile {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        color: #072797;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #072797;
        box-shadow: 0 0 0 0.2rem rgba(7, 39, 151, 0.25);
    }

    .form-control[readonly] {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
    }

    .document-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .document-preview {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .view-doc-btn {
        background-color: #072797;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .view-doc-btn:hover {
        background-color: orangered;
        transform: translateY(-2px);
    }

    .accept-btn {
        background-color: #072797;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        transition: all 0.3s ease;
        margin-left: auto;
        margin-right: 20px;
    }

    .accept-btn:hover {
        background-color: orangered;
        transform: translateY(-2px);
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        background-color: #072797;
        color: white;
        border-bottom: none;
    }

    .modal-body {
        padding: 25px;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
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
            <div class="section-header">
                <h2 class="section-title">Applicant Details</h2>
                <a href="owner-application.php" class="back-btn btn text-white">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="row">
                <!-- Profile Picture Section -->
                <div class="col-xl-4 mb-4">
                    <div class="profile-card">
                        <div class="card-header">
                            <?php echo htmlspecialchars($applicationData['firstname']); ?>'s Profile
                        </div>
                        <div class="card-body text-center">
                            <img class="img-account-profile" src="<?php echo htmlspecialchars($applicationData['profile']); ?>" alt="Profile Picture">
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="col-md-4 mb-4">
                    <form action="owner-application-profile-backend.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($applicationData['user_id']); ?>">
                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($applicationData['application_id']); ?>">
                        <input type="hidden" name="position" value="<?php echo htmlspecialchars($applicationData['role']); ?>">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicationData['firstname']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicationData['contact']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Interview Date</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicationData['interviewdate']); ?>" readonly>
                        </div>
                    </form>
                </div>

                <!-- Additional Information -->
                <div class="col-md-4 mb-4">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicationData['lastname']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Desired Position</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicationData['position']); ?>" readonly>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="section-header mt-4">
                <h2 class="section-title">Documents</h2>
                <form action="owner-application-profile-backend.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($applicationData['user_id']); ?>">
                    <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($applicationData['application_id']); ?>">
                    <input type="hidden" name="position" value="<?php echo htmlspecialchars($applicationData['role']); ?>">
                    <button type="submit" class="accept-btn">
                        <i class="fas fa-check"></i> Accept Application
                    </button>
                </form>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="document-section">
                        <h5 class="mb-3">Cover Letter</h5>
                        <img class="document-preview" src="<?php echo htmlspecialchars($applicationData['coverletter']); ?>" alt="Cover Letter">
                        <button type="button" class="view-doc-btn w-100" data-bs-toggle="modal" data-bs-target="#fileModal" 
                                onclick="viewFile('<?php echo htmlspecialchars($applicationData['coverletter']); ?>')">
                            View Cover Letter
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="document-section">
                        <h5 class="mb-3">Resume</h5>
                        <img class="document-preview" src="<?php echo htmlspecialchars($applicationData['resume']); ?>" alt="Resume">
                        <button type="button" class="view-doc-btn w-100" data-bs-toggle="modal" data-bs-target="#fileModal" 
                                onclick="viewFile('<?php echo htmlspecialchars($applicationData['resume']); ?>')">
                            View Resume
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="document-section">
                        <h5 class="mb-3">Additional Documents</h5>
                        <img class="document-preview" src="<?php echo htmlspecialchars($applicationData['otherdocuments']); ?>" alt="Other Documents">
                        <button type="button" class="view-doc-btn w-100" data-bs-toggle="modal" data-bs-target="#fileModal" 
                                onclick="viewFile('<?php echo htmlspecialchars($applicationData['otherdocuments']); ?>')">
                            View Other Documents
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Preview Modal -->
        <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileModalLabel">Document Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="filePreview" class="img-fluid" alt="File Preview">
                    </div>
                </div>
            </div>
        </div>
    </main>

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