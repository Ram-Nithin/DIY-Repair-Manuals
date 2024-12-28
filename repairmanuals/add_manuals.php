<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not, redirect to the login page
    header("Location: login.php");
    exit();
}

// If the form is submitted, save the data to the session and redirect to preview page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['manual_data'] = $_POST;
    header("Location: preview_manual.php");
    exit();
}

// Retrieve the manual data from the session if available
$manual_data = isset($_SESSION['manual_data']) ? $_SESSION['manual_data'] : ['problem_name' => '', 'problem_description' => '', 'problem_solution' => '', 'video_solution' => '', 'category' => ''];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manuals - DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="add_manuals_style.css">
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
        <div class="form-container">
            <h2>Add Manuals</h2>
            <form method="post" action="add_manuals.php">
                <div class="form-group">
                    <label for="problem_name">Problem Name:</label>
                    <input type="text" id="problem_name" name="problem_name" value="<?php echo htmlspecialchars($manual_data['problem_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="problem_description">Problem Description:</label>
                    <textarea id="problem_description" name="problem_description" required><?php echo htmlspecialchars($manual_data['problem_description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="problem_solution">Problem Solution:</label>
                    <textarea id="problem_solution" name="problem_solution" required><?php echo htmlspecialchars($manual_data['problem_solution']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="video_solution">Video Solution Link:</label>
                    <input type="url" id="video_solution" name="video_solution" value="<?php echo htmlspecialchars($manual_data['video_solution']); ?>">
                </div>
                <div class="form-group">
                    <label for="category">Choose Category:</label>
                    <select id="category" name="category" required>
                        <option value="" disabled <?php echo $manual_data['category'] == '' ? 'selected' : ''; ?>>Select a category</option>
                        <option value="Plumbing Manuals" <?php echo $manual_data['category'] == 'Plumbing Manuals' ? 'selected' : ''; ?>>Plumbing Manuals</option>
                        <option value="Electrical Manuals" <?php echo $manual_data['category'] == 'Electrical Manuals' ? 'selected' : ''; ?>>Electrical Manuals</option>
                        <option value="Appliance Manuals" <?php echo $manual_data['category'] == 'Appliance Manuals' ? 'selected' : ''; ?>>Appliance Manuals</option>
                    </select>
                </div>
                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
