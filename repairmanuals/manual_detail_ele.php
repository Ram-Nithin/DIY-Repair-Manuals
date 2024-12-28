<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diy_repair_manuals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';
$manuals = [];

if ($query) {
    // Search for manuals matching the query
    $sql = "SELECT * FROM electrical_manuals WHERE problem_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $manuals[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Details</title>
    <link rel="stylesheet" href="manual_style.css"> <!-- Using the style you provided -->
    <style>
        /* Custom styles for plumbing manuals */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image: url('diy2.jpg');
        }

        header {
            background-color: #B5651D;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header .logo-container {
            display: flex;
            align-items: center;
            margin-top: -10px; /* Move the logo slightly up */
        }

        header .button-container {
            display: flex;
            gap: 10px;
            margin-left: auto; /* Moves the buttons to the right */
        }

        .header-button {
            background-color: transparent;
            border: 2px solid #fff;
            color: #fff;
            padding: 8px 16px; /* Reduced padding */
            font-size: 0.9rem; /* Smaller font size */
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .header-button:hover {
            background-color: #D37E4E;
            color: white;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            header {
                flex-direction: column; /* Stack logo and buttons vertically */
                align-items: center; /* Center align items */
            }

            .header .button-container {
                margin-left: 0; /* Remove left margin for smaller screens */
                justify-content: center; /* Center the buttons */
            }
        }

        main {
            padding: 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
            color: #333;
        }

        h2 {
            color: #FFB347; /* Light orange shade */
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .manual-detail {
            background-color: #fff;
            border: 1px solid #B5651D;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            transition: all 0.3s ease-in-out;
            position: relative;
            text-align: center;
        }

        .manual-detail:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .manual-detail .details {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #333;
            margin-bottom: 20px;
        }

        .manual-detail .details p {
            margin-bottom: 15px;
        }

        .manual-detail .solution-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #D37E4E;
            margin-bottom: 10px;
        }

        .manual-detail .solution {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.8;
            margin-bottom: 15px;
            border: 2px solid #D37E4E; /* Added border for the solution content */
            padding: 20px; /* Added padding for the solution content */
            border-radius: 10px; /* Added border-radius for rounded corners */
            background-color: #fff8f0;
            text-align: left; /* Added a light background color for better visibility */
        }

        .manual-detail a {
            display: inline-block;
            padding: 15px 25px;
            background-color: #B5651D;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            text-align: center;
            width: fit-content;
        }

        .manual-detail a:hover {
            background-color: #D37E4E;
            color: white;
        }

        footer {
            background-color: #B5651D;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative; /* Changed from fixed to relative */
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 1.1rem;
        }

        /* Styling for Problem Name */
        .problem-name {
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            font-size: 2.2rem;
            font-weight: 700;
            color: #6F4F37; /* Dark brown color for contrast */
            border-bottom: 3px solid #6F4F37; /* Matching the text color for the border */
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .video-link a {
            display: inline-block;
            padding: 15px 25px;
            background-color: #6F4F37; /* Dark brown color for the button */
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            text-align: center;
            width: fit-content;
        }

        .video-link a:hover {
            background-color: #5a3e29; /* Slightly darker shade for hover effect */
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo-container">
            <img src="logo1.png" alt="DIY Repair Manuals Logo" class="logo">
            <h1>DIY Repair Manuals</h1>
        </div>
        <div class="button-container">
            <a href="index.php" class="header-button">Home</a>
            <a href="electrical_manuals.php" class="header-button">Back to Electrical Manuals</a>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="main-content">
            <h2>Manual Details</h2>

            <?php if (count($manuals) > 0): ?>
                <?php foreach ($manuals as $manual): ?>
                    <div class="manual-detail">
                        <h3 class="problem-name"><?php echo htmlspecialchars($manual['problem_name']); ?></h3>
                        <div class="details">
                            <p><strong>Description:</strong><br> <?php echo nl2br(htmlspecialchars($manual['problem_description'])); ?></p>
                        </div>
                        <div class="solution-title">Solution:</div>
                        <div class="solution">
                            <p><?php echo nl2br(htmlspecialchars($manual['problem_solution'])); ?></p>
                        </div>
                        <?php if ($manual['video_link']): ?>
                            <div class="video-link">
                                <a href="<?php echo htmlspecialchars($manual['video_link']); ?>" target="_blank">Watch Video Solution</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No manuals found for the search term: "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 DIY Repair Manuals. All rights reserved.</p>
    </footer>
</body>
</html>
