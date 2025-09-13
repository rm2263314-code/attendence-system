<?php
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
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $msg = "<div class='alert alert-danger text-center'>❌ Passwords do not match!</div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (id_no, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $id_no, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php"); // ✅ Redirect to login after signup
            exit();
        } else {
            $msg = "<div class='alert alert-danger text-center'>⚠ Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Attendance System - Sign Up</title>
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

        .signup-card {
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
    <div class="signup-card fade-in">
        <div class="logo-section">
            <i class="fas fa-user-plus"></i>
            <h1>Create Account</h1>
            <p>Join our attendance system</p>
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

            <div class="form-group">
                <i class="fas fa-lock form-icon"></i>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <span class="password-toggle" id="toggleConfirmPassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-primary w-full mb-4">Create Account</button>
            
            <p class="text-center">
                Already have an account? 
                <a href="login.php" style="color: var(--primary); text-decoration: none;">Log in</a>
            </p>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Initialize password toggles
        togglePassword('password', 'togglePassword');
        togglePassword('confirm_password', 'toggleConfirmPassword');
    </script>
</body>
</html>