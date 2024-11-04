<?php
session_start();

// Include database connection file
include('config.php');// You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch user information based on ID

$serviceID = $_SESSION['service_id'];
$id = $_GET['id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM service_names WHERE servicename_id = '$id'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$serviceData = mysqli_fetch_assoc($result);

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
<body>

<style>
  


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
  background-color: #072797;
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
  font-size: xx-large;
}
 

        
     

      
       
      
        /*main content*/
     
      

      

        .line-separator {
        border-top: 1px solid #ccc;
        margin-bottom: 20px;
        margin-top: -10px; /* Adjusted margin-top to move it more on top */
        }

        .details-form {
        display: flex;
        flex-wrap: wrap;
        }

        .form-section {
        width: 48%;
        margin-bottom: 5px;
        margin-top: -10px; /* Adjusted margin-top to move it more on top */
        }

        .form-section input {
            width: calc(100% - 20px); /* Adjusted width for better spacing */
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
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
        <li><a href="csdashboard_adminprofile.php"><i class="glyphicon glyphicon-link"></i>Profile</a></li>
        <li><a href="csservice_adminview.php"><i class="glyphicon glyphicon-plus"></i>Services</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i>Shop Profile</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-book"></i> Inventory</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i>Sales Reports</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-time"></i> Real-time</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-plus"></i> Advanced..</a></li>
        <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> LogOut</a></li>
      </ul>
      
      <hr>
      
  	</div><!-- /span-3 -->
    <div class="col-md-9">   	
      <!-- column 2 -->	
       <h2><strong><i></i> EDIT SERVICES</strong></h2>     
       <hr>
      
    <div class="row"></div>

    <form class="details-form" action="csservice_adminedit1.php" method="POST">
      <input type="hidden" id="servicename_id" name="id" value="<?php echo $serviceData['servicename_id'];?>">
      
        <div class="form-section">
          <label for="service_name">Service Name</label>
          <input type="text" id="service_name" name="service_name" value="<?php echo $serviceData['service_name'];?>" readonly>
          <label for="services">Services</label>
          <input type="text" id="services" name="services" value="">
          <label for="price">Price(₱)</label>
          <input type="text" id="price" name="price" value="">
          <br>
          
          <input type="submit" value="Save Changes" class="btn me-2 btn-primary">
        </div>
       
      </form>




    <script>
     function addServicesInput() {
      var container = document.getElementById("servicesContainer");
      
      // Remove the flex styling to allow vertical arrangement
      container.style.display = "block";
      
      // Create a div to contain each pair of inputs
      var inputGroup = document.createElement("div");
      inputGroup.className = "input-group";
      inputGroup.style.marginBottom = "10px"; // Adjust spacing between input groups
      
      // Create a new input element for the service name
      var newServiceInput = document.createElement("input");
      newServiceInput.type = "text";
      newServiceInput.name = "edit_services_name[]";
      newServiceInput.placeholder = "Enter Service Name";
      newServiceInput.className = "form-control"; // Add Bootstrap class for styling
      inputGroup.appendChild(newServiceInput);
      
      // Create a new input element for the additional input
      var newInput = document.createElement("input");
      newInput.type = "text";
      newInput.name = "edit_services_additional[]"; // Change the name as needed
      newInput.placeholder = "Enter Price";
      newInput.className = "form-control"; // Add Bootstrap class for styling
      inputGroup.appendChild(newInput);
      
      // Append the input group to the container
      container.appendChild(inputGroup);
    }
  </script>
</div>


   




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="path/to/jquery/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="path/to/bootstrap/js/bootstrap.min.js"></script>
    </body>


</html>