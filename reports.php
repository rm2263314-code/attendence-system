<?php
session_start();
if (!isset($_SESSION['id_no'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Rural Attendance System</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .report-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .date-range {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .date-input {
            padding: 0.5rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .report-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        .chart-container {
            margin-top: 2rem;
            height: 300px;
        }

        .export-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-export {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-export:hover {
            background: #f3f4f6;
        }

        .class-buttons {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .class-btn {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            cursor: pointer;
            background: white;
        }

        .class-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .export-buttons {
                flex-wrap: wrap;
            }
            
            .date-range {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-fingerprint"></i>
                <h2>Rural Attendance</h2>
            </div>
            
            <nav>
                <a href="main.php" class="nav-item">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    Students
                </a>
                <a href="reports.php" class="nav-item active">
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
            <div class="top-header">
                <div class="mobile-menu">
                    <i class="fas fa-bars" onclick="toggleSidebar()"></i>
                </div>
                <h2>Attendance Reports</h2>
                <div class="export-buttons">
                    <button class="btn-export">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button class="btn-export">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Date Range Selector -->
            <div class="report-section">
                <div class="date-range">
                    <input type="date" class="date-input" id="startDate">
                    <span>to</span>
                    <input type="date" class="date-input" id="endDate">
                    <button class="btn btn-primary" onclick="generateReport()">Generate Report</button>
                </div>
            </div>

            <!-- Class Selection -->
            <div class="class-buttons">
                <button class="class-btn active">All Classes</button>
                <button class="class-btn">Class 5A</button>
                <button class="class-btn">Class 5B</button>
                <button class="class-btn">Class 6A</button>
                <button class="class-btn">Class 6B</button>
            </div>

            <!-- Summary Cards -->
            <div class="report-grid">
                <div class="report-card">
                    <h3>Average Attendance</h3>
                    <div class="value">94.5%</div>
                </div>
                <div class="report-card">
                    <h3>Most Absent Class</h3>
                    <div class="value">Class 6B</div>
                </div>
                <div class="report-card">
                    <h3>Total Students</h3>
                    <div class="value">248</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="report-section">
                <h3>Attendance Trends</h3>
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="report-section">
                <h3>Class-wise Attendance</h3>
                <div class="chart-container">
                    <canvas id="classChart"></canvas>
                </div>
            </div>

            <!-- Detailed Report Table -->
            <div class="report-section">
                <h3>Detailed Report</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Total Students</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-09-13</td>
                            <td>5A</td>
                            <td>45</td>
                            <td>43</td>
                            <td>2</td>
                            <td>95.6%</td>
                        </tr>
                        <tr>
                            <td>2023-09-13</td>
                            <td>5B</td>
                            <td>42</td>
                            <td>40</td>
                            <td>2</td>
                            <td>95.2%</td>
                        </tr>
                        <!-- More rows will be added dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Initialize charts
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                datasets: [{
                    label: 'Attendance %',
                    data: [95, 93, 94, 92, 96],
                    borderColor: var(--primary),
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const classCtx = document.getElementById('classChart').getContext('2d');
        new Chart(classCtx, {
            type: 'bar',
            data: {
                labels: ['Class 5A', 'Class 5B', 'Class 6A', 'Class 6B'],
                datasets: [{
                    label: 'Average Attendance %',
                    data: [95, 92, 94, 91],
                    backgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Class button functionality
        const classButtons = document.querySelectorAll('.class-btn');
        classButtons.forEach(button => {
            button.addEventListener('click', () => {
                classButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                // Add class filtering logic here
            });
        });

        // Generate report function
        function generateReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            // Add report generation logic here
        }
    </script>
</body>
</html>