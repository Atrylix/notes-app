<?php
session_start();

// Setup paths
define('DOMAIN', 'http://localhost');
define('SITE_PATH', '/sites/notes-app');
define('SITE_DIR', DOMAIN . SITE_PATH);

// Setup database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'notes_app_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Error handling
function logError($errorMessage) {
    // Define the path to the log file
    $logFile = 'error_log.txt';

    // Get the current timestamp
    $currentTimestamp = date('Y-m-d H:i:s');

    // Format the error message
    $formattedMessage = "[{$currentTimestamp}] ERROR: {$errorMessage}" . PHP_EOL;

    // Write the error message to the log file
    file_put_contents($logFile, $formattedMessage, FILE_APPEND);

    // Optionally, echo a message indicating the error was logged (for debugging purposes)
    echo "Error logged successfully";
}