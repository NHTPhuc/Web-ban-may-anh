<?php
session_start();
require_once 'database.php';

// Nếu đã đăng nhập, chuyển hướng về trang chủ
if (isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit;
}

$error = '';
$success = '';

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = $_POST['email'] ?? '';
   $password = $_POST['password'] ?? '';
   
   if (empty($email) || empty($password)) {
       $error = 'Vui lòng nhập đầy đủ thông tin';
   } else {
       $result = loginUser($email, $password);
       
       if ($result['success']) {
           // Lưu thông tin đăng nhập vào session
           $_SESSION['user_id'] = $result['user']['id'];
           $_SESSION['user_name'] = $result['user']['name'];
           $_SESSION['user_email'] = $result['user']['email'];
           
           // Chuyển hướng về trang chủ
           header('Location: index.php');
           exit;
       } else {
           $error = $result['message'];
       }
   }
}

// Xử lý đăng nhập bằng Facebook
if (isset($_GET['facebook_login']) && $_GET['facebook_login'] == 'success') {
   // Trong thực tế, bạn sẽ xử lý callback từ Facebook SDK
   // Ở đây chúng ta giả lập đăng nhập thành công
   $_SESSION['user_id'] = 999;
   $_SESSION['user_name'] = 'Facebook User';
   $_SESSION['user_email'] = 'facebook_user@example.com';
   
   // Chuyển hướng về trang chủ
   header('Location: index.php');
   exit;
}

// Xử lý đăng nhập bằng Google
if (isset($_GET['google_login']) && $_GET['google_login'] == 'success') {
   // Trong thực tế, bạn sẽ xử lý callback từ Google API
   // Ở đây chúng ta giả lập đăng nhập thành công
   $_SESSION['user_id'] = 998;
   $_SESSION['user_name'] = 'Google User';
   $_SESSION['user_email'] = 'google_user@example.com';
   
   // Chuyển hướng về trang chủ
   header('Location: index.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - VJShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="dangnhap.css">
</head>
<body>
    <!-- Particles background -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="back-to-home">
        <a href="index.php"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h1>Đăng nhập</h1>
            <p>Vui lòng đăng nhập để tiếp tục</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger shake">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
        <?php endif; ?>
        
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <i class="fas fa-envelope input-icon"></i>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
                <i class="fas fa-lock input-icon"></i>
            </div>
            
            <div class="checkbox-group">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ghi nhớ đăng nhập</label>
                </div>
                <a href="forgot-password.php" class="forgot-password">Quên mật khẩu?</a>
            </div>
            
            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>
        
        <div class="login-divider">
            <span>Hoặc đăng nhập với</span>
        </div>
        
        <div class="social-login">
            <button class="social-btn facebook" id="facebook-login-btn">
                <i class="fab fa-facebook-f"></i>
                <span>Đăng nhập với Facebook</span>
            </button>
            
            <button class="social-btn google" id="google-login-btn">
                <i class="fab fa-google"></i>
                <span>Đăng nhập với Google</span>
            </button>
        </div>
        
        <div class="login-footer">
            Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Facebook Login
        const fbLoginBtn = document.getElementById('facebook-login-btn');
        if (fbLoginBtn) {
            fbLoginBtn.addEventListener('click', function() {
                // Hiệu ứng khi nhấn nút
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 200);
                
                // Trong thực tế, bạn sẽ sử dụng Facebook SDK
                // Ở đây chúng ta giả lập đăng nhập thành công
                setTimeout(() => {
                    window.location.href = 'login.php?facebook_login=success';
                }, 500);
            });
        }
        
        // Google Login
        const googleLoginBtn = document.getElementById('google-login-btn');
        if (googleLoginBtn) {
            googleLoginBtn.addEventListener('click', function() {
                // Hiệu ứng khi nhấn nút
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 200);
                
                // Trong thực tế, bạn sẽ sử dụng Google API
                // Ở đây chúng ta giả lập đăng nhập thành công
                setTimeout(() => {
                    window.location.href = 'login.php?google_login=success';
                }, 500);
            });
        }
        
        // Hiệu ứng hiển thị/ẩn mật khẩu
        const passwordInput = document.getElementById('password');
        const passwordIcon = passwordInput.nextElementSibling;
        
        if (passwordIcon) {
            passwordIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-lock');
                this.classList.toggle('fa-unlock');
            });
        }
        
        // Hiệu ứng khi nhấn nút đăng nhập
        const loginBtn = document.querySelector('.login-btn');
        if (loginBtn) {
            loginBtn.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            loginBtn.addEventListener('mouseup', function() {
                this.style.transform = '';
            });
            
            loginBtn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        }
        
        // Hiệu ứng cho input khi focus
        const inputs = document.querySelectorAll('.form-group input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
    </script>
</body>
</html>

