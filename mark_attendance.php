<?php
session_start();
if (!isset($_SESSION['id_no'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";      
$pass = "";          
$db   = "myadmit";   

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    FOREIGN KEY (student_id) REFERENCES users(id_no)
)";

$conn->query($sql);

// Handle attendance submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_attendance'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $class = $_POST['class'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO attendance (student_id, student_name, class, date, time, status) 
            VALUES (?, ?, ?, CURDATE(), CURTIME(), ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $student_id, $student_name, $class, $status);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Attendance marked successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error marking attendance']);
    }
    exit();
}

// Get today's attendance
$sql = "SELECT * FROM attendance WHERE date = CURDATE() ORDER BY time DESC LIMIT 10";
$result = $conn->query($sql);
$attendance_records = [];
while ($row = $result->fetch_assoc()) {
    $attendance_records[] = $row;
}

// Get attendance statistics
$sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
            SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent
        FROM attendance 
        WHERE date = CURDATE()";
$stats = $conn->query($sql)->fetch_assoc();

$conn->close();
?>