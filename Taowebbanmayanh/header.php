<?php
// Kiểm tra đăng nhập
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VJShop - Cửa hàng Máy Ảnh & Laptop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <!-- Facebook Login SDK -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <!-- Google Login API -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span>VJShop</span>
                    </a>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>
                <div class="user-actions">
                    <?php if ($is_logged_in): ?>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span><?php echo $user_name; ?></span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="profile.php">Tài khoản của tôi</a>
                            <a href="orders.php">Đơn hàng</a>
                            <a href="wishlist.php">Sản phẩm yêu thích</a>
                            <a href="logout.php">Đăng xuất</a>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="login.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Đăng nhập</span>
                    </a>
                    <?php endif; ?>
                    <a href="cart.php" class="cart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>Giỏ hàng</span>
                        <span id="cart-count" class="cart-count"><?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?></span>
                    </a>
                </div>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && empty($_GET['category']) ? 'active' : ''; ?>">Trang chủ</a></li>
                    <li><a href="index.php?category=camera" class="<?php echo isset($_GET['category']) && $_GET['category'] == 'camera' ? 'active' : ''; ?>">Máy Ảnh</a></li>
                    <li><a href="index.php?category=lens" class="<?php echo isset($_GET['category']) && $_GET['category'] == 'lens' ? 'active' : ''; ?>">Ống Kính</a></li>
                    <li><a href="index.php?category=laptop" class="<?php echo isset($_GET['category']) && $_GET['category'] == 'laptop' ? 'active' : ''; ?>">Laptop</a></li>
                    <li><a href="index.php?category=accessory" class="<?php echo isset($_GET['category']) && $_GET['category'] == 'accessory' ? 'active' : ''; ?>">Phụ Kiện</a></li>
                    <li><a href="promotion.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'promotion.php' ? 'active' : ''; ?>">Khuyến Mãi</a></li>
                    <li><a href="news.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'news.php' ? 'active' : ''; ?>">Tin Tức</a></li>
                    <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Liên Hệ</a></li>
                    <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">Về VJShop</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>


