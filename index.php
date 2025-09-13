<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Attendance System - Smart Attendance for Rural Schools</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js for statistics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Landing Page Specific Styles */
        .hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 6rem 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features {
            padding: 4rem 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .footer {
            background: #f9fafb;
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container flex items-center justify-between">
            <div class="logo">
                <i class="fas fa-fingerprint"></i>
                Rural Attendance
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php" class="btn btn-primary">Login</a></li>
                    <li><a href="signup.php" class="btn btn-secondary">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Smart Attendance System for Rural Schools</h1>
            <p>An innovative, offline-first biometric attendance solution designed specifically for rural educational institutions</p>
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-secondary">Get Started</a>
                <a href="signup.php" class="btn btn-primary">Create Account</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2 class="text-center mb-4">Why Choose Our System?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Eliminates Manual Entry</h3>
                    <p>No more paper registers. Automated attendance tracking saves time and reduces errors.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h3>Biometric Accuracy</h3>
                    <p>Secure and accurate attendance with fingerprint authentication.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Real-time Alerts</h3>
                    <p>Instant SMS notifications to parents about their child's attendance.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics Dashboard</h3>
                    <p>Comprehensive reports and insights for better decision making.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features" style="background: #f9fafb;">
        <div class="container">
            <h2 class="text-center mb-4">Innovation Highlights</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wifi-slash"></i>
                    </div>
                    <h3>Offline First</h3>
                    <p>Works seamlessly without internet connection.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3>Aadhaar Integration</h3>
                    <p>Secure and compliant with Aadhaar authentication.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-battery-full"></i>
                    </div>
                    <h3>Battery Backup</h3>
                    <p>Continues working during power outages.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3>Vernacular Support</h3>
                    <p>Available in multiple regional languages.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>© 2023 Rural Attendance System. All rights reserved.</p>
            <div class="mt-4">
                <a href="https://github.com/yourusername/attendence-system" target="_blank" class="btn btn-primary">
                    <i class="fab fa-github"></i> View on GitHub
                </a>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>