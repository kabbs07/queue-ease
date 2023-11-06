<?php
// Database connection configuration
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

// SQL query to delete all data from your table
$sql = "DELETE FROM queue_data";
$result = $conn->query($sql);

// Return a JSON response indicating the success or failure of the operation
if ($result === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

// Close the connection
$conn->close();
?>
