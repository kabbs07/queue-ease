<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_POST['type'];

$sql = "SELECT * FROM queue_data WHERE customer_type='$type'";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} 

echo json_encode($data);

$conn->close();
?>
