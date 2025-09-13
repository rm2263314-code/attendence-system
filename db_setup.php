<?php
function setupDatabase() {
    $host = "localhost";
    $user = "root";      
    $pass = "";          
    $db   = "myadmit";   

    try {
        // Create connection without database
        $conn = new mysqli($host, $user, $pass);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Create database if not exists
        $sql = "CREATE DATABASE IF NOT EXISTS $db";
        if (!$conn->query($sql)) {
            throw new Exception("Error creating database: " . $conn->error);
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

        if (!$conn->query($sql)) {
            throw new Exception("Error creating users table: " . $conn->error);
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

        if (!$conn->query($sql)) {
            throw new Exception("Error creating attendance table: " . $conn->error);
        }

        // Add indexes for better performance
        $conn->query("CREATE INDEX IF NOT EXISTS idx_attendance_date ON attendance(date)");
        $conn->query("CREATE INDEX IF NOT EXISTS idx_attendance_student ON attendance(student_id)");

        $conn->close();
        return true;
    } catch (Exception $e) {
        error_log("Database setup error: " . $e->getMessage());
        return false;
    }
}

// Function to connect to database and setup if needed
function connectDatabase() {
    $host = "localhost";
    $user = "root";      
    $pass = "";          
    $db   = "myadmit";   

    try {
        $conn = new mysqli($host, $user, $pass, $db);
        
        if ($conn->connect_error) {
            // Try to setup database if connection fails
            if (setupDatabase()) {
                // Try connecting again
                $conn = new mysqli($host, $user, $pass, $db);
                if ($conn->connect_error) {
                    throw new Exception("Connection failed after setup: " . $conn->connect_error);
                }
            } else {
                throw new Exception("Connection failed and setup failed");
            }
        }
        
        return $conn;
    } catch (Exception $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}
?>