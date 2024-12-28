<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DIY Repair Manuals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <button class="header-button" onclick="window.location.href='index.php'">Home</button>
            <button class="header-button" onclick="window.location.href='register.php'">Register</button>
        </div>
    </header>

    <?php
    // Check if the status query parameter is set to 'success'
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo '<script>showAlert("Registered successfully! Please log in.");</script>';
    }
    ?>

    <main>
        <div class="form-container">
            <h2>LOGIN</h2>
            <form action="login_process.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter the username">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter the password">

                <button type="submit" class="submit-button">Login</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
