<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false]);
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Get the next priority customer and set them to "Serving"
try {
    $conn->beginTransaction();
    $stmt = $conn->prepare("SELECT * FROM queue_data WHERE status = 'Waiting' AND customer_type = 'Priority' ORDER BY id ASC LIMIT 1");
    $stmt->execute();
    $priorityCustomer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($priorityCustomer) {
        $updateStmt = $conn->prepare("UPDATE queue_data SET status = 'Serving' WHERE id = :id");
        $updateStmt->execute(['id' => $priorityCustomer['id']]);
        $conn->commit();
        echo json_encode(['success' => true, 'priorityCustomer' => $priorityCustomer]);
    } else {
        $conn->commit();
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}
?>
