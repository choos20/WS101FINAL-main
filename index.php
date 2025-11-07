<?php
// Database connection
$host = 'localhost';  // Your database host
$dbname = 'contact_form';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password (empty by default in localhost)

try {
    // Create a PDO instance (connect to MySQL database)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $first_name = $_POST['name'];
    $last_name = $_POST['lastname'];
    $phone_number = $_POST['number'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $help_message = $_POST['help'];

    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO submissions (first_name, last_name, phone_number, email, location, help_message)
            VALUES (:first_name, :last_name, :phone_number, :email, :location, :help_message)";

    // Prepare and execute the statement
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':phone_number' => $phone_number,
            ':email' => $email,
            ':location' => $location,
            ':help_message' => $help_message
        ]);

        // Send success message
        echo "<div id='thankYouMessage' style='text-align: center; margin-top: 20px;'>
                <h3>Thank you for contacting us! Your information has been saved.</h3>
              </div>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="new3.css" />
  <title>Contact</title>
</head>
<body>

  <div class="contact-section">
    <h2>Contact Me</h2>

    <div class="contact-icons">
      <a href="https://www.facebook.com/profile.php?id=61550716483506" target="_blank" class="contact-link" aria-label="Facebook">
        <i class="fab fa-facebook-f"></i> Facebook
      </a>
      <a href="https://tiktok.com/ritchie161831" target="_blank" class="contact-link" aria-label="TikTok">
        <i class="fab fa-tiktok"></i> TikTok
      </a>
      <a href="mailto:napinasritchiebob@email.com" class="contact-link" aria-label="Email">
        <i class="fas fa-envelope"></i> Email
      </a>
      <a href="tel:+639947160655" class="contact-link" aria-label="Phone">
        <i class="fas fa-phone"></i> Phone
      </a>
      <a href="https://github.com/choos20" target="_blank" class="contact-link" aria-label="GitHub">
        <i class="fab fa-github"></i> GitHub
      </a>
    </div>

    <div class="contact-message">
      <h3>Are you interested?</h3>
      <form class="contact-form" id="contactForm" action="index.php" method="POST">
        <label for="help">How can I help you?</label>
        <textarea id="help" name="help" rows="4" required></textarea>
      
        <label for="name">First Name</label>
        <input type="text" id="name" name="name" required>
      
        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" required>
      
        <label for="number">Number</label>
        <input type="tel" id="number" name="number" required pattern="^\+?[0-9]+$" title="Only numbers and + sign allowed.">
      
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      
        <label for="location">Location</label>
        <input type="text" id="location" name="location" required>
      
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("contactForm").addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent form from submitting immediately

      const name = document.getElementById("name").value.trim();
      const lastname = document.getElementById("lastname").value.trim();
      const number = document.getElementById("number").value.trim();

      const namePattern = /^[\p{L}\s'-]+$/u;
      const numberPattern = /^\+?[0-9]+$/;

      // Validation checks
      if (!namePattern.test(name)) {
        alert("First name can only contain letters, spaces, hyphens, or apostrophes.");
      } else if (!namePattern.test(lastname)) {
        alert("Last name can only contain letters, spaces, hyphens, or apostrophes.");
      } else if (!numberPattern.test(number)) {
        alert("Phone number can only contain digits and an optional '+' at the beginning.");
      } else {
        // Form submission is handled by PHP, so we just reset the form here after validation
        document.getElementById("contactForm").submit(); // Submit the form
      }
    });
  </script>

</body>
</html>
