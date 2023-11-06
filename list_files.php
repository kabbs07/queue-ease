<?php
session_start();

// Add your session check here

$uploadDir = __DIR__ . '/uploads/';
$files = array_diff(scandir($uploadDir), array('.', '..'));

echo json_encode($files);
?>