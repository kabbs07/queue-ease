<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login_page.php');
    exit;
}

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system"; // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Delete the user based on the user ID
    $sql = "DELETE FROM users WHERE id = $userId";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the user list page after successful deletion
        header("Location: users.php");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "User ID not provided.";
    exit;
}
?>
