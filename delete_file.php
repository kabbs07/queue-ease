<?php
session_start();

// Add your session check here

$uploadDir = __DIR__ . '/uploads/';

if (isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $filePath = $uploadDir . $filename;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "File deleted successfully.";
    } else {
        echo "File does not exist.";
    }
} else {
    echo "No file specified.";
}
?>