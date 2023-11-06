<?php
session_start();

// Check if the user is logged in and the user_id is set in the session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
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

    // Start the transaction
    $conn->begin_transaction();

    try {
        // Update user status to 'Offline'
        updateUserStatus($_SESSION['user_id'], 'Offline');

        // If everything is fine, commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        // If there is an error, rollback the transaction
        $conn->rollback();
        // Handle exception, perhaps log the error
        // For example:
        // error_log("Failed to update user status: " . $e->getMessage());
    }

    // Close the database connection
    $conn->close();
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login_page.php');
exit;

// Function to update user status
function updateUserStatus($userId, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $userId);
    $stmt->execute();
    $stmt->close();
}
?>
