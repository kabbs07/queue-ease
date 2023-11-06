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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Set the default status to "Offline"
    $status = "Offline";

    // Check if the email address already exists in the database
    $emailCheck = "SELECT * FROM users WHERE email = ?";
    $stmtEmailCheck = $conn->prepare($emailCheck);
    $stmtEmailCheck->bind_param("s", $email);
    $stmtEmailCheck->execute();
    $resultEmailCheck = $stmtEmailCheck->get_result();

    if ($resultEmailCheck->num_rows > 0) {
        // Email address already exists
        echo "<script>alert('The email address is already in use. Please choose another email.');</script>";
        echo '<script>window.location.href = "users.php";</script>';
    } else {
        // Hash the password (for security)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user data into the database
        $sql = "INSERT INTO users (username, password, email, role, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssss", $username, $hashed_password, $email, $role, $status);
            if ($stmt->execute()) {
                // User added successfully
                header('Location: users.php'); // Redirect to the user list page or another appropriate page
                exit;
            } else {
                // Other error occurred while adding the user
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Error in preparing the SQL statement
            echo "Error: " . $conn->error;
        }
    }

    $stmtEmailCheck->close();
}

// Close the database connection
$conn->close();
?>
