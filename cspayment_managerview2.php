<?php
session_start();
include ('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_GET['user_id'];

// Use a JOIN query to fetch data from multiple tables
$query = $query = "SELECT 
co.*, 
pd.*, 
sd.*
FROM 
payment_details pd
LEFT JOIN 
users co ON co.user_id = pd.user_id
LEFT JOIN 
finish_jobs sd ON co.user_id = sd.user_id WHERE sd.user_id = '$user_id'";

$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    die("Error: " . mysqli_error($connection));
}

// Fetch the data
$invoiceData = mysqli_fetch_assoc($result);

$query2 ="SELECT *FROM payment_details WHERE user_id = '$user_id'";
$result2 = mysqli_query($connection, $query2);
$paymentData = mysqli_fetch_assoc($result2);

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
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
      
      <ul class="nav nav-pills nav-stacked" id="nav-links">
        <li><a href="cspayment_managerview.php"><i class="glyphicon glyphicon-plus"></i> Check Payment</a></li>
        <li><a href="cssales_report.php"><i class="glyphicon glyphicon-list"></i>Reports </a></li>
        <li><a href="#"><i class="glyphicon glyphicon-link-alt"></i> Links</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-book"></i> Books</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i> Tools</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-time"></i> Real-time</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-plus"></i> Advanced..</a></li>
        <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> LogOut</a></li>
      </ul>
      
    
      
      </div><!-- /span-3 -->
      <div class="col-md-9">    
    <hr>
    <div class="row"></div>
          
    <main>
    <?php
    // Initialize an array to store all the invoice data
    $invoiceDataArray = array();

    // Fetch data from the database and store it in the array
    mysqli_data_seek($result, 0);
    while ($invoiceData = mysqli_fetch_assoc($result)) {
        $invoiceDataArray[] = $invoiceData;
    }

    // Calculate subtotal
    $subtotal = 0;
    foreach ($invoiceDataArray as $invoiceData) {
        $subtotal += $invoiceData['price'];
    }

    // Initialize amount paid (you can get this from form submission)
    $amountPaid = $invoiceData['amount'];

    // Calculate change only if amount paid is greater than or equal to subtotal
    if ($amountPaid >= $subtotal) {
        $change = $amountPaid - $subtotal;
    } else {
        $change = 0; // Set change to zero if amount paid is less than subtotal
    }
    ?>
    <div class="container mt-3">
        <div class="row">
            <h2 class="mb-4 a-1" style="margin-left: 30%;">INVOICE</h2>
            <div class="col-md-6 text-dark mb-5">
                <h5>Invoice to:</h5>
                <p><?php echo isset($invoiceDataArray[0]['firstname']) ? $invoiceDataArray[0]['firstname'] : ''; ?> <?php echo isset($invoiceDataArray[0]['lastname']) ? $invoiceDataArray[0]['lastname'] : ''; ?></p>
                <p><?php echo isset($invoiceDataArray[0]['completeadd']) ? $invoiceDataArray[0]['completeadd'] : ''; ?></p>
                <p><?php echo isset($invoiceDataArray[0]['email']) ? $invoiceDataArray[0]['email'] : ''; ?></p>
            </div>
            <div class="col-md-6 text-dark mb-5">
                <h5>Invoice No: # <?php echo isset($invoiceDataArray[0]['total_price_id']) ? $invoiceDataArray[0]['total_price_id']: ''; ?></h5>
                <h5>Date: <?php echo isset($invoiceDataArray[0]['date']) ? $invoiceDataArray[0]['date'] : ''; ?></h5>
                <h5>Mode of Payment: <?php echo isset($invoiceDataArray[0]['payment_method']) ? $invoiceDataArray[0]['payment_method'] : ''; ?></h5>
            </div>
        </div>
    </div>

    <table class="table table-striped ms-2">
        <thead>
            <tr>
                <th>Services</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($invoiceDataArray as $invoiceData) {
            ?>
                <tr>
                    <td><?php echo $invoiceData['services']; ?></td>
                    <td>1</td> <!-- Set quantity to always be '1' -->
                    <td>₱<?php echo $invoiceData['price']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2"></td>
                <td>
                    <div class="col-md-4 text-dark">
                        <strong><p>SUBTOTAL: ₱ <?php echo $subtotal; ?>.00</p></strong>
                    </div>
                    <div class="col-md-4 text-dark">
                        <strong><p>AMOUNT PAID: ₱ <?php echo $invoiceData['amount']?>.00</p></strong>
                    </div>
                    <div class="col-md-4 text-dark">
                        <strong><p>CHANGE: ₱ <?php echo $change; ?>.00</p></strong>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <main>
    <!-- Button to trigger generating PDF and print -->
    <button id="print-button" class="btn btn-primary" type="button" onclick="generatePDFAndPrint()">Print Invoice</button>
</main>

        <!-- Include the necessary script libraries -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
    // Function to generate PDF and trigger print
    function generatePDFAndPrint() {
        generatePDF(); // Call the function to generate PDF
        window.print(); // Trigger the print dialog
    }

    // Function to generate PDF
    function generatePDF() {
        // Toggle visibility of elements
        toggleElements();

        // Trigger the print dialog
        window.print();
    }

    // Add event listener for Ctrl+P key press
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'p') {
            generatePDFAndPrint(); // Call function to generate PDF and print
            event.preventDefault(); // Prevent default Ctrl+P behavior (printing the webpage)
        }
    });

    function toggleElements() {
        // Toggle visibility of the print button
        var printButton = document.getElementById("print-button");
        printButton.style.display = "none";

        // Toggle visibility of the nav links
        var navLinks = document.getElementById("nav-links");
        navLinks.style.display = "none";
    }

    // Function to show the hidden elements when print is cancelled
    window.onafterprint = function() {
        // Show the print button
        var printButton = document.getElementById("print-button");
        printButton.style.display = "block";

        // Show the nav links
        var navLinks = document.getElementById("nav-links");
        navLinks.style.display = "block";
    };
</script>

    </body>
</html>
