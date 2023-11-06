<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    exit('Access denied');
}

// Define the directory to look for files
$uploadDir = __DIR__ . '/uploads/';

// Function to get a list of all files
function getUploadedFiles($directory) {
    $files = scandir($directory);
    // Remove '.' and '..' from the array
    return array_diff($files, array('.', '..'));
}

// Function to delete a file
function deleteFile($directory, $filename) {
    $filePath = $directory . $filename;
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    }
    return false;
}

// Handle AJAX request for listing files
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode(getUploadedFiles($uploadDir));
    exit;
}

// Handle AJAX request for deleting files
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    if (deleteFile($uploadDir, $filename)) {
        echo "File deleted successfully.";
    } else {
        echo "Failed to delete file.";
    }
    exit;
}
?>
