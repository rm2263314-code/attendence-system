<?php
session_start();
if (!isset($_SESSION['id_no'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$host = "localhost";
$user = "root";      
$pass = "";          
$db   = "myadmit";   

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Get latest attendance records
$sql = "SELECT * FROM attendance WHERE date = CURDATE() ORDER BY time DESC LIMIT 10";
$result = $conn->query($sql);

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['records' => $records]);

$conn->close();
?>