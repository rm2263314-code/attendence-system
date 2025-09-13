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
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --success: #22c55e;
            --error: #ef4444;
            --text: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --bg-main: #f3f4f6;
            --bg-card: white;
            --shadow: rgba(0, 0, 0, 0.05);
        }

        body.dark-mode {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --text: #f3f4f6;
            --text-light: #9ca3af;
            --border: #374151;
            --bg-main: #111827;
            --bg-card: #1f2937;
            --shadow: rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .sidebar {
            background: #1f2937;
        }
        
        body.dark-mode .stat-card,
        body.dark-mode .chart-card {
            background: var(--bg-card);
            box-shadow: 0 2px 4px var(--shadow);
        }

        body.dark-mode .nav-item {
            color: var(--text);
        }

        body.dark-mode .nav-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.1);
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
        }
        .stat-card, .chart-card {
            background: var(--bg-card);
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 4px var(--shadow);
            transition: all 0.3s ease;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text);
            margin: 0.5rem 0;
        }
        .stat-label {
            color: var(--text-light);
            font-size: 0.875rem;
        }
        .chart-card {
            padding: 0;
            overflow: hidden;
        }

        .chart-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .chart-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .chart-content {
            padding: 1.5rem;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .chart-legend {
            display: flex;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: var(--bg-main);
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .header-content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .top-header {
            background: var(--bg-card);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px var(--shadow);
        }

        .header-content {
            margin-bottom: 1.5rem;
        }

        .header-content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: var(--text);
        }

        .text-light {
            color: var(--text-light);
            margin-top: 0.5rem;
        }

        .date-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .date-inputs {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--bg-main);
            padding: 0.5rem;
            border-radius: 0.75rem;
        }

        .date-input {
            padding: 0.625rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: var(--text);
            background: var(--bg-card);
            transition: all 0.2s ease;
            outline: none;
            width: 150px;
        }
        
        .date-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        .date-separator {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
        }
        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            width: fit-content;
        }

        .stat-trend.up {
            background-color: rgba(34, 197, 94, 0.1);
            color: var(--success);
        }
        
        .stat-trend.down {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        /* Modern Stats Styling */
        .stat-card {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            background: var(--bg-card);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px var(--shadow);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.success {
            background: var(--success);
        }

        .stat-icon.warning {
            background: var(--error);
        }

        .stat-info {
            flex: 1;
        }

        .stat-chart.mini {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            opacity: 0.2;
            pointer-events: none;
        }

        .stat-card.highlight {
            grid-column: span 2;
        }

        /* Chart Improvements */
        .chart-card {
            position: relative;
            overflow: hidden;
            padding-top: 2rem;
        }

        .chart-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card);
            z-index: 1;
        }

        .chart-header h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
        }

        .chart-content {
            padding-top: 1rem;
        }

        /* Date Picker Styling */
        .date-picker {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .date-field {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .date-field label {
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .text-light {
            color: var(--text-light);
            margin: 0;
            font-size: 0.875rem;
        }

        /* Chart Legend */
        .chart-legend {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            padding: 0.5rem;
            background: var(--bg-main);
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .export-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 40px;
        }

        .btn i {
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background-color: rgba(37, 99, 235, 0.05);
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
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            cursor: pointer;
            background: white;
            color: var(--text);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .class-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .class-btn:hover:not(.active) {
            background: #f8fafc;
            border-color: var(--primary);
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .export-buttons {
                flex-wrap: wrap;
            }
            
            .date-range {
                flex-wrap: wrap;
            }
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        .table th {
            background-color: #f8fafc;
            font-weight: 500;
            color: var(--text);
        }
        
        .table tr:hover {
            background-color: #f8fafc;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .status.present {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status.absent {
            background-color: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-section">
                <h1><i class="fas fa-fingerprint"></i> Rural Attendance</h1>
                <p>Reports</p>
            </div>
            <nav class="sidebar-nav">
                <a href="main_new.php" class="nav-item">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-users"></i> Students
                </a>
                <a href="reports.php" class="nav-item active">
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
                <div class="top-header">
                    <div class="header-content">
                        <h2>Reports</h2>
                        <p class="text-light">Track and analyze attendance patterns</p>
                    </div>
                    <div class="header-actions">
                        <div class="date-filter">
                            <div class="date-inputs">
                                <input type="date" class="date-input" id="startDate" placeholder="From">
                                <span class="date-separator">to</span>
                                <input type="date" class="date-input" id="endDate" placeholder="To">
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-primary" onclick="generateReport()">
                                    <i class="fas fa-sync"></i>
                                    Generate
                                </button>
                                <button class="btn btn-outline">
                                    <i class="fas fa-file-pdf"></i>
                                    Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Attendance</div>
                    <div class="stat-value">92%</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        5% from last week
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Present Today</div>
                    <div class="stat-value">45</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        3 more than yesterday
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Absent Today</div>
                    <div class="stat-value">5</div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i>
                        2 less than yesterday
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="chart-grid">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Monthly Attendance Trends</h3>
                    </div>
                    <div class="chart-content">
                        <canvas id="attendanceTrend"></canvas>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background: #2563eb"></div>
                                <span>Present</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: #ef4444"></div>
                                <span>Absent</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Class-wise Distribution</h3>
                    </div>
                    <div class="chart-content">
                        <canvas id="classDistribution"></canvas>
                    </div>
                </div>
            </div>

            <!-- Class Filter -->
            <div class="class-buttons">
                <button class="class-tab active">All Classes</button>
                <button class="class-tab">Class 5</button>
                <button class="class-tab">Class 6</button>
                <button class="class-tab">Class 7</button>
                <button class="class-tab">Class 8</button>
            </div>
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
    <script src="assets/js/darkmode.js"></script>
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