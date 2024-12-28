<?php
// Database connection (adjust with your DB credentials)
$host = 'localhost';  // Database host
$dbname = 'diy_repair_manuals'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the search query from the URL
    if (isset($_GET['query'])) {
        $query = "%" . $_GET['query'] . "%";
        
        // Prepare and execute the query to fetch matching problem names
        $stmt = $pdo->prepare("SELECT problem_name FROM electrical_manuals WHERE problem_name LIKE ?");
        $stmt->execute([$query]);

        // Fetch all matching records
        $manuals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the results as JSON
        echo json_encode($manuals);
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
