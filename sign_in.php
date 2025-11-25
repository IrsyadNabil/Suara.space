<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validasi input kosong
    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi";
    } else {
        // Query untuk cek user
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                header("Location: loading_screen.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Email tidak ditemukan!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        /* CSS yang sama seperti sebelumnya */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: url('backgroundsign.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            padding: 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 20px;
            font-weight: 600;
            text-decoration: none;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #1a1a2e;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .header-link:hover {
            color: white;
        }

        .header-link.btn {
            color: white;
            font-weight: 600;
        }

        /* Auth Container */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .auth-box {
            background: rgba(30, 30, 45, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 50px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-box h2 {
            color: white;
            text-align: center;
            margin-bottom: 35px;
            font-size: 28px;
            font-weight: 600;
        }

        /* Error Message */
        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(167, 139, 250, 0.5);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
        }

        .toggle-password:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: white;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 15px;
            background: white;
            color: #1a1a2e;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 25px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        /* Divider */
        .divider {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            margin: 30px 0 25px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        /* Social Buttons */
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-social {
            padding: 14px;
            background: rgba(50, 55, 70, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .btn-social:hover {
            background: rgba(60, 65, 80, 0.7);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn-social svg {
            width: 20px;
            height: 20px;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .header {
                padding: 20px;
            }

            .auth-box {
                padding: 35px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="logo">
            <div class="logo-icon">S</div>
            Suara.Space
        </a>
        <div class="header-right">
            <span class="header-link">Don't have an account?</span>
            <a href="sign_up.php" class="header-link btn">SIGN UP</a>
        </div>
    </div>

    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h2>Sign In</h2>
                
                <?php if(isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form id="signinForm" method="POST" action="">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
                        </div>
                    </div>
                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-primary">SIGN IN</button>
                </form>
                
                <div class="divider">OR SIGN IN WITH</div>
                
                <div class="social-buttons">
                    <div class="social-row">
                        <button class="btn-social" onclick="loginWithApple()">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                            </svg>
                        </button>
                        <button class="btn-social" onclick="loginWithFacebook()">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function loginWithApple() {
            alert('Login with Apple - Hubungkan dengan Apple OAuth API');
        }

        function loginWithFacebook() {
            alert('Login with Facebook - Hubungkan dengan Facebook OAuth API');
        }
    </script>
</body>
</html>