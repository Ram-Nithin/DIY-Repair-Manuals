<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - DIY Repair Manuals</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="about_us_style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-home-button" onclick="window.location.href='index.php'">Home</button> <!-- Home Button -->
            <?php if (isset($_SESSION['username'])): ?>
                <!-- If the user is logged in, show the Add Manuals and Comments buttons, and the logout button -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Show Admin Dashboard button for admin users -->
                    <button class="header-button" onclick="window.location.href='admin_dashboard.php'">Admin Dashboard</button>
                <?php endif; ?>
                <button class="header-button"><a href="logout.php" style="color: black;">Logout</a></button>
            <?php else: ?>
                <!-- If the user is not logged in, show login and register buttons -->
                <button class="header-button"><a href="login.php" style="color: black;">Login</a></button>
                <button class="header-button"><a href="register.php" style="color: black;">Register</a></button>
            <?php endif; ?>
        </div>
    </header>

    <div class="main-content">
        <!-- About Us Section with Image on the Right -->
        <section class="about-container">
            <div class="about-text">
                <h2 class="about-header">About Us</h2>
                <p class="about-description">
                    Welcome to DIY Repair Manuals, your go-to resource for practical, easy-to-follow guides on repairing plumbing, electrical, and household appliances. Our mission is to empower individuals with the knowledge they need to perform repairs and maintenance themselves, saving time and money.
                </p>
                <p class="about-description">
                    Our platform brings together experienced repair experts, DIY enthusiasts, and a supportive community to share knowledge, tips, and solutions. Whether you’re a beginner or a seasoned pro, we’re here to help you with everything from basic fixes to complex troubleshooting.
                </p>
            </div>
            <div class="about-image"></div>
        </section>

        <!-- Community Section -->
        <section class="community-section">
            <h3 class="community-header">A Joined Community</h3>
            <p class="community-description">
                The DIY Household Repair Manuals app is creating a community of empowered individuals dedicated to learning and sharing home repair skills. Here, users connect, exchange tips, and support each other, fostering collaboration and confidence in tackling household maintenance together.
            </p>
        </section>

        <!-- Mission and Vision Section -->
        <section class="mission-vision-container">
            <div class="mission-vision-column">
                <h4 class="mission-vision-header">Mission</h4>
                <p>Our mission is to make home repairs accessible to everyone by providing detailed, easy-to-understand repair manuals. We aim to foster a DIY culture where anyone can fix things with confidence and minimal cost.</p>
            </div>
            <div class="mission-vision-column">
                <h4 class="mission-vision-header">Vision</h4>
                <p>Our vision is to become the leading platform for DIY home repair solutions, expanding our database with new guides and strengthening the DIY community. We envision a world where everyone has the tools and knowledge to handle repairs themselves.</p>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>

</body>
</html>
