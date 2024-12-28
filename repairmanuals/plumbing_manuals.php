<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plumbing Manuals</title>
    
    <link rel="stylesheet" href="explore_style.css">
    <script src="script.js" defer></script> <!-- Linking to the new script.js -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="DIY Repair Manuals Logo" class="logo">
            <h1>DIY REPAIR MANUALS</h1>
        </div>
        <div class="button-container">
            <a href="index.php" class="header-button">Home</a>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="main-content">
            <h2>Plumbing Repair Manuals</h2>

            <!-- Search Bar Section -->
            <div class="search-container">
                <!-- Search form that will handle redirection -->
                <form id="search-form" action="manual_detail_plu.php" method="GET">
                    <input type="text" id="search-bar" name="query" class="search-bar" placeholder="Search Plumbing Manuals..." onkeyup="searchManuals()">
                    <button class="search-button" type="submit">Search</button>
                </form>

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
