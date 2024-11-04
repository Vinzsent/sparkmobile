<?php
// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'vol' parameter is set
    if (isset($_POST['vol'])) {
        // Retrieve the value of 'vol'
        $vol = $_POST['vol'];

        // Process the value (you can perform any processing here)
        $processedValue = $vol * 2;

        // Display the processed value
        echo "<p>The processed value is: $processedValue</p>";
    } else {
        // Display an error if 'vol' is not set
        echo "<p>Error: 'vol' parameter is not set.</p>";
    }
}
?>