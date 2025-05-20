<?php
// artisan.php - Run this once to set up your database, tables, and insert sample data

$host = 'localhost';
$user = 'root';         // Change if using a different MySQL user
$pass = '';             // Change if your MySQL has a password
$dbName = 'iscp_enrollment';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Database '$dbName' created or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbName);

// Create courses table
$sql = "CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'courses' created.<br>";
} else {
    die("Error creating courses table: " . $conn->error);
}

// Create students table
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'students' created.<br>";
} else {
    die("Error creating students table: " . $conn->error);
}

// Insert meme courses
$courses = [
    'BS in Traffic Management and Advanced Chismis',
    'BS in Professional Line Sitting',
    'BS in Barangay Diplomacy',
    'BS in Advanced Tambay Studies',
    'BS in Sabong Analytics',
    'BS in Jeepney Ergonomics',
    'BS in Street Food Quality Assurance',
    'BS in Teleserye Theory and Application'
];

$conn->query("DELETE FROM students");
$conn->query("DELETE FROM courses");

$stmt = $conn->prepare("INSERT INTO courses (course_name) VALUES (?)");
foreach ($courses as $course) {
    $stmt->bind_param("s", $course);
    $stmt->execute();
}
$stmt->close();
echo "Sample courses inserted.<br>";

// Get course IDs
$course_ids = [];
$result = $conn->query("SELECT id FROM courses");
while ($row = $result->fetch_assoc()) {
    $course_ids[] = $row['id'];
}

// Sample students
$students = [
    'Bong Go',
    'Bam Aquino',
    'Ronald dela Rosa',
    'Erwin Tulfo',
    'Francis “Kiko” Pangilinan',
    'Rodante Marcoleta',
    'Panfilo “Ping” Lacson',
    'Vicente Sotto III',
    'Pia Cayetano',
    'Camille Villar',
    'Lito Lapid',
    'Imee Marcos'
];

$stmt = $conn->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
foreach ($students as $student) {
    $email = strtolower(str_replace([' ', '”', '“', '–', '’', '‘', '.', '”'], '', $student)) . "@iscp.edu.ph";
    $course_id = $course_ids[array_rand($course_ids)];
    $stmt->bind_param("ssi", $student, $email, $course_id);
    $stmt->execute();
}
$stmt->close();

echo "Sample students inserted and randomly enrolled in courses.<br>";

$conn->close();
?>