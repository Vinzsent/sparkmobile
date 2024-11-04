<?php
session_start();

// Include database connection file
include('config.php');// You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID

$servicename_id = $_SESSION['servicename_id'];
$userID = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT servicedone.*, carowners.firstname, carowners.lastname, vehicles.model, payment_details.date, servicedone.price, payment_details.*, service_names.service_name
FROM servicedone
INNER JOIN carowners ON servicedone.user_id = carowners.user_id
INNER JOIN vehicles ON servicedone.vehicle_id = vehicles.vehicle_id
INNER JOIN payment_details ON servicedone.user_id = payment_details.user_id
INNER JOIN service_names ON servicedone.servicename_id = service_names.servicename_id";


// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$servicenameData = mysqli_fetch_assoc($result);

$query1 = "SELECT * FROM carowners WHERE user_id = '$userID' AND role='$role'";
// Execute the query and fetch the user data
$result1 = mysqli_query($connection, $query1);
$shopownerData = mysqli_fetch_assoc($result1);



// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
    integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

  <title>SPARK MOBILE</title>
  <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
  <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
</head>

<body>

  <style>
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
      background-color: #072797;
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
      font-size: xx-large;
    }

    /*dashboard profile*/
    .profile-section {
      text-align: center;
      padding-bottom: 10px;
      color: #fff;
      padding: 5px;
      /* Adjusted padding for the profile section */
    }

    .profile-image {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      border: 2px solid #fff;
      /* Add border style and color */
    }

    .profile-name {
      font-size: 18px;
      margin-top: 10px;
    }

    .profile-picture-btn {
      background-color: #1b91ff;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    nav a {
      padding: 15px;
      text-decoration: none;
      font-size: 18px;
      color: #fff;
      display: block;
    }

    nav a:hover {
      background-color: #727374;
    }

    .section-line {
      border-top: 1px solid #fff;
      /* Added border style and color */
      margin-bottom: 10px;
      /* Adjusted margin for better spacing */
    }

    section {
      margin-left: 220px;
      /* Adjusted margin to match the width of the nav */
      padding: 20px;
      margin-top: 65px;
      /* Adjusted margin-top to account for the height of the header */
      background-color: #cacaca;
    }

    /*main content*/
    .user-details-section {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      background-color: #96afc7;
      padding: 40px;
      /* Adjusted padding for better spacing */
      border-radius: 10px;
      margin-top: 10px;
      /* Adjusted margin-top to make it more adjustable */
      height: 438px;
    }

    .right-section {
      width: 65%;
      padding-top: 20px;
      /* Adjusted padding-top for better spacing */
    }

    .section-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
      margin-top: -30px;
      /* Adjusted margin-top to move it more on top */
    }

    .line-separator {
      border-top: 1px solid #ccc;
      margin-bottom: 20px;
      margin-top: -10px;
      /* Adjusted margin-top to move it more on top */
    }

    .details-form {
      display: flex;
      flex-wrap: wrap;
    }

    .form-section {
      width: 48%;
      margin-bottom: 5px;
      margin-top: -10px;
      /* Adjusted margin-top to move it more on top */
    }

    .form-section input {
      width: calc(100% - 20px);
      /* Adjusted width for better spacing */
      padding: 10px;
      margin-bottom: 20px;
      box-sizing: border-box;
    }

    .save-changes-btn {
      background-color: #1b91ff;
      color: #fff;
      padding: 13px;
      /* Increased padding for more space */
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 50px;
      /* Adjusted margin-top to move it more below */
      margin-left: 490px;
      /* Adjusted margin-right to move it more to the right */
    }

    .user-details-profile-box {
      border: 1px solid #777;
      border-radius: 1px;
      padding: 70px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .user-details-profile-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }

    .choose-file-btn {
      background-color: #1b91ff;
      color: #fff;
      padding: 5px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
    }

    .btn-margin-right {
      margin-right: 10px;
      /* Adjust as needed */
    }

    /* Custom styles for this template */
    body {
      background-color: #f8f9fa;
    }

    .page-header {
      background-color: #343a40;
      color: #fff;
      padding: 20px 0;
      margin-bottom: 30px;
      border-bottom: 1px solid #e5e5e5;
    }

    .card {
      border: 1px solid #e5e5e5;
      border-radius: 0;
      margin-bottom: 30px;
    }

    .card-header {
      background-color: #007bff;
      color: #fff;
    }

    .card-body {
      padding: 20px;
    }

    .table th,
    .table td {
      border: none;
    }

    .v-4 {
      text-align: right;
      /* Align the content to the right */
      margin-right: 20px;
      /* Add some margin for spacing */
      font-weight: bold;
      /* Make the text bold */
    }
  </style>



  <!-- Header -->
  <div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container bootstrap snippets bootdey">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-toggle"></span>
        </button>
        <a class="navbar-brand" href="#">SPARK MOBILE</a>
      </div>

    </div><!-- /container -->
  </div>
  <!-- /Header -->

  <!-- Main -->
  <div class="container bootstrap snippets bootdey">

    <!-- upper section -->
    <div class="row">
      <div class="col-md-3">
        <!-- left -->
        <a href="csdashboard_admin.php"><strong><i class="glyphicon glyphicon-dashboard"></i> Home</strong></a>
        <hr>

        <ul class="nav nav-pills nav-stacked">
          <li><a href="cspayment_managerview.php"><i class="glyphicon glyphicon-plus"></i> Check Payment</a></li>
          <li><a href="cssales_report.php"><i class="glyphicon glyphicon-list"></i>Reports </a></li>
          <li><a href="#"><i class="glyphicon glyphicon-link-alt"></i> Links</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-book"></i> Books</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i> Tools</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-time"></i> Real-time</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-plus"></i> Advanced..</a></li>
          <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> LogOut</a></li>
        </ul>

        <hr>

      </div><!-- /span-3 -->


      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <p class="ms-2">
              <strong>Manager:</strong> <?php echo $shopownerData['username'];?><br>
              <strong>Department:</strong> Sales Department<br>
              <strong>Report Date:</strong> <?php echo date('Y-m-d'); ?><br>
            </p>
            <div class="page-header">
              <h1 class="text-center">Sales Report</h1>
            </div>
          </div>
          <div class="col-md-6">
            <h3>Net Profit for the month of April</h3>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>New Revenue</th>
                  <th>Cost of Goods Sold (COGS)</th>
                  <th>Operating Expenses</th>
                  <th>Net Profit</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Assuming $result contains the data from your database query

                // Initialize total variables
                $totalRevenue = 0;
                $totalCOGS = 0;
                $totalExpenses = 34100; // Assuming this is your total operating expenses
                $taxRate = 0.32; // 2% tax rate
                $totalTaxes = 0;
                $totalNetProfit = 0;

                // Iterate through the result to calculate totals
                foreach ($result as $row) {
                    $totalRevenue += $row['price'];
                    
                }

                // Calculate taxes
                $totalTaxes = $totalRevenue * $taxRate;

                // Calculate net profit
                $totalNetProfit = $totalRevenue - $totalCOGS - $totalExpenses - $totalTaxes;

                // Output the table row
                echo '<tr>';
                echo '<td>' . (date('Y-m-d') ? date('Y-m-d') : 'No date available') . '</td>';
                echo '<td>₱' . number_format($totalRevenue, 2) . '</td>';
                echo '<td>₱' . number_format($totalCOGS, 2) . '</td>';
                echo '<td>₱' . number_format($totalExpenses, 2) . '</td>';
                echo '<td>₱' . number_format($totalNetProfit, 2) . '</td>';
                echo '</tr>';
                ?>

              </tbody>
            </table>

            <div class="total-amount-container v-4">
              Total Net Profit: <span id="total-amount" style="color:black;">₱
                <?php echo number_format($totalNetProfit, 2); ?>
              </span>
            </div>

            <a href="cssales_report1.php"><button type="button" class="btn btn-danger btn-md">View Preview
                Page</button></a>




            <!-- jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <!-- Chart.js -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
  </body>


</html>