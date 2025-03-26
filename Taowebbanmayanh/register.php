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

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $name = $_POST['name'] ?? '';
   $email = $_POST['email'] ?? '';
   $password = $_POST['password'] ?? '';
   $confirm_password = $_POST['confirm_password'] ?? '';
   $terms = isset($_POST['terms']) ? true : false;
   
   if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
       $error = 'Vui lòng nhập đầy đủ thông tin';
   } elseif ($password !== $confirm_password) {
       $error = 'Mật khẩu xác nhận không khớp';
   } elseif (strlen($password) < 6) {
       $error = 'Mật khẩu phải có ít nhất 6 ký tự';
   } elseif (!$terms) {
       $error = 'Bạn phải đồng ý với Điều khoản dịch vụ và Chính sách bảo mật';
   } else {
       $result = registerUser($name, $email, $password);
       
       if ($result['success']) {
           $success = 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.';
           
           // Tự động đăng nhập sau khi đăng ký
           $_SESSION['user_id'] = $result['user_id'];
           $_SESSION['user_name'] = $name;
           $_SESSION['user_email'] = $email;
           
           // Chuyển hướng về trang chủ
           header('Location: index.php');
           exit;
       } else {
           $error = $result['message'];
       }
   }
}

// Xử lý đăng ký bằng Facebook
if (isset($_GET['facebook_register']) && $_GET['facebook_register'] == 'success') {
   // Trong thực tế, bạn sẽ xử lý callback từ Facebook SDK
   // Ở đây chúng ta giả lập đăng ký thành công
   $_SESSION['user_id'] = 999;
   $_SESSION['user_name'] = 'Facebook User';
   $_SESSION['user_email'] = 'facebook_user@example.com';
   
   // Chuyển hướng về trang chủ
   header('Location: index.php');
   exit;
}

// Xử lý đăng ký bằng Google
if (isset($_GET['google_register']) && $_GET['google_register'] == 'success') {
   // Trong thực tế, bạn sẽ xử lý callback từ Google API
   // Ở đây chúng ta giả lập đăng ký thành công
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
    <title>Đăng ký - VJShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="dangky.css">
</head>
<body>
    <!-- Background shapes -->
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Back to home button -->
    <div class="back-to-home">
        <a href="index.php"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
    </div>

    <div class="register-container">
        <div class="register-header">
            <h1>Đăng ký tài khoản</h1>
            <p>Tạo tài khoản để mua sắm dễ dàng hơn</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger shake">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        </div>
        <?php endif; ?>
        
        <form class="register-form" method="POST" action="">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" required>
                <i class="fas fa-user input-icon"></i>
            </div>
            
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
            
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <i class="fas fa-lock input-icon"></i>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Tôi đồng ý với <a href="terms.php">Điều khoản dịch vụ</a> và <a href="privacy.php">Chính sách bảo mật</a></label>
            </div>
            
            <button type="submit" class="register-btn">Đăng ký</button>
        </form>
        
        <div class="register-divider">
            <span>Hoặc đăng ký với</span>
        </div>
        
        <div class="social-register">
            <button class="social-btn facebook" id="facebook-register-btn">
                <i class="fab fa-facebook-f"></i>
                <span>Đăng ký với Facebook</span>
            </button>
            
            <button class="social-btn google" id="google-register-btn">
                <i class="fab fa-google"></i>
                <span>Đăng ký với Google</span>
            </button>
        </div>
        
        <div class="register-footer">
            Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Facebook Register
        const fbRegisterBtn = document.getElementById('facebook-register-btn');
        if (fbRegisterBtn) {
            fbRegisterBtn.addEventListener('click', function() {
                // Hiệu ứng khi nhấn nút
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 200);
                
                // Trong thực tế, bạn sẽ sử dụng Facebook SDK
                // Ở đây chúng ta giả lập đăng ký thành công
                setTimeout(() => {
                    window.location.href = 'register.php?facebook_register=success';
                }, 500);
            });
        }
        
        // Google Register
        const googleRegisterBtn = document.getElementById('google-register-btn');
        if (googleRegisterBtn) {
            googleRegisterBtn.addEventListener('click', function() {
                // Hiệu ứng khi nhấn nút
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 200);
                
                // Trong thực tế, bạn sẽ sử dụng Google API
                // Ở đây chúng ta giả lập đăng ký thành công
                setTimeout(() => {
                    window.location.href = 'register.php?google_register=success';
                }, 500);
            });
        }
        
        // Hiệu ứng hiển thị/ẩn mật khẩu
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            const icon = input.nextElementSibling;
            if (icon) {
                icon.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-lock');
                    this.classList.toggle('fa-unlock');
                });
            }
        });
        
        // Hiệu ứng khi nhấn nút đăng ký
        const registerBtn = document.querySelector('.register-btn');
        if (registerBtn) {
            registerBtn.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            registerBtn.addEventListener('mouseup', function() {
                this.style.transform = '';
            });
            
            registerBtn.addEventListener('mouseleave', function() {
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
        
        // Kiểm tra mật khẩu khớp nhau
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        if (password && confirmPassword) {
            confirmPassword.addEventListener('input', function() {
                if (this.value !== password.value) {
                    this.setCustomValidity('Mật khẩu không khớp');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            password.addEventListener('input', function() {
                if (confirmPassword.value !== '' && confirmPassword.value !== this.value) {
                    confirmPassword.setCustomValidity('Mật khẩu không khớp');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            });
        }
        
        // Hiệu ứng ripple cho nút
        const buttons = document.querySelectorAll('.register-btn, .social-btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
    </script>
</body>
</html>

