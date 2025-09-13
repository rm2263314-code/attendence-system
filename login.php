<?php
session_start();

$host = "localhost";
$user = "root";      
$pass = "";          
$db   = "myadmit";   

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_no = $_POST['id_no'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE id_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_no'] = $row['id_no'];
            header("Location: main.php"); // ✅ Redirect to main page
            exit();
        } else {
            $msg = "<div class='alert alert-danger text-center'>❌ Invalid Password</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger text-center'>❌ ID Not Found</div>";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Attendance System - Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-section i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .logo-section h1 {
            font-size: 1.5rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .logo-section p {
            color: var(--text-light);
        }
    </style>
</head>
<body>
    <div class="login-card fade-in">
        <div class="logo-section">
            <i class="fas fa-fingerprint"></i>
            <h1>Welcome Back</h1>
            <p>Log in to your account</p>
        </div>

        <?php echo $msg; ?>

        <form method="post" action="">
            <div class="form-group">
                <i class="fas fa-id-card form-icon"></i>
                <input type="text" class="form-control" name="id_no" placeholder="Enter ID Number" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock form-icon"></i>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                <span class="password-toggle" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-primary w-full mb-4">Login</button>
            
            <p class="text-center">
                Don't have an account? 
                <a href="signup.php" style="color: var(--primary); text-decoration: none;">Sign up</a>
            </p>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Initialize password toggle
        togglePassword('password', 'togglePassword');
    </script>
</body>
</html>