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
    </style><<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-fingerprint"></i>
                <h2>Rural Attendance</h2>
            </div>
            
            <nav>
                <a href="#" class="nav-item active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    Students
                </a>
                <a href="reports.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
                <a href="settings.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <div class="top-header">
                <div class="mobile-menu">
                    <i class="fas fa-bars" onclick="toggleSidebar()"></i>
                </div>
                <div class="class-filter">
                    <label>Class:</label>
                    <select id="classFilter">
                        <option value="all">All Classes</option>
                        <option value="5A">Class 5A</option>
                        <option value="5B">Class 5B</option>
                        <option value="6A">Class 6A</option>
                        <option value="6B">Class 6B</option>
                    </select>
                </div>
                <div class="user-info">
                    <i class="fas fa-user"></i>
                    Welcome, <?php echo htmlspecialchars($_SESSION['id_no']); ?>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <div class="value"><?php echo $stats['total'] ?? 0; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Present Today</h3>
                    <div class="value"><?php echo $stats['present'] ?? 0; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Absent Today</h3>
                    <div class="value"><?php echo $stats['absent'] ?? 0; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Average Attendance</h3>
                    <div class="value">
                        <?php 
                        $total = $stats['total'] ?? 0;
                        $present = $stats['present'] ?? 0;
                        echo $total > 0 ? round(($present / $total) * 100, 1) : 0;
                        ?>%
                    </div>
                </div>
            </div>

            <!-- Attendance Scanner -->
            <div class="card mb-4">
                <div class="scanner-section text-center">
                    <div class="fingerprint-scanner" id="scanner" onclick="simulateAttendance()">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <p id="scan-status">Ready to scan fingerprint...</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="chart-grid">
                <div class="card">
                    <h3>Monthly Attendance Trend</h3>
                    <canvas id="attendanceChart"></canvas>
                </div>
                <div class="card">
                    <h3>Today's Stats</h3>
                    <canvas id="todaysPieChart"></canvas>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="attendance-list">
                <div class="attendance-header">
                    <h3>Recent Attendance</h3>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search students..." id="searchAttendance">
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <tr>
                            <td>ST001</td>
                            <td>Rahul Kumar</td>
                            <td>5A</td>
                            <td>2023-09-13</td>
                            <td>08:30 AM</td>
                            <td><span class="badge success">Present</span></td>
                        </tr>
                        <tr>
                            <td>ST002</td>
                            <td>Priya Sharma</td>
                            <td>6B</td>
                            <td>2023-09-13</td>
                            <td>08:32 AM</td>
                            <td><span class="badge success">Present</span></td>
                        </tr>
                        <tr>
                            <td>ST003</td>
                            <td>Amit Singh</td>
                            <td>5A</td>
                            <td>2023-09-13</td>
                            <td>08:45 AM</td>
                            <td><span class="badge error">Absent</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Initialize Charts
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                datasets: [{
                    label: 'Attendance %',
                    data: [92, 94, 93, 95, 94, 96],
                    borderColor: '#2563eb',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        const pieCtx = document.getElementById('todaysPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{
                    data: [235, 13],
                    backgroundColor: ['#10b981', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Search functionality
        document.getElementById('searchAttendance').addEventListener('keyup', function(e) {
            const searchText = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#attendanceTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Class filter functionality
        document.getElementById('classFilter').addEventListener('change', function(e) {
            const selectedClass = e.target.value;
            const rows = document.querySelectorAll('#attendanceTableBody tr');
            
            if (selectedClass === 'all') {
                rows.forEach(row => row.style.display = '');
                return;
            }
            
            rows.forEach(row => {
                const classCell = row.children[2].textContent;
                row.style.display = classCell === selectedClass ? '' : 'none';
            });
        });
    </script>
</body>e>
        body {
            background-color: #f3f4f6;
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
        }

        .sidebar {
            width: 260px;
            background: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 1.5rem;
            border-right: 1px solid var(--border);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .sidebar-header i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-item:hover {
            background-color: #f3f4f6;
        }

        .nav-item.active {
            background-color: var(--primary);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stat-card h3 {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
        }

        .chart-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .attendance-list {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .attendance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 100;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .chart-grid {
                grid-template-columns: 1fr;
            }
        }

        .top-header {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .class-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .class-filter select {
            padding: 0.5rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            outline: none;
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu {
                display: block;
            }
        }
    </style>
</head>
<body>
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --accent: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --gray: #95a5a6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 2rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--light);
        }
        
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 6rem 2rem;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--secondary);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #27ae60;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--dark);
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .card-header {
            background: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-body ul {
            list-style-type: none;
            margin: 1rem 0;
        }
        
        .card-body ul li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .card-body ul li i {
            color: var(--secondary);
            margin-right: 10px;
        }
        
        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .tech-item {
            background: var(--light);
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .tech-item i {
            margin-right: 8px;
            color: var(--primary);
        }
        
        .demo {
            background: var(--light);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }
        
        .demo-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 768px) {
            .demo-container {
                grid-template-columns: 1fr;
            }
        }
        
        .fingerprint-scanner {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .scanner {
            width: 150px;
            height: 150px;
            background: var(--light);
            border-radius: 50%;
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid var(--primary);
        }
        
        .scanner i {
            font-size: 4rem;
            color: var(--primary);
        }
        
        .scanner.active {
            background: var(--primary);
            animation: pulse 1.5s infinite;
        }
        
        .scanner.active i {
            color: white;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(52, 152, 219, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(52, 152, 219, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(52, 152, 219, 0);
            }
        }
        
        .attendance-log {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            overflow-y: auto;
        }
        
        .log-entry {
            padding: 0.8rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .log-entry:last-child {
            border-bottom: none;
        }
        
        .present {
            color: var(--secondary);
        }
        
        .absent {
            color: var(--accent);
        }
        
        .impact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .impact-item {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .impact-item i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        footer {
            background: var(--dark);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: left;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }
        
        .footer-bottom {
            max-width: 1200px;
            margin: 2rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <i class="fas fa-fingerprint"></i>
                <span>RuralAttendance</span>
            </div>
            <ul class="nav-links">
                <li><a href="#solution">Solution</a></li>
                <li><a href="#technology">Technology</a></li>
                <li><a href="#demo">Demo</a></li>
                <li><a href="#impact">Impact</a></li>
                <li><a href="#contact">Contact</a></li>
                 <li><a href="signup.php">Signup</a></li>
                  <li><a href="login.php">login</a></li>
                   <li><a href="login.php">logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Automated Attendance System for Rural Schools</h1>
            <p>A low-cost, offline-first, Aadhaar-based biometric attendance system designed specifically for the challenges of rural Indian schools</p>
            <a href="#demo" class="btn">See Demo</a>
        </div>
    </section>

    <section id="solution" class="container">
        <div class="section-title">
            <h2>Proposed Solution</h2>
            <p>Addressing the challenges of rural education through technology</p>
        </div>
        
        <div class="cards">
            <div class="card">
                <div class="card-header">
                    <h3>The Problem</h3>
                </div>
                <div class="card-body">
                    <p>Rural schools often rely on cumbersome manual attendance registers, leading to:</p>
                    <ul>
                        <li><i class="fas fa-times-circle"></i> Errors and inaccuracies</li>
                        <li><i class="fas fa-clock"></i> Significant time consumption</li>
                        <li><i class="fas fa-chart-line"></i> Difficulty in tracking absenteeism</li>
                        <li><i class="fas fa-user-minus"></i> High dropout rates</li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Our Solution</h3>
                </div>
                <div class="card-body">
                    <p>Our system provides a comprehensive solution:</p>
                    <ul>
                        <li><i class="fas fa-fingerprint"></i> Aadhaar-based biometric authentication</li>
                        <li><i class="fas fa-wifi-slash"></i> Offline-first functionality</li>
                        <li><i class="fas fa-sms"></i> Automated SMS alerts to parents</li>
                        <li><i class="fas fa-database"></i> Digital reporting for authorities</li>
                        <li><i class="fas fa-solar-panel"></i> Solar-powered for power outages</li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Key Benefits</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Eliminates manual entry</li>
                        <li><i class="fas fa-shield-alt"></i> Ensures accuracy with biometrics</li>
                        <li><i class="fas fa-bell"></i> Promotes accountability with parent alerts</li>
                        <li><i class="fas fa-chart-pie"></i> Provides real-time data for authorities</li>
                        <li><i class="fas fa-rupee-sign"></i> Low-cost and scalable</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="technology" class="container">
        <div class="section-title">
            <h2>Technical Approach</h2>
            <p>Leveraging robust and affordable technology</p>
        </div>
        
        <div class="tech-stack">
            <div class="tech-item"><i class="fab fa-python"></i> Python</div>
            <div class="tech-item"><i class="fas fa-database"></i> SQLite</div>
            <div class="tech-item"><i class="fab fa-html5"></i> HTML/CSS/JavaScript</div>
            <div class="tech-item"><i class="fas fa-flask"></i> Flask</div>
            <div class="tech-item"><i class="fas fa-microchip"></i> Raspberry Pi</div>
            <div class="tech-item"><i class="fas fa-sms"></i> GSM Module</div>
        </div>
        
        <div class="cards">
            <div class="card">
                <div class="card-header">
                    <h3>Hardware Components</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><i class="fas fa-check"></i> Raspberry Pi 4 (Processing Unit)</li>
                        <li><i class="fas fa-check"></i> UIDAI-certified Fingerprint Scanner</li>
                        <li><i class="fas fa-check"></i> GSM Module (for SMS)</li>
                        <li><i class="fas fa-check"></i> Power Bank/Solar Battery Pack</li>
                        <li><i class="fas fa-check"></i> Protective Casing</li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Software Components</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><i class="fas fa-check"></i> Python Backend Logic</li>
                        <li><i class="fas fa-check"></i> Local SQLite Database</li>
                        <li><i class="fas fa-check"></i> Flask Web Framework</li>
                        <li><i class="fas fa-check"></i> UIDAI Authentication API</li>
                        <li><i class="fas fa-check"></i> SMS Gateway API</li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Security Features</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><i class="fas fa-shield-alt"></i> No raw biometric data stored</li>
                        <li><i class="fas fa-lock"></i> Encrypted templates only</li>
                        <li><i class="fas fa-shield-virus"></i> Secure data transmission</li>
                        <li><i class="fas fa-user-lock"></i> Aadhaar-compliant privacy</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="demo" class="container">
        <div class="section-title">
            <h2>System Demo</h2>
            <p>Experience how the attendance system works</p>
        </div>
        
        <div class="demo">
            <div class="demo-container">
                <div class="fingerprint-scanner">
                    <h3>Fingerprint Scanner</h3>
                    <p>Click the scanner to simulate fingerprint authentication</p>
                    <div class="scanner" id="scanner">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <p id="scan-status">Ready to scan...</p>
                    <div id="student-info" style="display: none;">
                        <h4>Student Identified:</h4>
                        <p id="student-name"></p>
                        <p id="student-class"></p>
                    </div>
                </div>
                
                <div class="attendance-log">
                    <h3>Attendance Log</h3>
                    <div id="log-entries">
                        <div class="log-entry">
                            <span>No entries yet</span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="impact" class="container">
        <div class="section-title">
            <h2>Impact & Benefits</h2>
            <p>Transforming rural education through technology</p>
        </div>
        
        <div class="impact-grid">
            <div class="impact-item">
                <i class="fas fa-user-graduate"></i>
                <h3>Improved Attendance</h3>
                <p>Real-time tracking reduces absenteeism by up to 70%</p>
            </div>
            
            <div class="impact-item">
                <i class="fas fa-chart-line"></i>
                <h3>Better Data</h3>
                <p>Accurate reporting helps in resource allocation</p>
            </div>
            
            <div class="impact-item">
                <i class="fas fa-users"></i>
                <h3>Parental Involvement</h3>
                <p>SMS alerts keep parents informed and engaged</p>
            </div>
            
            <div class="impact-item">
                <i class="fas fa-clock"></i>
                <h3>Time Savings</h3>
                <p>Reduces administrative workload by 80%</p>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are a team of technologists and educators committed to improving rural education through affordable technology solutions.</p>
            </div>
            
            <div class="footer-section">
                <h3>Contact Information</h3>
                <p><i class="fas fa-envelope"></i> contact@ruralattendance.org</p>
                <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                <p><i class="fas fa-map-marker-alt"></i> Bengaluru, India</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="#solution">Our Solution</a></p>
                <p><a href="#technology">Technology</a></p>
                <p><a href="#demo">Demo</a></p>
                <p><a href="#impact">Impact</a></p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2023 RuralAttendance. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Simulated backend data
        const students = {
            "1": { name: "Rahul Sharma", class: "Class 5A", parentPhone: "+91XXXXXXXXXX" },
            "2": { name: "Priya Patel", class: "Class 7B", parentPhone: "+91XXXXXXXXXX" },
            "3": { name: "Amit Kumar", class: "Class 6C", parentPhone: "+91XXXXXXXXXX" },
            "4": { name: "Sneha Singh", class: "Class 8A", parentPhone: "+91XXXXXXXXXX" },
            "5": { name: "Vikram Yadav", class: "Class 5B", parentPhone: "+91XXXXXXXXXX" }
        };
        
        let attendanceLog = [];
        
        // DOM Elements
        const scanner = document.getElementById('scanner');
        const scanStatus = document.getElementById('scan-status');
        const studentInfo = document.getElementById('student-info');
        const studentName = document.getElementById('student-name');
        const studentClass = document.getElementById('student-class');
        const logEntries = document.getElementById('log-entries');
        
        // Scanner functionality
        scanner.addEventListener('click', simulateScan);
        
        function simulateScan() {
            // Show scanning animation
            scanner.classList.add('active');
            scanStatus.textContent = "Scanning fingerprint...";
            
            // Simulate backend processing
            setTimeout(() => {
                // Random student ID for demo
                const studentId = Math.floor(Math.random() * 5) + 1;
                const student = students[studentId];
                
                // Update UI
                scanStatus.textContent = "Attendance recorded!";
                studentName.textContent = student.name;
                studentClass.textContent = student.class;
                studentInfo.style.display = 'block';
                
                // Add to attendance log
                const timestamp = new Date().toLocaleTimeString();
                const status = "Present";
                
                attendanceLog.unshift({
                    student: student.name,
                    class: student.class,
                    time: timestamp,
                    status: status
                });
                
                updateAttendanceLog();
                
                // Simulate SMS to parent
                simulateSMSSend(student.parentPhone, student.name);
                
                // Reset scanner after delay
                setTimeout(() => {
                    scanner.classList.remove('active');
                    scanStatus.textContent = "Ready to scan...";
                }, 2000);
            }, 2000);
        }
        
        function updateAttendanceLog() {
            if (attendanceLog.length === 0) {
                logEntries.innerHTML = '<div class="log-entry"><span>No entries yet</span><span></span></div>';
                return;
            }
            
            logEntries.innerHTML = '';
            attendanceLog.forEach(entry => {
                const logEntry = document.createElement('div');
                logEntry.className = 'log-entry';
                logEntry.innerHTML = `
                    <span>${entry.student} (${entry.class})</span>
                    <span class="${entry.status.toLowerCase()}">${entry.status} at ${entry.time}</span>
                `;
                logEntries.appendChild(logEntry);
            });
        }
        
        function simulateSMSSend(phone, studentName) {
            console.log(SMS sent to ${phone}: Your child ${studentName} has been marked present at school.);
            // In a real implementation, this would connect to a GSM module or SMS API
        }
        
        // Initialize with empty log
        updateAttendanceLog();
    </script>
</body>
</html>