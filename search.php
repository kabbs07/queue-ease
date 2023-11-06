<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header('Location: login_page.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchValue'])) {
    // Database connection configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "queuing_system";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and prepare the search value
    $searchValue = $conn->real_escape_string($_POST['searchValue']);

    // SQL query to search for customer name in the database
    $sql = "SELECT * FROM queue_data WHERE customer_name LIKE '%$searchValue%'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $searchResults = [];
        while ($row = $result->fetch_assoc()) {
            // Add each row as an array to the search results
            $searchResults[] = [
                $row["customer_type"],
                $row["choose_service"],
                $row["payment_for"],
                $row["mode_of_payment"],
                $row["customer_name"],
                $row["status"]
            ];
        }
        $response = ['success' => true, 'results' => $searchResults];
        echo json_encode($response);
    } else {
        $response = ['success' => false];
        echo json_encode($response);
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle invalid requests here
    echo json_encode(['success' => false]);
}
?>
