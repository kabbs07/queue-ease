<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

// Ensure output buffering is turned off
if (ob_get_level()) ob_end_clean();

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Protect against SQL injection (use prepared statements)

// Check if it's a cashier login
$stmtCashier = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'user'");
$stmtCashier->bind_param('s', $username);

$stmtCashier->execute();
$resultCashier = $stmtCashier->get_result();
$userCashier = $resultCashier->fetch_assoc();

// Check if it's an admin login
$stmtAdmin = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
$stmtAdmin->bind_param('s', $username);

$stmtAdmin->execute();
$resultAdmin = $stmtAdmin->get_result();
$userAdmin = $resultAdmin->fetch_assoc();

// Verify the password using password_verify
if ($userCashier && password_verify($password, $userCashier['password'])) {
    $_SESSION['loggedin'] = true;
    updateUserStatus($userCashier['id'], 'Online'); // Set status to Online
    header('Location: cashier.php');
} elseif ($userAdmin && password_verify($password, $userAdmin['password'])) {
    $_SESSION['loggedin'] = true;
    updateUserStatus($userAdmin['id'], 'Online'); // Set status to Online
    header('Location: admin.php');
} else {
    echo "<script>alert('Invalid login credentials');</script>";
    echo '<script>window.location.href = "login_page.php";</script>';

}

$stmtCashier->close();
$stmtAdmin->close();
$conn->close();

// Function to update user status
function updateUserStatus($userId, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $userId);
    $stmt->execute();
    $stmt->close();
}
?>
