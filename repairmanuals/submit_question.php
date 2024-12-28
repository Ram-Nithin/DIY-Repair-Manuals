<?php
// Start the session
session_start();
include 'config.php'; // Make sure to include your database connection here

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the title and user name from the POST data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Insert the question into the database
    $query = "INSERT INTO questions (title, username) VALUES ('$title', '$username')";
    if (mysqli_query($conn, $query)) {
        // Redirect to the comments page after successful submission
        header("Location: comments.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
