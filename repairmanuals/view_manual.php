<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // If not, redirect to the login page
    header("Location: login.php");
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

// Get the manual ID from the URL
$manual_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the manual details from the database
$sql = "SELECT * FROM manuals WHERE id = $manual_id";
$result = $conn->query($sql);

// Check if the manual exists
if ($result->num_rows == 1) {
    $manual = $result->fetch_assoc();
} else {
    // If no manual is found, redirect to the admin dashboard with an error message
    $_SESSION['flash_message'] = "Manual not found.";
    header("Location: admin_dashboard.php");
    exit();
}

// Handle Add button click
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category'])) {
    $category = $_POST['category']; // Selected category to add to
    $category_table = '';

    // Determine the table based on the category selected
    switch ($category) {
        case 'Plumbing':
            $category_table = 'plumbing_manuals';
            break;
        case 'Electrical':
            $category_table = 'electrical_manuals';
            break;
        case 'Appliance':
            $category_table = 'appliance_manuals';
            break;
        default:
            $category_table = '';
            break;
    }

    if ($category_table) {
        // Prepare the query to insert into the respective category table
        $sql_insert = "INSERT INTO $category_table (problem_name, problem_description, problem_solution, video_link)
                       VALUES ('{$manual['problem_name']}', '{$manual['problem_description']}', '{$manual['problem_solution']}', '{$manual['video_solution']}')";
        if ($conn->query($sql_insert) === TRUE) {
            $_SESSION['flash_message'] = "Manual added successfully to the $category category.";
        } else {
            $_SESSION['flash_message'] = "Error adding manual to the $category category.";
        }
    } else {
        $_SESSION['flash_message'] = "Invalid category selected.";
    }

    header("Location: view_manual.php?id=$manual_id");
    exit();
}

// Handle Save button click for editing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_manual'])) {
    $problem_name = $_POST['problem_name'];
    $problem_description = $_POST['problem_description'];
    $problem_solution = $_POST['problem_solution'];
    $video_solution = $_POST['video_solution'];

    $sql_update = "UPDATE manuals 
                   SET problem_name='$problem_name', problem_description='$problem_description', problem_solution='$problem_solution', video_solution='$video_solution' 
                   WHERE id=$manual_id";

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['flash_message'] = "Manual updated successfully.";
    } else {
        $_SESSION['flash_message'] = "Error updating manual.";
    }

    header("Location: view_manual.php?id=$manual_id");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Manual - DIY Repair Manuals</title>
    <link rel="stylesheet" href="view_manual.css">
    
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo" style="height: 50px; width: auto;">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button" onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
        </div>
    </header>

    <main>
    <div class="container">
        <h2>View Manual</h2>
        <?php
        // Display flash message if set
        if (isset($_SESSION['flash_message'])) {
            echo '<div class="flash-message">' . $_SESSION['flash_message'] . '</div>';
            unset($_SESSION['flash_message']);
        }
        ?>

        <?php if (isset($_GET['edit']) && $_GET['edit'] == 'true'): ?>
        <form method="POST" action="">
            <div class="manual-edit">
                <p>
                    <label for="problem_name">Problem Name:</label>
                    <input type="text" id="problem_name" name="problem_name" value="<?php echo $manual['problem_name']; ?>" class="dynamic-input" required>
                </p>
                <p>
                    <label for="problem_description">Problem Description:</label>
                    <textarea id="problem_description" name="problem_description" class="dynamic-textarea" required><?php echo $manual['problem_description']; ?></textarea>
                </p>
                <p>
                    <label for="problem_solution">Problem Solution:</label>
                    <textarea id="problem_solution" name="problem_solution" class="dynamic-textarea" required><?php echo $manual['problem_solution']; ?></textarea>
                </p>
                <p>
                    <label for="video_solution">Video Solution:</label>
                    <input type="url" id="video_solution" name="video_solution" value="<?php echo $manual['video_solution']; ?>" class="dynamic-input">
                </p>
            </div>
            <button type="submit" name="edit_manual" class="save-button">Save</button>
            <button type="button" class="cancel-button" onclick="window.location.href='view_manual.php?id=<?php echo $manual_id; ?>'">Cancel</button>
        </form>
        <?php else: ?>
        <div class="manual-details">
            <p><label>Problem Name:</label> <?php echo $manual['problem_name']; ?></p>
            <p><label>Problem Description:</label> <?php echo $manual['problem_description']; ?></p>
            <p><label>Problem Solution:</label> 
            <?php 
                echo nl2br(htmlspecialchars($manual['problem_solution'], ENT_QUOTES, 'UTF-8')); 
            ?>
            </p>
            <p><label>Video Solution:</label> 
                <?php 
                    if (!empty($manual['video_solution'])) {
                        echo '<a href="' . $manual['video_solution'] . '" target="_blank">View Video</a>';
                    } else {
                        echo 'No video solution available';
                    }
                ?>
            </p>
            <p><label>Date Added:</label> <?php echo $manual['date_added']; ?></p>
        </div>

        <form method="POST" action="">
            <label for="category">Select Category to Add:</label>
            <select name="category" id="category" required>
                <option value="Plumbing">Plumbing</option>
                <option value="Electrical">Electrical</option>
                <option value="Appliance">Appliance</option>
            </select>
            <button type="submit" class="add-button">Add to Category</button>
        </form>
        <button class="edit-button" onclick="window.location.href='view_manual.php?id=<?php echo $manual_id; ?>&edit=true'">Edit</button>
        <!-- Delete Button -->
        <form method="POST" action="delete_manual.php" onsubmit="return confirm('Are you sure you want to delete this manual?');">
            <input type="hidden" name="manual_id" value="<?php echo $manual_id; ?>">
            <button type="submit" class="delete-button">Delete</button>
        </form>
        <?php endif; ?>
    </div>
</main>


    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
<script>
    // Adjust textarea height dynamically
    const textareas = document.querySelectorAll('.dynamic-textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        });
    });
</script>
