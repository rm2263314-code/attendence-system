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
    <title>Settings - Rural Attendance System</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .settings-section h3 {
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-label {
            display: flex;
            flex-direction: column;
        }

        .setting-label span {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Toggle Switch */
        .toggle {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Select styles */
        .setting-select {
            padding: 0.5rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            outline: none;
            min-width: 200px;
        }

        /* Theme Preview */
        .theme-preview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .theme-option {
            border: 2px solid transparent;
            border-radius: 0.5rem;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-option.active {
            border-color: var(--primary);
        }

        .theme-color {
            height: 80px;
        }

        .theme-label {
            padding: 0.5rem;
            text-align: center;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .setting-row {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .setting-select {
                width: 100%;
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
                <a href="reports.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
                <a href="settings.php" class="nav-item active">
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
                <h2>Settings</h2>
                <button class="btn btn-primary" onclick="saveSettings()">Save Changes</button>
            </div>

            <!-- General Settings -->
            <div class="settings-section">
                <h3>General Settings</h3>
                
                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Language</strong>
                        <span>Choose your preferred language</span>
                    </div>
                    <select class="setting-select" id="language">
                        <option value="en">English</option>
                        <option value="hi">हिंदी (Hindi)</option>
                        <option value="mr">मराठी (Marathi)</option>
                        <option value="gu">ગુજરાતી (Gujarati)</option>
                        <option value="ta">தமிழ் (Tamil)</option>
                    </select>
                </div>

                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Dark Mode</strong>
                        <span>Switch between light and dark theme</span>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="darkMode">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="settings-section">
                <h3>Notification Settings</h3>
                
                <div class="setting-row">
                    <div class="setting-label">
                        <strong>SMS Alerts</strong>
                        <span>Send SMS alerts to parents for absent students</span>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="smsAlerts" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Alert Time</strong>
                        <span>Set time for sending absence alerts</span>
                    </div>
                    <select class="setting-select" id="alertTime">
                        <option value="0900">9:00 AM</option>
                        <option value="1000">10:00 AM</option>
                        <option value="1100">11:00 AM</option>
                        <option value="1200">12:00 PM</option>
                    </select>
                </div>
            </div>

            <!-- System Settings -->
            <div class="settings-section">
                <h3>System Settings</h3>
                
                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Offline Mode</strong>
                        <span>Enable offline data storage and sync</span>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="offlineMode" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Auto Backup</strong>
                        <span>Automatically backup data every day</span>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="autoBackup" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Data Retention</strong>
                        <span>How long to keep attendance records</span>
                    </div>
                    <select class="setting-select" id="dataRetention">
                        <option value="1">1 Year</option>
                        <option value="2">2 Years</option>
                        <option value="3">3 Years</option>
                        <option value="5">5 Years</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Save settings function
        function saveSettings() {
            // Collect all settings
            const settings = {
                language: document.getElementById('language').value,
                darkMode: document.getElementById('darkMode').checked,
                smsAlerts: document.getElementById('smsAlerts').checked,
                alertTime: document.getElementById('alertTime').value,
                offlineMode: document.getElementById('offlineMode').checked,
                autoBackup: document.getElementById('autoBackup').checked,
                dataRetention: document.getElementById('dataRetention').value
            };

            // Show success message
            alert('Settings saved successfully!');
            // In a real application, you would save these to the database
        }

        // Dark mode toggle
        document.getElementById('darkMode').addEventListener('change', function(e) {
            document.body.classList.toggle('dark-mode');
            // In a real application, you would persist this preference
        });

        // Load saved settings
        function loadSettings() {
            // In a real application, you would load these from the database
            // This is just for demonstration
            document.getElementById('language').value = 'en';
            document.getElementById('darkMode').checked = false;
            document.getElementById('smsAlerts').checked = true;
            document.getElementById('alertTime').value = '0900';
            document.getElementById('offlineMode').checked = true;
            document.getElementById('autoBackup').checked = true;
            document.getElementById('dataRetention').value = '1';
        }

        // Initialize settings on page load
        loadSettings();
    </script>
</body>
</html>