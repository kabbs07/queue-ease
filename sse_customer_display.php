<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Database connection here
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

while (true) {
    $sql = "SELECT * FROM queue_data WHERE status IN ('Waiting', 'Serving') ORDER BY id ASC"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo "data: " . json_encode($data) . "\n\n";
    } else {
        echo "data: []\n\n";
    }

    ob_flush();
    flush();
    sleep(5);
}

$conn->close();
?>
