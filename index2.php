<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>SPARK MOBILE</title>
    <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
    <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
  <style>
    body {
      margin-top: 20px;
      background: #eee;
      width: 100%;
      background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url(carwashbackground.jpg);
      background-position: center;
      background-size: cover;
      height: 100vh;
    }

    .container {
      margin-right: auto;
      margin-left: auto;
      padding-right: 15px;
      padding-left: 15px;
      width: 100%;
    }

    @media (min-width: 576px) {
      .container {
        max-width: 540px;
      }
    }

    @media (min-width: 768px) {
      .container {
        max-width: 720px;
      }
    }

    @media (min-width: 992px) {
      .container {
        max-width: 960px;
      }
    }

    @media (min-width: 1200px) {
      .container {
        max-width: 1140px;
      }
    }



    .card-columns .card {
      margin-bottom: 0.75rem;
    }

    @media (min-width: 576px) {
      .card-columns {
        column-count: 3;
        column-gap: 1.25rem;
      }

      .card-columns .card {
        display: inline-block;
        width: 100%;
      }
    }

    .text-muted {
      color: #FF4500 !important;
    }

    .card-group img {
      max-width: 50%;
      height: auto;
      border-radius: 1500%;

    }

    p {
      margin-top: 0;
      margin-bottom: 1rem;
    }

    .mb-3 {
      margin-bottom: 1rem !important;
    }

    .input-group {
      position: relative;
      display: flex;
      width: 100%;
    }

    .link {
      text-decoration: none;
    }

    .v-1 {
      background: #FF4500;
    }

    .btn:hover {
      background: #072797;
    }

    .mb-3 a {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <br>
  <br>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <center><img src="NEW SM LOGO.png" alt=""></center>
            <div class="form">
              <form action="cslogin.php" method="POST">
                <center><h2 class="mb-3">Login</h2></center>
                <div class="mb-3">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username"
                    placeholder="Enter Username Here">
                </div>
                <div class="mb-3">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter Password Here">
                  <br>
                  <a class="link">Forgot Password?</a>
                </div>
                <button class="btn btn-primary mb-3" type="submit">Login</button>

              </form>
            </div>

          </div>
          <div class="v-1 text-white px-4 d-md-down-none">
            <div class="card-body text-center">
              <div>

                <h1 class="mb-5">SPARK MOBILE</h1>
                <br>
                <h4 class="mb-5">"Delivering Car wash <br> right from your doorstep"</h4>
                <p>Don't have an account?</p>
                <button class="btn btn-primary mb-3">
                  <a href="cscreate.html" class="text-white" style="text-decoration: none;">Register Now!</a>
                </button>
                

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>