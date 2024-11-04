<?php
// Database connection
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables to store form data
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
    $amount = isset($_POST['modalAmount']) ? $_POST['modalAmount'] : '';
    $change_amount = isset($_POST['change_amount']) ? $_POST['change_amount'] : 0.00;
    $totalPrice = isset($_POST['totalPrice']) ? $_POST['totalPrice'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $vehicle_id = isset($_POST['vehicle_id']) ? $_POST['vehicle_id'] : '';
    $servicedone_id = isset($_POST['servicedone_id']) ? $_POST['servicedone_id'] : '';

    // Convert amount and total price to float
    $amount = floatval($amount);
    $totalPrice = floatval($totalPrice);

    // Calculate change
    $change = $amount - $totalPrice;

    // Prepare and execute the SQL statements
    $insert_query = "INSERT INTO payment_details (user_id, servicedone_id, subtotal, amount, change_amount, payment_method, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $update_query = "UPDATE finish_jobs SET is_deleted = '1' WHERE user_id = ?";
    $transaction_query = "INSERT INTO payment_transaction (user_id, vehicle_id, date, firstname, lastname) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statements
    $stmt_insert = mysqli_prepare($connection, $insert_query);
    $stmt_update = mysqli_prepare($connection, $update_query);
    $stmt_transaction = mysqli_prepare($connection, $transaction_query);

    if ($stmt_insert && $stmt_update && $stmt_transaction) {
        // Bind parameters for insertion into payment_details
        mysqli_stmt_bind_param($stmt_insert, 'iidddss', $user_id, $servicedone_id, $subtotal, $amount, $change_amount, $payment_method, $date);

        // Bind parameter for update of finish_jobs
        mysqli_stmt_bind_param($stmt_update, 'i', $user_id);

        // Bind parameters for insertion into payment_transaction
        mysqli_stmt_bind_param($stmt_transaction, 'iisss', $user_id, $vehicle_id, $date, $firstname, $lastname);

        // Execute insertion into payment_details
        if (mysqli_stmt_execute($stmt_insert)) {
            // Execute update in finish_jobs
            mysqli_stmt_execute($stmt_update);

            // Execute insertion into payment_transaction
            if (mysqli_stmt_execute($stmt_transaction)) {
                // Fetch invoice data
                $query = "SELECT co.*, pd.*, sd.* 
                          FROM payment_details pd
                          LEFT JOIN users co ON co.user_id = pd.user_id
                          LEFT JOIN finish_jobs sd ON co.user_id = sd.user_id 
                          WHERE sd.user_id = '$user_id'";

                $result = mysqli_query($connection, $query);

                // Check if the query was successful
                if (!$result) {
                    die("Error: " . mysqli_error($connection));
                }

                // Fetch the data
                $invoiceData = mysqli_fetch_assoc($result);

                $query2 = "SELECT * FROM payment_details WHERE user_id = '$user_id'";
                $result2 = mysqli_query($connection, $query2);
                $paymentData = mysqli_fetch_assoc($result2);

                // Close the database connection after all queries are executed
                mysqli_close($connection);

                // Show success message and redirect
                echo '<script>alert("Payment successful!");</script>';
                echo '<script>window.location.href = "cashier-dashboard-payment-invoice.php?user_id=' . $user_id . '&servicedone_id=' . $servicedone_id . '";</script>';
            } else {
                echo "Error: Unable to execute transaction insert.<br>" . mysqli_error($connection);
            }
        } else {
            echo "Error: Unable to execute payment insert.<br>" . mysqli_error($connection);
        }

        // Close prepared statements
        mysqli_stmt_close($stmt_insert);
        mysqli_stmt_close($stmt_update);
        mysqli_stmt_close($stmt_transaction);
    } else {
        echo "Error: Unable to prepare statements.<br>" . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);
} else {
    echo "Form submission failed";
}
