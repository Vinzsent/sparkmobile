<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Spark Mobile</title>
  <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
  <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/landing.css" rel="stylesheet">

  <script>
    // Function to show alert and redirect
    function showAlertAndRedirect() {
      const urlParams = new URLSearchParams(window.location.search);
      const signupSuccess = urlParams.get('signup');
      if (signupSuccess === 'success') {
        alert("Signup successful! Please log in.");
        window.location.href = 'landing.php';
      }
    }

    window.onload = showAlertAndRedirect;
  </script>

  <style>
    .modal-content {
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 20px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(30px);
      /* This adds blur to the modal background */
      background: rgba(255, 255, 255, 0.75);
      /* Add a semi-transparent background to enhance the blur effect */
    }

    .modal-header,
    .modal-footer {
      background-color: rgba(248, 249, 250, 0.8);
      /* Semi-transparent header and footer for better blur effect */
    }

    .modal-header h5 {
      color: #007bff;
      text-align: center;
      width: 100%;
    }

    .modal-body {
      background-color: rgba(255, 255, 255, 0.8);
      /* Semi-transparent body for better blur effect */
    }

    .modal-footer {
      text-align: center;
    }

    .modal-footer .btn {
      background-color: #007bff;
      color: #ffffff;
    }

    .modal-footer .btn:hover {
      background-color: #0056b3;
      color: #ffffff;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(5px);
    }

    .btn {
      border-radius: 20px;
    }

    #preloader {
      position: fixed;
      left: 0;
      top: 0;
      z-index: 9999;
      width: 100%;
      height: 100%;
      overflow: hidden;
      background: #fff url('assets/img/preloader.gif') no-repeat center center;
    }

    #scroll-top {
      position: fixed;
      right: 15px;
      bottom: 15px;
      display: none;
      z-index: 99999;
    }

    #scroll-top i {
      font-size: 24px;
      color: #ffffffff;
    }

    #footer .copyright {
      text-align: center;
    }

    #signupModal .form-control {
      height: 31px;
      /* Adjust the height as needed */
      font-size: 18px;
      /* Adjust the font size as needed */
    }

    .icon {
      color: orangered;
    }
  </style>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <!-- Logo -->
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="NEW SM LOGO.png" alt="Spark Mobile Logo">
        <h1 class="sitename">Spark Mobile</h1>
      </a>

      <!-- Navigation Menu -->
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <!-- Sign-up Button -->
      <a class="btn-getstarted" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Sign-up</a>
    </div>
  </header>

  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <img src="carwashbackground.jpg" alt="" data-aos="fade-in" class="">
      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-out">
          <div class="col-xl-7 col-lg-9 text-center">
            <h1>Spark Mobile</h1>
            <p class="text-dark">Deliverig Car Wash right from your doorstep</p>
          </div>
        </div>
        <div class="text-center" data-aos="zoom-out" data-aos-delay="100">
          <a href="#" class="btn-get-started" data-bs-toggle="modal" data-bs-target="#loginModal">Get Started</a>
        </div>

        <div class="row gy-4 mt-5">
          <!-- Icon Boxes -->
          <!-- Your existing icon boxes here -->
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about section bg-light py-5">
      <div class="container" data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <img src="carwashlanding.avif" class="img-fluid rounded shadow-lg" alt="" data-aos="zoom-in">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <h3 class="display-4">About Spark Mobile</h3>
            <p class="lead mb-4">Spark Mobile aims to revolutionize the Car Wash industry system by providing a fast and seamless Car Wash services.</p>
            <ul class="list-unstyled">
              <li class="d-flex align-items-center mb-3">
                <i class="icon bi bi-check-circle  me-3"></i>
                <span>Convenient booking and scheduling.</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class=" icon bi bi-check-circle  me-3"></i>
                <span>Affordable cleaning products.</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class=" icon bi bi-check-circle  me-3"></i>
                <span>Door to door cleaning services.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h3>Features</h3>
            <p>Discover the features that make Spark Mobile your ultimate Car Wash companion.</p>
          </div>
        </div>
        <div class="row gy-4" data-aos="zoom-out">
          <?php
          // Dynamically fetch feature data (replace with your actual data fetching)
          $features = [
            ['icon' => 'bi bi-geo-alt', 'title' => 'Real-time Tracking', 'description' => 'Track the location of your houses in real-time and know exactly when the Washers will arrive.'],
            ['icon' => 'bi bi-calendar-check', 'title' => 'Easy Booking', 'description' => 'Book your schedule in advance and avoid the hassle of finding a Car Washers during peak hours.'],
            ['icon' => 'bi bi-shield-lock', 'title' => 'Secure Payments', 'description' => 'Make payments securely through the app and enjoy a cashless Car Wash experience.'],
            ['icon' => 'bi bi-bar-chart', 'title' => 'Analytics Dashboard', 'description' => 'Monitor your Car wash history statistics and manage your account effectively.']
          ];

          foreach ($features as $feature) {
          ?>
            <div class="col-md-6 col-lg-3">
              <div class="icon-box">
                <div class="icon"><i class="<?php echo $feature['icon']; ?>"></i></div>
                <h4 class="title"><a href="#"><?php echo $feature['title']; ?></a></h4>
                <p class="description"><?php echo $feature['description']; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="footer bg-dark text-light py-5">
      <div class="container">
        <div class="row">
          <!-- Footer Logo and Contact Info -->
          <div class="col-lg-4 col-md-6 footer-logo">
            <h3 class="text-light">Spark Mobile</h3>
            <p>
              Davao Central College<br>
              Davao City, Toril, 8000<br>
              Philippines<br><br>
              <strong>Phone:</strong> 12345789<br>
              <strong>Email:</strong> sparkmobileph@gmail.com
            </p>
          </div>

          <!-- Quick Links -->
          <div class="col-lg-4 col-md-6 footer-links">
            <h4 class="text-light">Quick Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Terms of Service</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>
          </div>

          <!-- Newsletter Signup -->
          <div class="col-lg-4 col-md-12 footer-newsletter">
            <h4 class="text-light">Join Our Newsletter</h4>
            <p>Subscribe for the latest updates and exclusive offers!</p>
            <form action="subscribe.php" method="post">
              <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="Your email address" required>
                <button type="submit" class="btn btn-primary">Send</button>
              </div>
            </form>
          </div>
        </div>

        <div class="row pt-4">
          <div class="col-md-12 text-center">
            <div class="copyright">
              &copy; <span id="year"></span> <strong><span>Spark Mobile</span></strong>. All Rights Reserved
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- JavaScript for Footer -->
    <script>
      // Update year in the copyright section
      document.getElementById('year').textContent = '2001';
    </script>

  </main>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 style="color: orangered;" class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" style="color: orangered;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="cslogin.php" method="POST">
            <div class="mb-3">
              <input type="hidden" id="status" name="status" value="online">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button style="background-color: orangered;" type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <div class="mt-3 text-center">
            <p>Don't have an account? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signupModal">Sign-up</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sign-up Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="color: orangered;" id="signupModalLabel">Sign-up</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="csregister.php" method="POST">
            <input type="hidden" id="role" name="role" value="User">
            <div class="mb-3">
              <label for="firstname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" style="background-color: orangered;" class="btn btn-primary w-100">Sign-up</button>
            <div class="mt-3 text-center">
              <p>Already have an account? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></p>
            </div>
          </form>
          <?php if (isset($_GET['signup_error'])): ?>
            <div class="alert alert-danger mt-3">
              <?php echo htmlspecialchars($_GET['signup_error']); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript to Toggle Fields -->
  <script>
    function toggleDriverFields() {
      const userType = document.getElementById('signupUserType').value;
      const driverFields = document.getElementById('driverFields');

      if (userType === 'driver') {
        driverFields.style.display = 'block';
      } else {
        driverFields.style.display = 'none';
      }
    }
  </script>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>