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
$userID = $_SESSION['user_id'];
$slotID = $_SESSION['slot_id'];
$role = $_SESSION['role'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM carowners WHERE user_id = '$userID' AND role='$role'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$shopownerData = mysqli_fetch_assoc($result);

// Assuming you have already established a database connection

// Query to retrieve all data from the database
$query1 = "SELECT select_service.*, select_service.services, carowners.user_id, carowners.firstname, carowners.lastname, carowners.contact, select_service.status
           FROM select_service
           INNER JOIN carowners ON select_service.user_id = carowners.user_id";

$result1 = mysqli_query($connection, $query1);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <title>SPARK MOBILE</title>
    <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
    <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
</head>
<body>

<style>

    .v-1{

        background-color: #FF4500;
    }
    .v-2:hover{
        background-color: #FF4500;
    }
    .v-3{
        color: #FF4500;
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
        <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="csadmin_database.php">Users</a></li>
            <li><a href="csadmin_database-vehicles.php">Vehicles</a></li>
            <li><a href="csadmin_database-staff.php">Staffs</a></li>
            <li><a href="csadmin_database-slots.php">Slot Numbers</a></li>
            <li><a href="csadmin_database-services.php">Services</a></li>
            <li><a href="csadmin_database-selectedservice.php">Selected Services</a></li>
            <li><a href="csadmin_database-payment.php">Payment Details</a></li>
            <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
         
        </ul>
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
      <a href="csdashboard_admin.php"><strong><i class="glyphicon glyphicon-briefcase"></i> Home</strong></a>

      
    
      

      
  	</div><!-- /span-3 -->
  	
      <!-- column 2 -->	
       <h1 class="col-md-9">DATABASE</h1>

       <h3>Selected Services</h3>
	   <div class="row">
                <?php
              

            if(mysqli_num_rows($result1) > 0) {
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Firstname</th>';
                echo '<th>Lastname</th>';
                echo '<th>Contact</th>';
                echo '<th>Services</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                // Loop through each row of the result set
                while($row = mysqli_fetch_assoc($result1)) {
                    echo '<tr>';
                    echo '<td>' . $row['firstname'] . '</td>';
                    echo '<td>' . $row['lastname'] . '</td>';
                    echo '<td>' . $row['contact'] . '</td>';
                    echo '<td>' . $row['services'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-primary btn">Edit</button>'; // Edit button
                    echo '<td>';
                    echo '<form action="csselectedservice-delete.php" method="POST">';
                    echo'<input type="hidden" name="selected_id" id="selected_id" value="' . $row['selected_id'] . '">';
                    echo '<button class="btn btn-danger btn">Delete</button>'; // Edit button
                    echo '</form>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No data found.';
            }

           
            ?>
           
           
        </div><!--/row-->
        
        <!-- /upper section -->
        </div><!--/container-->




        




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="path/to/jquery/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="path/to/bootstrap/js/bootstrap.min.js"></script>
    </body>


</html>