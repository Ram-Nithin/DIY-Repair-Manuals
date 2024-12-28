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

// Process the question form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_text = $_POST['question_text'];
    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    $sql = "INSERT INTO questions (user_id, question_text) VALUES ('$user_id', '$question_text')";
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
    <title>Ask a Question - DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ask_question_style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button" onclick="window.location.href='comments.php'">Back to Comments</button>
            <button class="header-button"><a href="logout.php" style="color: white;">Logout</a></button>
        </div>
    </header>
    <main>
        <div class="ask-question-section">
            <h2>Ask a Question</h2>
            <p>Have a question about your DIY repair project? Ask away!</p>
        </div>
        <form method="POST" class="ask-question-form">
            <label for="question_text">Your Question</label>
            <textarea id="question_text" name="question_text" class="form-textarea" required placeholder="Ask your question here..."></textarea>
            <button type="submit" class="submit-button">Submit Question</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
