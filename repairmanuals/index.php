<?php
// Start the session
session_start();

// Display the flash message if it exists
if (isset($_SESSION['flash_message'])) {
    echo '<div class="flash-message">' . $_SESSION['flash_message'] . '</div>';
    // Unset the flash message after displaying
    unset($_SESSION['flash_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home_style.css">
    <style>
        .flash-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        a{
            color:#000;
        }
        a:hover{
            color:#fff;
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
            <?php if (isset($_SESSION['username'])): ?>
                <!-- If the user is logged in, show the Add Manuals and Comments buttons, and the logout button -->
                <button class="header-button" onclick="window.location.href='comments.php'">Comments</button>
                <button class="header-button" onclick="window.location.href='add_manuals.php'">Add Manuals</button>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Show Admin Dashboard button for admin users -->
                    <button class="header-button" onclick="window.location.href='admin_dashboard.php'">Admin Dashboard</button>
                <?php endif; ?>
                <button class="header-button"><a href="logout.php" style="color: black;">Logout</a></button>
                <button class="header-button" onclick="window.location.href='about_us.php'">About Us</button>
                <button class="header-button-wel">Welcome, <?php echo $_SESSION['username']; ?></button>
            <?php else: ?>
                <!-- If the user is not logged in, show login and register buttons -->
                <button class="header-button"><a href="login.php">Login</a></button>
                <button class="header-button"><a href="register.php">Register</a></button>
                <button class="header-button" onclick="window.location.href='about_us.php'">About Us</button>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <section class="main-section">
            <div class="column">
                <h2>EXPLORE, REPAIR, ENJOY......</h2>
                <p>Get the instructions you need with quality guides and the expertise of a robust community.</p>
                <button class="explore-button" onclick="scrollToSection()">Explore Manuals</button>
            </div>
        </section>
        <section class="main-content-2" id="manuals-section">
            <div class="grid-container">
                <div class="grid-item">
                    <img src="plumb1.jpg" alt="Plumbing" class="grid-item-image">
                    <h3>Plumbing Repairs</h3>
                    <p>Find step-by-step guides for common plumbing issues and repairs.</p>
                    <button class="grid-button" onclick="window.location.href='plumbing_manuals.php'">Explore Manuals</button>
                </div>
                <div class="grid-item">
                    <img src="electrical.jpg" alt="Electrical" class="grid-item-image">
                    <h3>Electrical Repairs</h3>
                    <p>Access detailed manuals for electrical troubleshooting and repairs.</p>
                    <button class="grid-button" onclick="window.location.href='electrical_manuals.php'">Explore Manuals</button>
                </div>
                <div class="grid-item">
                    <img src="appliance.jpg" alt="Appliance" class="grid-item-image">
                    <h3>Appliance Repairs</h3>
                    <p>Get comprehensive guides for repairing household appliances.</p>
                    <button class="grid-button" onclick="window.location.href='appliance_manuals.php'">Explore Manuals</button>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
    <script>
        function scrollToSection() {
            document.getElementById('manuals-section').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
