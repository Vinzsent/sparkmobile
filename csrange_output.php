<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $battery = isset($_POST["battery"]) ? $_POST["battery"] : null;
    $lights = isset($_POST["lights"]) ? $_POST["lights"] : null;
    $oil = isset($_POST["oil"]) ? $_POST["oil"] : null;
    $water = isset($_POST["water"]) ? $_POST["water"] : null;
    $brake = isset($_POST["brake"]) ? $_POST["brake"] : null;
    $air = isset($_POST["air"]) ? $_POST["air"] : null;
    $gas = isset($_POST["gas"]) ? $_POST["gas"] : null;
    $engine = isset($_POST["engine"]) ? $_POST["engine"] : null;
    $tire = isset($_POST["tire"]) ? $_POST["tire"] : null;
    $self = isset($_POST["self"]) ? $_POST["self"] : null;
    


    $query = "SELECT * FROM checkingcar";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password === $row['password']) {
            // Set user details in the session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['vehicle_id'] = $row['vehicle_id'];
            $_SESSION['username'] = $row['username'];

            // Redirect to the main page or any other authenticated page
            header("Location: csnotification.php");
            exit;
        } else {
            echo "<script>alert('Please try again');</script>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'csnotfication.php';
                    }, 100); // Redirect after 1 second
                  </script>";
            exit;
        }
    } else {
        echo "<script>alert('Checking Car succesfully! Please wait for the notification.');</script>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'checkingcar.php';
                }, 1000); // Redirect after 1 second
              </script>";
        exit;
    }
}

mysqli_close($connection);
?>
