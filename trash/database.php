<?php
function loadEnv($file) {
    if (!file_exists($file)) {
        throw new Exception("Env file not found.");
    }

    // Read the .env file and parse it
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore comments and empty lines
        if (strpos($line, '#') === 0) {
            continue;
        }
        // Ensure no additional whitespace around key-value pairs
        list($key, $value) = explode('=', $line, 2);
        if ($key && $value) {
            // Set environment variables securely
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

loadEnv(__DIR__ . '/.env');

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

if (empty($host) || empty($user) || empty($password) || empty($dbname)) {
    error_log("Missing or incorrect environment variables.", 0);
    die("An error occurred while configuring the database connection.");
}

if (!filter_var($host, FILTER_VALIDATE_URL) && !preg_match('/^[a-zA-Z0-9.-]+$/', $host)) {
    error_log("Invalid DB_HOST value.", 0);
    die("Invalid database host.");
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $dbname)) {
    error_log("Invalid DB_NAME value.", 0);
    die("Invalid database name.");
}
mysqli_report(MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($host, $user, $password, $dbname);
    
    // Check the connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    } else {
        // echo "Successfully connected!";
    }
} catch (Exception $e) {
    // Log the error securely without exposing sensitive details
    error_log($e->getMessage(), 0);
    die("Unable to connect to the database.");
}
?>