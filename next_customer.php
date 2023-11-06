<?php
// Database connection here
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

if (isset($_POST['action']) && $_POST['action'] === 'next') {
    $stmt = $conn->prepare("SELECT id FROM queue_data WHERE status = 'Waiting' ORDER BY id ASC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $customerId = $result['id'];
        $updateStmt = $conn->prepare("UPDATE queue_data SET status = 'Serving' WHERE id = :customerId");
        $updateStmt->bindParam(':customerId', $customerId);
        $updateStmt->execute();
    }

    header('Location: cashier.php');
    exit;
}
?>
