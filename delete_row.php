<?php
// delete_row.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];

    $sql = "DELETE FROM queue_data WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>
