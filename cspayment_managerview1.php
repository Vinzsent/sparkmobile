<?php
session_start();

// Include database connection file
include('config.php');// You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID

$user_id= $_GET['user_id'];
$serviceID = $_SESSION['service_id'];

$query = "SELECT finish_jobs.*, users.firstname, users.lastname, service_names.service_name
FROM finish_jobs
INNER JOIN users ON finish_jobs.user_id = users.user_id
INNER JOIN service_names ON finish_jobs.servicename_id = service_names.servicename_id WHERE finish_jobs.user_id = $user_id";
// Ordering by first name in ascending order
$result = mysqli_query($connection, $query);
$paymentData = mysqli_fetch_assoc($result);




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
 /*dashboard profile*/
 .profile-section {
            text-align: center;
            padding-bottom: 10px;
            color: #fff;
            padding: 5px; /* Adjusted padding for the profile section */
        }

        .profile-image {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            border: 2px solid #fff; /* Add border style and color */
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
            border-top: 1px solid #fff; /* Added border style and color */
            margin-bottom: 10px; /* Adjusted margin for better spacing */
        }

        section {
            margin-left: 220px; /* Adjusted margin to match the width of the nav */
            padding: 20px;
            margin-top: 65px; /* Adjusted margin-top to account for the height of the header */
            background-color: #cacaca;
        }

        /*main content*/
        .user-details-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #96afc7;
        padding: 40px; /* Adjusted padding for better spacing */
        border-radius: 10px;
        margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
        height: 438px;
        }

        .right-section {
        width: 65%;
        padding-top: 20px; /* Adjusted padding-top for better spacing */
        }

        .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        margin-top: -30px; /* Adjusted margin-top to move it more on top */
        }

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

        .save-changes-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 50px; /* Adjusted margin-top to move it more below */
        margin-left: 490px; /* Adjusted margin-right to move it more to the right */
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
        .price {
    color: red; /* Change 'red' to the desired color */
}
.control-label-lg {
    font-size: 16px; /* Adjust the font size as needed */
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
      <a href="csdashboard_admin.php"><strong><i class="glyphicon glyphicon-briefcase"></i> Home</strong></a>
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
      <div class="col-md-9">   	
    <!-- column 2 -->	
    <h2><strong><i></i><?php echo $paymentData['firstname'];?> <?php echo $paymentData['lastname'];?></strong></h2> 
    <p>Below is the services and the prices of the customer.</p>    
    <hr>
    <div class="row"></div>
          
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>All services</strong></div>
                <div class="panel-body">
                    <div class="row">
                    <form action="cspayment_managerconfirm.php" method="POST">
                      <input type="hidden" name="user_id" id="user_id" value="<?php echo $paymentData['user_id']; ?>">
                      <?php
                      $totalPrice = 0; // Initialize total price variable

                      if ($result) {
                          // Loop through the results to create cards
                          foreach ($result as $row) {
                              echo '<div class="col-md-4">';
                              echo '<div class="panel panel-default">';
                              echo '<div class="panel-heading">' . (isset($row['service_name']) ? $row['service_name'] : 'N/A') . '</div>';
                              echo '<div class="panel-body">';
                              echo '<p><strong>Name:</strong> ' . (isset($row['firstname']) ? $row['firstname'] : 'N/A') . " " . (isset($row['lastname']) ? $row['lastname'] : 'N/A') . '</p>';
                              echo '<p><strong>Services:</strong> ';
                              // Explode the services and display each one individually
                              $services = isset($row['services']) ? explode(',', $row['services']) : array();
                              foreach ($services as $service) {
                                  echo $service . '<br>';
                              }
                              $price = isset($row['price']) ? $row['price'] : 0; // Get the price or default to 0 if not set
                              $totalPrice += $price; // Add price to total price
                              echo '<p><strong>Price (&#x20B1;):</strong> ' . $price . '</p>'; // Display individual price
                              echo '</div>';
                              echo '<div class="panel-footer">';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                          }
                      } else {
                          echo '<div class="col-md-12">';
                          echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($connection) . '</div>';
                          echo '</div>';
                      }
                      ?>
                      
                   

                      <!-- Modal -->
                      <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel"
                          aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                              aria-hidden="true">&times;</span></button>
                                      <h4 class="modal-title" id="changeModalLabel">Calculating Payment</h4>
                                  </div>
                                  <div class="date-payment">
                                      <label for="date" class="control-label-lg">Date of Payment:</label>
                                      <input type="text" class="form-control input-lg" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly> 
                                  </div>
                                  <div class="payment-method">
                                    <label for="payment_method" class="control-label-lg">Payment Method:</label>
                                    <select class="form-control input-lg" name="payment_method" id="payment_method" required>
                                        <option value="None">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="G Cash">G Cash</option>
                                        <option value="Maya">Maya</option>
                                        <option value="Paypal">Paypal</option>
                                    </select>
                                  </div>

                                  <div class="amount-paid">
                                      <h4>Total Price: &#x20B1;<span id="modalTotalPrice" class="price" name="change_amount" value="<?php echo $totalPrice;?>"><?php echo $totalPrice; ?>.00</span></h4>
                                      <label for="modalAmount"  class="control-label-lg">Amount Paid (&#x20B1;): </label>
                                      <input type="text" class="form-control input-lg" name="modalAmount" id="modalAmount" value=".00">
                                      <h1 id="changeResult" name="change_payment" style="color:red; font-weight: bold;"></h1>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-success" id="confirmChangeBtn">Accept</button>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </form>
                    
                </div>
              </div>
            </div><div style="margin-left: 10px; margin-bottom: 10px;"><h4>Total Price: &#x20B1;<?php echo $totalPrice; ?>.00</h4>
                                  
            </div>
            <button type="button" class="btn btn-primary" id="calculateChangeBtn" style="margin-left: 10px;">
                 Confirm
            </button>
          </div>
        </div>

        <script>
           // Attach event listener to Calculate Change button
           document.getElementById('calculateChangeBtn').addEventListener('click', function() {
              $('#changeModal').modal('show'); // Show the modal when Calculate Change button is clicked
          });

          // Attach event listener to Confirm button in modal
          document.getElementById('confirmChangeBtn').addEventListener('click', function() {
             var totalPrice = <?php echo $totalPrice; ?>;
            var amountPaid = parseFloat(document.getElementById('modalAmount').value);
                        
             if (isNaN(amountPaid)) {
              alert('Please enter a valid amount.');
               return;
            }
                        
            var change = amountPaid - totalPrice;
            var changeResult = document.getElementById('changeResult');
             if (change >= 0) {
              changeResult.innerHTML = 'Change: &#x20B1;' + change.toFixed(2);
            } else {
              changeResult.innerHTML = 'Insufficient amount paid.';
             }
          });
        </script>
                




        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>


</html>