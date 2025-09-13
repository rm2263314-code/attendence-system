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
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            text-decoration: none;
            color: var(--light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(5px);
        }

        .footer-links i {
            width: 20px;
            color: var(--primary);
        }

        .impact-item i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        footer {
            background: black;
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
    <header>
        <nav>
            <div class="logo">
                <i class="fas fa-fingerprint"></i>
                <span>RuralAttendance</span>
            </div>
            <ul class="nav-links">
                <li><a href="#solution">Solution</a></li>
                <li><a href="#technology">Technology</a></li>
                <li><a href="#impact">Impact</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Automated Attendance System for Rural Schools</h1>
            <p>A low-cost, offline-first, Aadhaar-based biometric attendance system designed specifically for the challenges of rural Indian schools</p>
            <div class="cta-buttons">
                <a href="signup.php" class="btn btn-secondary">Get Started</a>
                <a href="login.php" class="btn btn-primary">Login</a>
            </div>
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
                <p><i class="fas fa-phone"></i> +91 9123792435</p>
                <p><i class="fas fa-map-marker-alt"></i> Kolkata, India</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li>
                        <a href="login.php">
                            <i class="fas fa-sign-in-alt"></i>
                            Login Portal
                        </a>
                    </li>
                    <li>
                        <a href="signup.php">
                            <i class="fas fa-user-plus"></i>
                            Register School
                        </a>
                    </li>
                    <li>
                        <a href="#solution">
                            <i class="fas fa-lightbulb"></i>
                            Our Solution
                        </a>
                    </li>
                    <li>
                        <a href="#technology">
                            <i class="fas fa-microchip"></i>
                            Technology
                        </a>
                    </li>
                    <li>
                        <a href="#impact">
                            <i class="fas fa-chart-line"></i>
                            Impact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 RuralAttendance. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>