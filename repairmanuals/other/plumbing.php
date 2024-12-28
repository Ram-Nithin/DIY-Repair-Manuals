<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plumbing Manuals</title>
    <link rel="stylesheet" href="manual_styles.css">
    <script src="search.js"></script> <!-- Link to external JS file -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="DIY Repair Manuals Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button">Comments</button>
            <button class="header-button">Add Manuals</button>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="main-content">
            <h2>Plumbing Repair Manuals</h2>

            <!-- Search Bar Section -->
            <div class="search-container">
                <input type="text" id="search-bar" class="search-bar" placeholder="Search Plumbing Manuals..." onkeyup="searchManuals()">
                <button class="search-button" onclick="searchManuals()">Search</button>

                <!-- Search Dropdown -->
                <ul id="search-dropdown" class="search-dropdown"></ul>
            </div>

            <div id="manuals-list">
                <!-- Manuals will be dynamically loaded here -->
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
