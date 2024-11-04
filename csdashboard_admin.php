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
$query = "SELECT * FROM users WHERE user_id = '$userID' AND role='$role'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$shopownerData = mysqli_fetch_assoc($result);

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
            
            <li class="dropdown">
            <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                <i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
            <ul id="g-account-menu" class="dropdown-menu" role="menu">
                <li><a href="#">My Profile</a></li>
                <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
            </ul>
            </li>
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
      <hr>
      
      <ul class="nav nav-pills nav-stacked">
        <li><a href="csservice_adminview.php"><i class="glyphicon glyphicon-plus"></i> Services</a></li>
          <li><a href="cssales_report.php"><i class="glyphicon glyphicon-list"></i> Reports</a></li>
          <li><a href="csadmin_database.php"><i class="glyphicon glyphicon-link"></i> Database</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-book"></i> Books</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i> Tools</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-time"></i> Real-time</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-plus"></i> Advanced..</a></li>
          <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> LogOut</a></li>
      </ul>
      
      <hr>
      
  	</div><!-- /span-3 -->
    <div class="col-md-9">   	
      <!-- column 2 -->	
       <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> <?php echo $shopownerData['username'];?> DASHBOARD</strong></a>     
       <hr>
	   <div class="row">
            <!-- center left-->	
         	<div class="col-md-7">
			  <div class="well">Inbox Messages <span class="badge pull-right">3</span></div>
              
              <hr>
              
              <div class="panel panel-default">
                  <div class="panel-heading"><h4>Processing Status</h4></div>
                  <div class="panel-body">
                    
                    <small>Complete</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                        <span class="sr-only">72% Complete</span>
                      </div>
                    </div>
                    <small>In Progress</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                        <span class="sr-only">20% Complete</span>
                      </div>
                    </div>
                    <small>At Risk</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                        <span class="sr-only">80% Complete</span>
                      </div>
                    </div>

                  </div><!--/panel-body-->
              </div><!--/panel-->                     
              
          	</div><!--/col-->
         
            <!--center-right-->
        	<div class="col-md-5">
              
                <ul class="nav nav-justified">
         			<li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-heart"></i></a></li>
         			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-comment"></i><span class="count"> 3</span></a><ul class="dropdown-menu" role="menu"><li><a href="#">1. Is there a way..</a></li><li><a href="#">2. Hello, admin. I would..</a></li><li><a href="#"><strong>All messages</strong></a></li></ul></li>
         			<li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
         			<li><a title="Add Widget" data-toggle="modal" href="#addWidgetModal"><span class="glyphicon glyphicon-plus-sign"></span></a></li>
       			</ul>  
              
                <hr>
              
				<p>
                  This is a responsive dashboard-style layout that uses <a href="http://www.getbootstrap.com">Bootstrap 3</a>. You can use this template as a starting point to create something more unique.
                </p>    
                <hr>
              
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-info col-sm-3">
                    <i class="glyphicon glyphicon-plus"></i><br>
                    Service
                  </a>
                  <a href="#" class="btn btn-info col-sm-3">
                    <i class="glyphicon glyphicon-cloud"></i><br>
                    Cloud
                  </a>
                  <a href="#" class="btn btn-info col-sm-3">
                    <i class="glyphicon glyphicon-cog"></i><br>
                    Tools
                  </a>
                  <a href="#" class="btn btn-info col-sm-3">
                            <i class="glyphicon glyphicon-question-sign"></i><br>
                            Help
                        </a>
                    </div>    
                    </div><!--/col-span-6-->
            </div><!--/row-->
            </div><!--/col-span-9-->
        </div><!--/row-->
        <!-- /upper section -->
        </div><!--/container-->
        <!-- /Main -->




        




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="path/to/jquery/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="path/to/bootstrap/js/bootstrap.min.js"></script>
    </body>


</html>