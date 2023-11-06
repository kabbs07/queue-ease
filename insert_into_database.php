<?php

// Assuming you have a MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Retrieve values from POST request
$customerType = $_POST['customerType'];
$chooseService = $_POST['chooseService'];
$paymentFor = $_POST['paymentFor'];
$modePayment = $_POST['modePayment'];
$customerName = $_POST['name'];

// Retrieve email from POST request
$email = $_POST['email'];

// Check if email is empty or valid
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = array("success" => false, "error" => "Invalid email format");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Perform the SQL query to insert data into the database using prepared statements
$stmt = $conn->prepare("INSERT INTO queue_data (customer_type, choose_service, payment_for, mode_of_payment, customer_name, email) VALUES (?, ?, ?, ?, ?, ?)");

// Bind parameters including email
$stmt->bind_param("ssssss", $customerType, $chooseService, $paymentFor, $modePayment, $customerName, $email);

// Execute the statement
if ($stmt->execute()) {
    $response = array("success" => true, "queueNumber" => $stmt->insert_id);
} else {
    $response = array("success" => false, "error" => $conn->error);
}

// Close the statement and the database connection
$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
