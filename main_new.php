<?php
session_start();
if (!isset($_SESSION['id_no'])) {
    header("Location: login.php");
    exit();
}

// Establish database connection
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id_no)
)";

$conn->query($sql);

// Get attendance statistics
$sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
    SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent
FROM attendance 
WHERE date = CURDATE()";

$stats = $conn->query($sql)->fetch_assoc();

// Get total students
$sql = "SELECT COUNT(*) as total FROM users";
$total_students = $conn->query($sql)->fetch_assoc()['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rural Attendance System</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f3f4f6;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card, .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--text);
            text-decoration: none;
            transition: background 0.3s;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--primary);
            color: white;
        }
        .attendance-list {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .user-welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .quick-actions {
            display: flex;
            gap: 1rem;
        }
        .logo-section {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .logo-section h1 {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
        }
        .logo-section p {
            color: var(--text-light);
            margin-top: 0.25rem;
        }
        .attendance-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .attendance-item:last-child {
            border-bottom: none;
        }
        .status.present {
            color: #10B981;
        }
        .status.absent {
            color: #EF4444;
        }
        .trend {
            font-size: 0.875rem;
            color: var(--text-light);
        }
        .trend.up {
            color: #10B981;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-section">
                <h1><i class="fas fa-fingerprint"></i> Rural Attendance</h1>
                <p>Dashboard</p>
            </div>
            <nav class="sidebar-nav">
                <a href="main_new.php" class="nav-item active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-users"></i> Students
                </a>
                <a href="reports.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
                <a href="settings.php" class="nav-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="user-welcome">
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['id_no']); ?>!</h1>
                <div class="quick-actions">
                    <button class="btn btn-primary" onclick="markAttendance()">
                        <i class="fas fa-user-check"></i> Mark Attendance
                    </button>
                    <button class="btn btn-secondary" onclick="window.location.href='reports.php'">
                        <i class="fas fa-download"></i> Download Report
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Today's Attendance</h3>
                    <div class="value">0</div>
                    <div class="stat-chart" id="todayAttendance"></div>
                </div>
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <div class="value">0</div>
                    <div class="trend up">↑ 5% from last week</div>
                </div>
                <div class="stat-card">
                    <h3>Average Attendance</h3>
                    <div class="value">0%</div>
                    <div class="trend">This Week</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="chart-grid">
                <div class="chart-card">
                    <h3>Attendance Trends</h3>
                    <canvas id="attendanceChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3>Class Distribution</h3>
                    <canvas id="classChart"></canvas>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="attendance-list">
                <div class="list-header">
                    <h3>Recent Attendance</h3>
                    <div class="search-box">
                        <input type="text" placeholder="Search students...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div id="recentAttendance">
                    <!-- Attendance records will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/darkmode.js"></script>
    <script>
        // Initialize Charts
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [{
                    label: 'Attendance Rate',
                    data: [85, 88, 92, 87, 90],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });

        const classCtx = document.getElementById('classChart').getContext('2d');
        new Chart(classCtx, {
            type: 'doughnut',
            data: {
                labels: ['Class A', 'Class B', 'Class C'],
                datasets: [{
                    data: [30, 25, 20],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ]
                }]
            }
        });

        // Function to mark attendance
        function markAttendance() {
            // Show marking interface or trigger biometric scan
            alert('Attendance marking interface will be shown here');
        }

        // Function to load recent attendance
        function loadRecentAttendance() {
            fetch('get_attendance.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('recentAttendance');
                    if (data.records && data.records.length > 0) {
                        const html = data.records.map(record => `
                            <div class="attendance-item">
                                <div class="student-info">
                                    <strong>${record.student_name}</strong>
                                    <span>${record.class}</span>
                                </div>
                                <div class="time-info">
                                    <span>${record.time}</span>
                                    <span class="status ${record.status}">${record.status}</span>
                                </div>
                            </div>
                        `).join('');
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = '<p>No recent attendance records</p>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Load initial data
        loadRecentAttendance();
        // Refresh data every minute
        setInterval(loadRecentAttendance, 60000);
    </script>
</body>
</html>