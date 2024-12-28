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
    $sql = "SELECT * FROM appliance_manuals WHERE problem_name LIKE ?";
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
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="manual_style.css">
    <style>
        /* Custom styles for appliance manuals */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image: url('diy3.jpg');
        }
        header {
    background-color: #E4B98B; /* Light rust color */
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* Remove position sticky */
    /* position: sticky; */
    /* top: 0; */
    z-index: 1000;
}


        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            height: 50px;
            margin-right: 20px;
        }
        header h1 {
            font-size: 1.8rem;
            margin: 0;
            font-weight: bold;
        }
        .button-container {
    display: flex;
    gap: 10px;
    justify-content: flex-end; /* Align buttons to the right */
}

        .header-button {
            background-color: transparent;
            border: 2px solid #fff;
            color: #fff;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .header-button:hover {
            background-color: #D37E4E;
            color: white;
        }
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
        }

        h2 {
            color: #B5651D;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase; /* Make Manual Details uppercase */
        }

        .manual-detail {
            background-color: #fff;
            border: 1px solid #B5651D;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 30px;
            transition: all 0.3s ease-in-out;
            display: flex; /* Flexbox layout for content alignment */
            flex-direction: column; /* Stack elements vertically */
            gap: 20px;
        }

        .manual-detail:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Styling for Problem Name (dark brown) and center alignment */
        .manual-detail .problem-name {
            font-size: 1.6rem;
            font-weight: bold;
            color: #3E2723; /* Dark Brown color for problem name */
            margin-bottom: 10px;
            text-align: center; /* Center the problem name */
            text-transform: uppercase; /* Make problem name uppercase */
        }

        .manual-detail .details {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #333;
            margin-bottom: 20px;
            text-align: center; /* Center the description content */
        }

        .manual-detail .details p {
            margin-bottom: 10px;
        }

        /* Box around solution */
        .solution-box {
            background-color: #f7f7f7;
            border: 1px solid #B5651D;
            border-radius: 8px;
            padding: 15px;
            width: 100%;
            margin-bottom: 20px;
            text-align: left; /* Left-align the solution text */
        }

        /* Add large line under the problem name */
        .problem-line {
            width: 100%;
            height: 2px;
            background-color: #B5651D; /* Dark brown color for the line */
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* Button styles */
        .manual-detail a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #6A4E23; /* Dark Brown color for the button */
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 15px;
            text-align: center;
            width: fit-content;
            align-self: center; /* Center the button */
        }

        .manual-detail a:hover {
            background-color: #4E3629; /* Darker shade of brown for hover effect */
            color: white;
        }

        /* Center "Watch Video Solution" button */
        .video-link {
            text-align: center; /* Center align the video link */
            margin-top: 20px;
        }

        footer {
    background-color: #E4B98B;
    color: #FFFFFF;
    text-align: center;
    padding: 10px;
    /* Remove position fixed */
    /* position: fixed; */
    /* width: 100%; */
    /* bottom: 0; */
    box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);

        }

        footer p {
            margin: 0;
            font-size: 1.1rem;
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
            <a href="appliance_manuals.php" class="header-button">Back to Appliance Manuals</a>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="main-content">
            <h2>Manual Details</h2>

            <?php if (count($manuals) > 0): ?>
                <?php foreach ($manuals as $manual): ?>
                    <div class="manual-detail">
                        <!-- Problem Name with line below it -->
                        <div class="problem-name"><?php echo htmlspecialchars($manual['problem_name']); ?></div>
                        <div class="problem-line"></div>
                        
                        <div class="details">
                            <p><strong>Description:</strong><br> <?php echo nl2br(htmlspecialchars($manual['problem_description'])); ?></p>
                            <div class="solution-box">
                                <p><strong>Solution:</strong><br> <?php echo nl2br(htmlspecialchars($manual['problem_solution'])); ?></p>
                            </div>
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
