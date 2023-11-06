<?php
// Database connection configuration (same as your existing code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search value from the AJAX request
$searchValue = $_POST['searchValue'];

// SQL query to search for customer names
$sql = "SELECT * FROM queue_data WHERE customer_name LIKE '%" . $searchValue . "%'";
$result = $conn->query($sql);

$response = [];

if ($result !== false && $result->num_rows > 0) {
    // Convert the result into an array
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

// Return the search results as JSON
echo json_encode(['success' => true, 'results' => $response]);

// Close the database connection
$conn->close();
?>
