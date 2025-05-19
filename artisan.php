<?php
/**
 * Artisan-style setup script for Contact Manager
 *
 * Usage: Run from browser or CLI (php artisan.php)
 * Automatically creates the database, contacts table, and inserts sample data.
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'contact_manager';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select database
$conn->select_db($dbname);

// Create table
$createTable = "
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20)
)";
$conn->query($createTable);

// Insert sample data
$sampleData = [
    ['Alice Johnson', 'alice@example.com', '1234567890'],
    ['Bob Smith', 'bob@example.com', '9876543210'],
    ['Carol White', 'carol@example.com', '5551234567']
];

$stmt = $conn->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");

foreach ($sampleData as $contact) {
    $stmt->bind_param("sss", $contact[0], $contact[1], $contact[2]);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "✅ Setup complete: Database, table, and sample contacts created.";
?>