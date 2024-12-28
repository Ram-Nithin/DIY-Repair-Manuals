<?php
// Start the session
session_start();

// Database connection (adjust the details accordingly)
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

// Fetch all questions
$sql = "SELECT * FROM questions ORDER BY created_at DESC";
$result = $conn->query($sql);

// Function to get the username from user ID
function getUserName($user_id, $conn) {
    $sql = "SELECT username FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments - DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="comment_style1.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button" onclick="window.location.href='index.php'">Home</button>
            <button class="header-button"><a href="logout.php" style="color: black;">Logout</a></button>
        </div>
    </header>
    <main>
        <h2>Comments</h2>
        <button class="ask-button" onclick="window.location.href='ask_question.php'">Ask a Question</button>

        <!-- Display all questions -->
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="question">
                <p><strong><?php echo getUserName($row['user_id'], $conn); ?>:</strong> <?php echo $row['question_text']; ?></p>

                <!-- Fetch answers for this question -->
                <?php
                    $question_id = $row['id'];
                    $answer_sql = "SELECT * FROM answers WHERE question_id = $question_id ORDER BY created_at DESC";
                    $answer_result = $conn->query($answer_sql);
                ?>

                <button class="show-answers-btn" onclick="toggleAnswers(<?php echo $question_id; ?>)">Show Answers</button>
                <div class="answers" id="answers-<?php echo $question_id; ?>" style="display:none;">
                    <?php while ($answer_row = $answer_result->fetch_assoc()): ?>
                        <p><strong><?php echo getUserName($answer_row['user_id'], $conn); ?>:</strong> <?php echo $answer_row['answer_text']; ?></p>
                    <?php endwhile; ?>

                    <!-- Form to add an answer -->
                    <form action="add_answer.php" method="POST">
                        <textarea name="answer_text" required placeholder="Write your answer..."></textarea>
                        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                        <button type="submit">Post Answer</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

    </main>
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>

    <script>
        function toggleAnswers(question_id) {
            var answersDiv = document.getElementById('answers-' + question_id);
            answersDiv.style.display = (answersDiv.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
