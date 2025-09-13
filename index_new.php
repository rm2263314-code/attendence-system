<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Attendance System - Smart Attendance for Rural Schools</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Landing Page Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .header {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
        }
        .logo h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .flex {
            display: flex;
        }
        .items-center {
            align-items: center;
        }
        .justify-between {
            justify-content: space-between;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-secondary {
            background: #f3f4f6;
            color: var(--text);
        }
        .hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8rem 0 6rem;
            text-align: center;
            margin-top: 4rem;
        }
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .section {
            padding: 6rem 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--text);
            margin-bottom: 1rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        footer {
            background: #1a1a1a;
            color: white;
            padding: 4rem 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container flex items-center justify-between">
            <div class="logo">
                <h1><i class="fas fa-fingerprint"></i> Rural Attendance</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#solution">Solution</a></li>
                    <li><a href="#technology">Technology</a></li>
                    <li><a href="#impact">Impact</a></li>
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
            <p>Transform attendance tracking with our modern, efficient, and secure biometric system.</p>
            <div class="cta-buttons">
                <a href="signup.php" class="btn btn-secondary">Get Started</a>
                <a href="#features" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </section>

    <section id="features" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Our System?</h2>
                <p>Discover the features that make our attendance system unique</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h3>Biometric Authentication</h3>
                    <p>Secure and accurate attendance tracking using modern biometric technology.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Real-time Analytics</h3>
                    <p>Monitor attendance patterns and generate insightful reports instantly.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Enhanced Security</h3>
                    <p>State-of-the-art security measures to protect sensitive data.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="solution" class="section" style="background: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>Our Solution</h2>
                <p>A comprehensive attendance management system designed for rural schools</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <h3>Rural-First Approach</h3>
                    <p>Specifically designed for the unique needs and challenges of rural educational institutions.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-sync"></i>
                    </div>
                    <h3>Easy Integration</h3>
                    <p>Seamlessly integrates with existing school management systems.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Friendly</h3>
                    <p>Access attendance data anywhere, anytime from any device.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="technology" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Technology</h2>
                <p>Built with cutting-edge technology for reliability and performance</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3>Advanced Biometrics</h3>
                    <p>Latest fingerprint scanning technology for accurate identification.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Secure Database</h3>
                    <p>Robust data storage with encryption and regular backups.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>Cloud Integration</h3>
                    <p>Optional cloud backup and synchronization features.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="impact" class="section" style="background: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>Impact</h2>
                <p>Making a difference in rural education</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Time Savings</h3>
                    <p>Reduce administrative workload by 75% with automated attendance.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3>Better Insights</h3>
                    <p>Comprehensive analytics to improve student attendance patterns.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community Benefits</h3>
                    <p>Strengthening rural education through technology adoption.</p>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="grid">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: contact@ruralattendance.com</p>
                    <p>Phone: 1-800-ATTEND</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#solution">Solution</a></li>
                        <li><a href="#technology">Technology</a></li>
                        <li><a href="#impact">Impact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>