<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
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

// Get the manual ID from POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manual_id'])) {
    $manual_id = intval($_POST['manual_id']);

    // Delete the manual from the database
    $sql_delete = "DELETE FROM manuals WHERE id = $manual_id";

    if ($conn->query($sql_delete) === TRUE) {
        $_SESSION['flash_message'] = "Manual deleted successfully.";
    } else {
        $_SESSION['flash_message'] = "Error deleting manual.";
    }
}

$conn->close();
header("Location: admin_dashboard.php");
exit();
?>
