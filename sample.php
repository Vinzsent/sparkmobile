<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Countdown Timer</title>
<link rel="stylesheet" href="styles.css">
<style>
    body {
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.countdown-container {
  text-align: center;
}

#countdown {
  font-size: 36px;
  color: #333;
}

</style>
</head>
<body>

<div class="countdown-container">
  <div id="countdown"></div>
</div>

<script>
// Check if countdown date is stored in sessionStorage
let countdownDate = sessionStorage.getItem('countdownDate');

if (!countdownDate) {
  // If countdown date is not stored, set it to a default value (e.g., New Year's Day)
  countdownDate = new Date('January 1, 2025 00:00:00').getTime();
  // Store the countdown date in sessionStorage
  sessionStorage.setItem('countdownDate', countdownDate);
} else {
  // If countdown date is stored, parse it as a number
  countdownDate = parseInt(countdownDate);
}

// Update the countdown every second
const countdown = setInterval(function() {
  const now = new Date().getTime();
  const distance = countdownDate - now;

  // Calculate days, hours, minutes, and seconds
  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the countdown
  document.getElementById('countdown').innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

  // If the countdown is over, display a message and remove the countdown date from sessionStorage
  if (distance < 0) {
    clearInterval(countdown);
    document.getElementById('countdown').innerHTML = 'EXPIRED';
    sessionStorage.removeItem('countdownDate');
  }
}, 1000);

</script>

<script src="script.js"></script>
</body>
</html>
