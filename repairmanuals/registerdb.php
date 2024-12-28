<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "diy_repair_manuals";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Default role is 'user'
    $role = 'user';

    // Check if username or email already exists
    $checkSql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Username or email already exists
        $message = "Username or email already exists. Please choose a different one.";
        header("Location: register.php?message=" . urlencode($message));
    } else {
        // Prepare SQL query to insert data
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

        // Execute the query and check for errors
        if ($conn->query($sql) === TRUE) {
            // Redirect to login page with success message
            $message = "Registered successfully! Please log in.";
            header("Location: login.php?status=success");
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            header("Location: register.php?message=" . urlencode($message));
        }
    }
}

// Close the connection
$conn->close();
?>
