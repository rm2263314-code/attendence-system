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
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --success: #22c55e;
            --error: #ef4444;
            --text: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
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
        .settings-section {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .stat-card, .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: white;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-secondary:hover {
            background-color: #f3f4f6;
        }
        
        .settings-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 1.5rem;
        }
        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }
        .setting-item:last-child {
            border-bottom: none;
        }
        .setting-label {
            flex: 1;
        }
        .setting-label h4 {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text);
            margin: 0;
        }
        .setting-label p {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--border);
            transition: .4s;
            border-radius: 24px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .toggle-slider {
            background-color: var(--primary);
        }
        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .settings-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .settings-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
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
        .setting-label h4 {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text);
            margin: 0;
        }
        .setting-label span {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .settings-action {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
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
            <div class="logo-section">
                <h1><i class="fas fa-fingerprint"></i> Rural Attendance</h1>
                <p>Settings</p>
            </div>
            <nav class="sidebar-nav">
                <a href="main_new.php" class="nav-item">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-users"></i> Students
                </a>
                <a href="reports.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
                <a href="settings.php" class="nav-item active">
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
                    <h2>Settings</h2>
                </div>
            </div>

            <div class="settings-grid">
                <div class="settings-card">
                    <h3>General Settings</h3>
                    
                    <div class="setting-row">
                        <div class="setting-label">
                            <h4>Language</h4>
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
                            <h4>Time Zone</h4>
                            <span>Set your local time zone</span>
                        </div>
                        <select class="setting-select">
                            <option value="IST">(GMT+5:30) India Standard Time</option>
                            <option value="UTC">UTC - Coordinated Universal Time</option>
                        </select>
                    </div>

                    <div class="settings-action">
                        <button class="btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
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

            <!-- Appearance Settings -->
            <div class="settings-section">
                <h3>Appearance</h3>
                
                <div class="setting-row">
                    <div class="setting-label">
                        <strong>Dark Mode</strong>
                        <span>Switch between light and dark themes</span>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="darkMode" onchange="toggleDarkMode(this.checked)">
                        <span class="slider"></span>
                    </label>
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
        // Dark mode functionality
        function toggleDarkMode(enabled) {
            document.body.classList.toggle('dark-mode', enabled);
            localStorage.setItem('darkMode', enabled ? 'enabled' : 'disabled');
            
            // Dispatch event for other pages to listen to
            const event = new CustomEvent('darkModeChanged', {
                detail: { isDark: enabled }
            });
            document.dispatchEvent(event);
        }

        // Initialize dark mode
        function initDarkMode() {
            const darkMode = localStorage.getItem('darkMode') === 'enabled';
            document.getElementById('darkMode').checked = darkMode;
            toggleDarkMode(darkMode);
        }

        // Initialize settings on page load
        initDarkMode();

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