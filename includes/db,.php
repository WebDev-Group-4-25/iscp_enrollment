<?php
/**
 * db.php
 *
 * Reusable database connection module.
 * Usage:
 *   require_once 'db.php';
 *   then you can use $pdo to perform queries
 *
 * Configuration:
 *   - Update DB_HOST, DB_NAME, DB_USER, DB_PASS to your environment settings.
 *   - Optionally adjust charset if needed.
 */

// Database configuration
define('DB_HOST', 'localhost');      // e.g. '127.0.0.1' or your DB server
define('DB_NAME', 'student_enrollment');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_CHARSET', 'utf8mb4');

try {
    // Data Source Name (DSN)
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    // PDO options for better error handling and security
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch associative arrays
        PDO::ATTR_EMULATE_PREPARES => false,                  // use real prepared statements
    ];

    // Create PDO instance
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    // In production, you might log the error instead of echoing it
    echo '<h3>Database Connection Error</h3>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    exit; // stop execution if DB connection fails
}
