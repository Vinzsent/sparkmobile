<?php
session_start();

include('config.php');

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}
// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$vehicleID = $_SESSION['vehicle_id'];
$slotID = $_SESSION['slot_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM vehicles WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
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
    width: 300px;
    /* Adjust the size as needed */
    height: 150px;
    object-fit: cover;
    border-radius: 10%;
  }

  li:hover {
    background: #072797;
  }

  .v-1 {
    background-color: #072797;
    color: #fff;
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

  .add-btn {
    margin-left: 54%;
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
          <h5 class="text-center">Welcome back <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li>
          <a href="user-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li>
          <a href="user-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>

        <li class="v-1">
          <a href="cars-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-car"></i></i></span>
            <span>MY CARS</span>
          </a>
        </li>
        <li>
          <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
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
                  <span class="me-2">Set Appointment</span>
                </a>
              </li>
              <li class="v-1">
                <a href="checkingcar.php" class="nav-link px-3">
                  <span class="me-2">Checking car condition</span>
                </a>
              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Request Slot</span>
                </a>
              </li>
              <li class="v-1">
                <a href="process3.php" class="nav-link px-3">
                  <span class="me-2">Select Service</span>
                </a>
              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Register your car</span>
                </a>
              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Booking Summary</span>
                </a>
              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Booking History</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
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
    <div class="personal-details">
      <div class="container-fluid py-3">
        <div class="row">
          <div class="container mt-3">
            <div class="d-flex align-items-center">
              <h2 class="mb-0 text-dark">Add Vehicle</h2>
              <a href="cars-profile.php" class="add-btn btn btn-primary ml-auto"><i class=" me-3 fas fa-arrow-left"></i>My Garage</a>
            </div>
          </div>
          <!-- Account page navigation-->
          <hr class="mt-0 mb-4">
          <form action="cscar_create.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-xl-4 mb-4 mb-xl-4">
                <div class="card">
                  <center>
                    <div class="card-header text-white v-1"><?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname']) : ''; ?>'s Vehicle</div>
                  </center>
                  <div class="card-body text-center">
                    <img class="img-account-profile mb-2" id="preview" src="placeholder.jpg" alt="Vehicle Preview">
                    <div class="small font-italic text-dark mb-2">JPG or PNG no larger than 5 MB</div>
                    <div class="input-group">
                      <input type="file" class="form-control" id="profile" name="profile" accept="image/jpeg,image/png,image/gif" required
                        onchange="previewImage(this);">
                      <div class="invalid-feedback">Please select a valid image file.</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                <div class="form-group mb-4">
                  <label for="label" class="form-label text-black">Label:</label>
                  <select class="form-select" id="label" name="label" required>
                    <option value="">Choose</option>
                    <option value="Personal">Personal</option>
                    <option value="Work">Work</option>
                    <option value="Rent">Rent</option>
                  </select>
                  <div class="invalid-feedback">Please select a label.</div>
                </div>

                <div class="form-group mb-4">
                  <label for="platenumber">Plate Number:</label>
                  <input type="text" class="form-control" id="platenumber" name="platenumber"
                    pattern="[A-Za-z0-9\s-]+" required>
                  <div class="invalid-feedback">Please enter a valid plate number.</div>
                </div>

                <div class="form-group mb-4">
                  <label for="chassisnumber">Chassis Number:</label>
                  <input type="text" class="form-control" id="chassisnumber" name="chassisnumber"
                    pattern="[A-Za-z0-9-]+" required>
                  <div class="invalid-feedback">Please enter a valid chassis number.</div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group mb-4">
                  <label for="enginenumber">Engine Number:</label>
                  <input type="text" class="form-control" id="enginenumber" name="enginenumber"
                    pattern="[A-Za-z0-9-]+" required>
                  <div class="invalid-feedback">Please enter a valid engine number.</div>
                </div>

                <div class="form-group mb-4">
                  <label for="brand">Brand:</label>
                  <select class="form-select" id="brand" name="brand" onchange="updateModels()" required>
                    <option value="">Choose</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Suzuki">Suzuki</option>
                    <option value="Honda">Honda</option>
                    <option value="Mitsubishi">Mitsubishi</option>
                    <option value="Ford">Ford</option>
                    <option value="Nissan">Nissan</option>
                    <option value="Hyundai">Hyundai</option>
                    <option value="Isuzu">Isuzu</option>
                    <option value="Chevrolet">Chevrolet</option>
                    <option value="Mazda">Mazda</option>
                  </select>
                  <div class="invalid-feedback">Please select a brand.</div>
                </div>

                <div class="form-group mb-4">
                  <label for="model">Model:</label>
                  <select class="form-select" id="model" name="model" required>
                    <option value="">Choose</option>
                  </select>
                  <div class="invalid-feedback">Please select a model.</div>
                </div>

                <div class="form-group mb-4">
                  <label for="color">Color:</label>
                  <select class="form-select" id="color" name="color" required>
                    <option value="">Choose</option>
                    <option value="Red">Red</option>
                    <option value="Black">Black</option>
                    <option value="Blue">Blue</option>
                    <option value="Gray">Gray</option>
                    <option value="White">White</option>
                  </select>
                  <div class="invalid-feedback">Please select a color.</div>
                </div>

                <button type="submit" class="btn btn-primary btn-md">
                  <i class="me-3 fas fa-check"></i>Save changes
                </button>
              </div>
            </div>
          </form>

  </main>
  <!-- Add this JavaScript for form validation and image preview -->
  <script>
    // Form validation
    (function() {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()

    // Image preview function
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // File size validation
    document.getElementById('profile').addEventListener('change', function() {
      if (this.files[0].size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB');
        this.value = '';
        document.getElementById('preview').src = 'placeholder.jpg';
      }
    });
  </script>
  <script>
    function updateModels() {
      var brandSelect = document.getElementById("brand");
      var modelSelect = document.getElementById("model");

      // Clear existing options
      modelSelect.innerHTML = '<option value="#" selected>Choose</option>';

      // Get selected brand
      var selectedBrand = brandSelect.value;

      // Add models based on the selected brand
      switch (selectedBrand) {
        case "Toyota":
          addModels(["Vios", "Fortuner", "Innova", "Hilux"]);
          break;
        case "Suzuki":
          addModels(["Swift", "Dzire", "Ertiga", "Jimny"]);
          break;
        case "Honda":
          addModels(["Civic", "City", "CR-V", "BR-V"]);
          break;
        case "Mitsubishi":
          addModels(["Montero Sport", "Mirage", "Strada", "Xpander"]);
          break;
        case "Ford":
          addModels(["Everest", "Ranger", "EcoSport", "Explorer"]);
          break;
        case "Nissan":
          addModels(["Almera", "Terra", "Navara", "X-Trail"]);
          break;
        case "Hyundai":
          addModels(["Accent", "Kona", "Tucson", "Santa Fe"]);
          break;
        case "Isuzu":
          addModels(["mu-X", "D-MAX"]);
          break;
        case "Chevrolet":
          addModels(["Trailblazer", "Spark", "Malibu"]);
          break;
        case "Mazda":
          addModels(["Mazda2", "Mazda3", "CX-5"]);
          break;
          // Add cases for other brands
          // ...

        default:
          // Handle default case or add default models
          break;
      }
    }

    function addModels(models) {
      var modelSelect = document.getElementById("model");

      // Add models to the select element
      models.forEach(function(model) {
        var option = document.createElement("option");
        option.value = model;
        option.text = model;
        modelSelect.add(option);
      });
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
</body>

</html>