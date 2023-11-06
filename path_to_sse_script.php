<?php
// Disable PHP's output buffering
while (ob_get_level()) ob_end_clean();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// This loop is only to demonstrate how the server can send messages at regular intervals.
// In a real application, you might query a database or perform some other action.
while (true) {
    $currentTime = date('Y-m-d H:i:s');

    // Send a simple message with the current time
    echo "data: The server time is: {$currentTime}\n\n";

    // Flush the output buffer and send echoed messages to the browser
    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    flush();

    // Break the loop if the connection is closed by the client
    if (connection_aborted()) break;

    // Sleep for 1 second before the next message
    sleep(1);
}

// You may want to handle cleanup here if needed
?>
