<?php
$host = "localhost";
$user = "root";      
$pass = "";          
$db   = "myadmit";   

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS myadmit";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($db);

// Create users table if not exists
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_no VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    class VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully or already exists<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create attendance table if not exists
$sql = "CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255),
    student_name VARCHAR(255),
    class VARCHAR(50),
    date DATE,
    time TIME,
    status ENUM('present', 'absent') DEFAULT 'present',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id_no)
)";

if ($conn->query($sql) === TRUE) {
    echo "Attendance table created successfully or already exists<br>";
} else {
    echo "Error creating attendance table: " . $conn->error . "<br>";
}

// Add indexes for better performance
$sql = "CREATE INDEX IF NOT EXISTS idx_attendance_date ON attendance(date)";
$conn->query($sql);

$sql = "CREATE INDEX IF NOT EXISTS idx_attendance_student ON attendance(student_id)";
$conn->query($sql);

$conn->close();

echo "Database setup completed successfully!";
?>