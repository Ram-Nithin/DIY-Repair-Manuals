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

// Fetch all manuals from the database
$sql = "SELECT * FROM manuals";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <style>
        /* Custom Styles */
        body {
            background-color: #f4f4f4; /* Light gray background */
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        header {
            background-color: #B5651D;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        .container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .container table th,
        .container table td {
            text-align: left;
            padding: 12px 15px;
        }

        .container table th {
            background-color: #f2f2f2;
        }

        .container table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header-button {
            background-color: #E4B98B;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .header-button:hover {
            background-color: #eaf211;
        }

        .view-button {
            background-color: #007BFF;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .view-button:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 10px;
            background-color: #B5651D;
            color: white;
        }

    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo" style="height: 50px; width: auto;">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button" onclick="window.location.href='index.php'">Home</button>
            <button class="header-button"><a href="logout.php" style="color: white; text-decoration: none;">Logout</a></button>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Admin Dashboard</h2>
            <h3>Manuals List</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Problem Name</th>
                        <th>Problem Description</th>
                        <th>Problem Solution</th>
                        <th>Video Solution</th>
                        <th>Category</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Display each row of data from the manuals table
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['problem_name']}</td>
                                    <td>{$row['problem_description']}</td>
                                    <td>{$row['problem_solution']}</td>
                                    <td><a href='{$row['video_solution']}' target='_blank'>View Video</a></td>
                                    <td>{$row['category']}</td>
                                    <td>{$row['date_added']}</td>
                                    <td><a href='view_manual.php?id={$row['id']}' class='view-button'>View</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No manuals found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
