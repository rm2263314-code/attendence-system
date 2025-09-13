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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
            font-weight: bold;
        }

        .student-info h3 {
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
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            margin: 1rem 0;
            overflow: hidden;
        }

        .attendance-progress {
            height: 100%;
            background: var(--primary);
            border-radius: 3px;
        }

        .student-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            padding: 0.5rem;
            border-radius: 0.5rem;
            background: #f3f4f6;
            border: none;
            cursor: pointer;
            color: var(--text);
        }

        .btn-icon:hover {
            background: #e5e7eb;
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
            <div class="sidebar-header">
                <i class="fas fa-fingerprint"></i>
                <h2>Rural Attendance</h2>
            </div>
            
            <nav>
                <a href="main.php" class="nav-item">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="students.php" class="nav-item active">
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