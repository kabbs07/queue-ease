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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $newUsername = $_POST['new_username'];

    // Update the username based on user ID
    $sql = "UPDATE users SET username = '$newUsername' WHERE id = $userId";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the user list page after successful update
        header("Location: users.php");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

// Retrieve user ID from the URL parameter
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Retrieve user data based on the user ID
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $currentUsername = $row['username'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
</head>
<body>

<!-- Navigation -->
<?php include('navbar.php'); ?>

<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo $currentUsername; ?>" required>
        
        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
