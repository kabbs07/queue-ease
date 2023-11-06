<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

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

// Set a time limit for script execution to prevent server timeouts
set_time_limit(0);

// Infinite loop to keep the script running
while (true) {
    // Modified SQL to exclude served customers
    $sql = "SELECT * FROM queue_data WHERE status != 'Served' ORDER BY id ASC"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo "data: " . json_encode($data) . "\n\n";
    } else {
        echo "data: " . json_encode([]) . "\n\n";
    }

    // Send a comment line to prevent browser timeouts
    echo ": heartbeat\n\n";

    flush();
    sleep(5); // Delay to reduce load, adjust this value as needed
}

// This line will not be reached because of the infinite loop. 
// If you ever decide to break the loop in the future, then this line can close the connection.
$conn->close(); 
?>
