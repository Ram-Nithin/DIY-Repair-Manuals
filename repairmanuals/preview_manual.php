<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not, redirect to the login page
    header("Location: login.php");
    exit();
}

// Get the manual data from the session
$manual_data = isset($_SESSION['manual_data']) ? $_SESSION['manual_data'] : null;

// Redirect to the add_manuals page if no data is found
if ($manual_data === null) {
    header("Location: add_manuals.php");
    exit();
}

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diy_repair_manuals";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into the database when the OK button is clicked
if (isset($_POST['submit'])) {
    $problem_name = $conn->real_escape_string($manual_data['problem_name']);
    $problem_description = $conn->real_escape_string($manual_data['problem_description']);
    $problem_solution = $conn->real_escape_string($manual_data['problem_solution']);
    $video_solution = $conn->real_escape_string($manual_data['video_solution']);
    $category = $conn->real_escape_string($manual_data['category']);

    $sql = "INSERT INTO manuals (problem_name, problem_description, problem_solution, video_solution, category) 
            VALUES ('$problem_name', '$problem_description', '$problem_solution', '$video_solution', '$category')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully, set the flash message and redirect
        $_SESSION['flash_message'] = "Manual added successfully!";
        unset($_SESSION['manual_data']); // Clear session data after insertion
        header("Location: index.php"); // Redirect to home page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Manual - DIY Repair Manuals</title>
    <link rel="stylesheet" href="add_manuals_style.css">
    <style>
        .preview-container {
    max-width: 800px;
    width: 100%;
    margin: 20px 0; /* Add margin to the top and bottom */
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

        .preview-container h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        .preview-group {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid var(--secondary-color);
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .preview-label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            color: var(--primary-color);
        }
        .preview-value {
            padding: 10px;
            border: 1px solid var(--secondary-color);
            border-radius: 5px;
            background-color: #fff;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .button-container .header-button {
            margin-left: 0;
        }
    </style>
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
        <div class="preview-container">
            <h2>Preview Manual</h2>
            <div class="preview-group">
                <label class="preview-label">Problem Name:</label>
                <div class="preview-value"><?php echo htmlspecialchars($manual_data['problem_name']); ?></div>
            </div>
            <div class="preview-group">
                <label class="preview-label">Problem Description:</label>
                <div class="preview-value"><?php echo nl2br(htmlspecialchars($manual_data['problem_description'])); ?></div>
            </div>
            <div class="preview-group">
                <label class="preview-label">Problem Solution:</label>
                <div class="preview-value"><?php echo nl2br(htmlspecialchars($manual_data['problem_solution'])); ?></div>
            </div>
            <div class="preview-group">
                <label class="preview-label">Video Solution Link:</label>
                <div class="preview-value"><a href="<?php echo htmlspecialchars($manual_data['video_solution']); ?>" target="_blank"><?php echo htmlspecialchars($manual_data['video_solution']); ?></a></div>
            </div>
            <div class="preview-group">
                <label class="preview-label">Category:</label>
                <div class="preview-value"><?php echo htmlspecialchars($manual_data['category']); ?></div>
            </div>
            <form method="POST" action="preview_manual.php">
                <div class="button-container">
                <button type="button" class="header-button" onclick="window.location.href='add_manuals.php'">Back</button>


                    <button type="submit" name="submit" class="header-button">OK</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
