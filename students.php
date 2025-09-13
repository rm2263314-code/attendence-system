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
    <title>Students - Rural Attendance System</title>
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
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }
        .nav-item i {
            margin-right: 1rem;
            font-size: 1.25rem;
            width: 1.5rem;
            text-align: center;
        }
        .nav-item:hover {
            background: #f3f4f6;
        }
        .nav-item.active {
            background: var(--primary);
            color: white;
        }
        .mt-auto {
            margin-top: auto;
        }
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f3f4f6;
        }
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .top-header h2 {
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--text);
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-primary i {
            margin-right: 0.5rem;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        .class-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }
        .class-tab {
            padding: 0.75rem 1.5rem;
            background: white;
            border-radius: 0.5rem;
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            border: 1px solid var(--border);
        }
        .class-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .class-tab:hover:not(.active) {
            background: #f3f4f6;
        }
        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .student-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px -2px rgba(0, 0, 0, 0.15), 0 3px 6px -2px rgba(0, 0, 0, 0.1);
        }
        .student-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .student-info h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.25rem;
            margin: 0;
            font-size: 1.1rem;
        }

        .student-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .attendance-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            margin: 1.25rem 0;
            overflow: hidden;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .attendance-progress {
            height: 100%;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .student-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-icon {
            padding: 0.625rem;
            border-radius: 0.5rem;
            background: #f3f4f6;
            border: 1px solid var(--border);
            cursor: pointer;
            color: var(--text);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon i {
            font-size: 1.125rem;
        }

        .btn-icon:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .attendance-text {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 500px;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .filter-item {
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            cursor: pointer;
        }

        .filter-item.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .filters {
                flex-wrap: wrap;
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
                <p>Students</p>
            </div>
            <nav class="sidebar-nav">
                <a href="main_new.php" class="nav-item">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="students.php" class="nav-item active">
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
            <div class="top-header">
                <div class="mobile-menu">
                    <i class="fas fa-bars" onclick="toggleSidebar()"></i>
                </div>
                <h2>Student Management</h2>
                <button class="btn btn-primary" onclick="showAddStudentModal()">
                    <i class="fas fa-plus"></i> Add Student
                </button>
            </div>

            <!-- Filters -->
            <div class="filters">
                <div class="filter-item active">All Classes</div>
                <div class="filter-item">Class 5</div>
                <div class="filter-item">Class 6</div>
                <div class="filter-item">Class 7</div>
                <div class="filter-item">Class 8</div>
            </div>

            <!-- Search -->
            <div class="search-box" style="width: 100%; max-width: 400px; margin-bottom: 1.5rem;">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search students..." id="searchStudents">
            </div>

            <!-- Student Grid -->
            <div class="student-grid">
                <!-- Sample Student Cards -->
                <div class="student-card">
                    <div class="student-header">
                        <div class="student-avatar">RK</div>
                        <div class="student-info">
                            <h3>Rahul Kumar</h3>
                            <p>Class 5A • Roll No: 001</p>
                        </div>
                    </div>
                    <div class="attendance-stats">
                        <div class="flex justify-between">
                            <span>Attendance</span>
                            <span>95%</span>
                        </div>
                        <div class="attendance-bar">
                            <div class="attendance-progress" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="student-actions">
                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <!-- More student cards will be dynamically added -->
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal" id="addStudentModal">
        <div class="modal-content">
            <h2>Add New Student</h2>
            <form id="addStudentForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Class</label>
                    <select class="form-control" required>
                        <option value="">Select Class</option>
                        <option value="5A">Class 5A</option>
                        <option value="5B">Class 5B</option>
                        <option value="6A">Class 6A</option>
                        <option value="6B">Class 6B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Roll Number</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Parent's Contact</label>
                    <input type="tel" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddStudentModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/darkmode.js"></script>
    <script>
        // Modal Functions
        function showAddStudentModal() {
            document.getElementById('addStudentModal').classList.add('active');
        }

        function hideAddStudentModal() {
            document.getElementById('addStudentModal').classList.remove('active');
        }

        // Filter functionality
        const filters = document.querySelectorAll('.filter-item');
        filters.forEach(filter => {
            filter.addEventListener('click', () => {
                filters.forEach(f => f.classList.remove('active'));
                filter.classList.add('active');
                // Add filtering logic here
            });
        });

        // Search functionality
        document.getElementById('searchStudents').addEventListener('keyup', function(e) {
            const searchText = e.target.value.toLowerCase();
            const studentCards = document.querySelectorAll('.student-card');
            
            studentCards.forEach(card => {
                const studentName = card.querySelector('.student-info h3').textContent.toLowerCase();
                const studentClass = card.querySelector('.student-info p').textContent.toLowerCase();
                
                if (studentName.includes(searchText) || studentClass.includes(searchText)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>