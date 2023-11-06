<?php
// Database connection configuration (same as your existing code)
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

// Fetch email notifications from the database
$stmt = $conn->prepare("SELECT * FROM queue_data WHERE email IS NOT NULL AND email <> '' AND status = 'Waiting'");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($customers as $customer) {
    echo '<div class="customer">';
    echo '<span>' . htmlspecialchars($customer['customer_name']) . ' (' . htmlspecialchars($customer['email']) . ')' . '</span>';
    echo '<button type="button" class="notifyButton" data-email="' . htmlspecialchars($customer['email']) . '">Notify</button>';
    echo '</div>';
}
?>
