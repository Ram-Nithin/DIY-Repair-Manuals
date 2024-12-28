<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diy_repair_manuals";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Process the answer form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $answer_text = $_POST['answer_text'];
    $question_id = $_POST['question_id'];
    $user_id = $_SESSION['user_id']; // Use the user_id stored in session

    $sql = "INSERT INTO answers (question_id, user_id, answer_text) VALUES ('$question_id', '$user_id', '$answer_text')";
    if ($conn->query($sql) === TRUE) {
        header("Location: comments.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Answer - DIY Repair Manuals</title>
</head>
<body>
</body>
</html>
