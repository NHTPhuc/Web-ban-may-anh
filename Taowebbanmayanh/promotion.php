<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Lấy danh sách khuyến mãi
$promotions = [
    [
        'id' => 1,
        'title' => 'Siêu Sale Máy Ảnh - Giảm đến 30%',
        'description' => 'Chương trình khuyến mãi lớn nhất năm với nhiều ưu đãi hấp dẫn cho các dòng máy ảnh Sony, Canon, Nikon và phụ kiện.',
        'image' => '/placeholder.svg?height=300&width=600',
        'start_date' => '01/05/2025',
        'end_date' => '15/05/2025',
        'coupon_code' => 'CAMERA30',
        'discount' => '30%',
        'products' => [1, 2, 3, 4]
    ],
    [
        'id' => 2,
        'title' => 'Laptop Gaming - Quà tặng khủng',
        'description' => 'Mua laptop gaming nhận ngay bộ quà tặng trị giá lên đến 5 triệu đồng bao gồm: Balo gaming, chuột không dây, tai nghe và voucher mua phụ kiện.',
        'image' => '/placeholder.svg?height=300&width=600',
        'start_date' => '10/05/2025',
        'end_date' => '30/05/2025',
        'coupon_code' => 'GAMINGGIFT',
        'discount' => 'Quà tặng 5 triệu',
        'products' => [5, 7, 8]
    ],
    [
        'id' => 3,
        'title' => 'Ống kính - Giảm 20% + Trả góp 0%',
        'description' => 'Chương trình ưu ��ãi đặc biệt dành cho các dòng ống kính cao cấp. Giảm ngay 20% và trả góp 0% lãi suất trong 12 tháng.',
        'image' => '/placeholder.svg?height=300&width=600',
        'start_date' => '05/05/2025',
        'end_date' => '25/05/2025',
        'coupon_code' => 'LENS20',
        'discount' => '20% + Trả góp 0%',
        'products' => [9, 10]
    ],
    [
        'id' => 4,
        'title' => 'Sinh nhật VJShop - Giảm sốc toàn bộ sản phẩm',
        'description' => 'Nhân dịp sinh nhật VJShop, chúng tôi mang đến chương trình khuyến mãi đặc biệt với nhiều ưu đãi hấp dẫn trên toàn bộ sản phẩm.',
        'image' => '/placeholder.svg?height=300&width=600',
        'start_date' => '20/05/2025',
        'end_date' => '30/05/2025',
        'coupon_code' => 'BIRTHDAY25',
        'discount' => 'Giảm đến 25%',
        'products' => []
    ]
];

// Lấy chi tiết khuyến mãi nếu có id
$promotion_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_promotion = null;

if ($promotion_id > 0) {
    foreach ($promotions as $promo) {
        if ($promo['id'] == $promotion_id) {
            $current_promotion = $promo;
            break;
        }
    }
}
?>

<div class="container">
    <?php if ($current_promotion): ?>
    <!-- Chi tiết khuyến mãi -->
    <div class="promotion-detail fade-in">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &gt; 
            <a href="promotion.php">Khuyến mãi</a> &gt; 
            <span><?php echo $current_promotion['title']; ?></span>
        </div>
        
        <div class="promotion-banner">
            <img src="<?php echo $current_promotion['image']; ?>" alt="<?php echo $current_promotion['title']; ?>">
        </div>
        
        <div class="promotion-content">
            <h1><?php echo $current_promotion['title']; ?></h1>
            
            <div class="promotion-meta">
                <div class="promotion-period">
                    <i class="far fa-calendar-alt"></i> Thời gian: <?php echo $current_promotion['start_date']; ?> - <?php echo $current_promotion['end_date']; ?>
                </div>
                <div class="promotion-discount">
                    <i class="fas fa-tag"></i> Ưu đãi: <?php echo $current_promotion['discount']; ?>
                </div>
                <div class="promotion-code">
                    <i class="fas fa-ticket-alt"></i> Mã khuyến mãi: <span class="coupon-code"><?php echo $current_promotion['coupon_code']; ?></span>
                    <button class="copy-coupon" data-code="<?php echo $current_promotion['coupon_code']; ?>">Sao chép</button>
                </div>
            </div>
            
            <div class="promotion-description">
                <h2>Chi tiết chương trình</h2>
                <p><?php echo $current_promotion['description']; ?></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Sed vitae magna eu magna tincidunt consequat.</p>
                
                <h2>Điều kiện áp dụng</h2>
                <ul>
                    <li>Chương trình áp dụng cho tất cả khách hàng mua sắm tại VJShop</li>
                    <li>Mỗi khách hàng chỉ được sử dụng mã giảm giá 1 lần</li>
                    <li>Không áp dụng đồng thời với các chương trình khuyến mãi khác</li>
                    <li>VJShop có quyền thay đổi điều khoản chương trình mà không cần báo trước</li>
                    <li>Thời gian áp dụng: <?php echo $current_promotion['start_date']; ?> - <?php echo $current_promotion['end_date']; ?></li>
                </ul>
            </div>
            
            <?php if (!empty($current_promotion['products'])): ?>
            <div class="promotion-products">
                <h2>Sản phẩm áp dụng</h2>
                <div class="product-grid">
                    <?php 
                    $all_products = getSampleProducts();
                    foreach ($all_products as $product):
                        if (in_array($product['id'], $current_promotion['products'])):
                    ?>
                    <div class="product-card slide-up">
                        <?php if (isset($product['hot']) && $product['hot']): ?>
                        <div class="product-badge">SẢN PHẨM HOT</div>
                        <?php endif; ?>
                        <div class="promotion-badge">KHUYẾN MÃI</div>
                        
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                            <div class="product-image">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo $product['name']; ?></h3>
                                
                                <div class="product-price">
                                    <span class="current-price"><?php echo number_format($product['price']); ?> đ</span>
                                    <?php if (isset($product['old_price']) && $product['old_price'] > 0): ?>
                                    <span class="old-price"><?php echo number_format($product['old_price']); ?> đ</span>
                                    <span class="discount">-<?php echo number_format(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        
                        <div class="product-actions">
                            <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">Thêm vào giỏ</button>
                        </div>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="promotion-cta">
                <a href="index.php" class="btn-primary">Mua sắm ngay</a>
                <a href="promotion.php" class="btn-secondary">Xem thêm khuyến mãi khác</a>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Danh sách khuyến mãi -->
    <div class="promotions-page">
        <h1 class="page-title">Khuyến mãi</h1>
        
        <div class="promotions-banner">
            <img src="/placeholder.svg?height=400&width=1200" alt="Khuyến mãi VJShop">
            <div class="banner-content">
                <h2>Siêu khuyến mãi tháng 5</h2>
                <p>Hàng ngàn sản phẩm giảm giá sốc lên đến 50%</p>
                <a href="#promotions-list" class="btn-primary">Xem ngay</a>
            </div>
        </div>
        
        <div id="promotions-list" class="promotions-list">
            <?php foreach ($promotions as $index => $promotion): ?>
            <div class="promotion-card <?php echo $index % 2 == 0 ? 'fade-in' : 'slide-up'; ?>">
                <div class="promotion-image">
                    <img src="<?php echo $promotion['image']; ?>" alt="<?php echo $promotion['title']; ?>">
                </div>
                <div class="promotion-info">
                    <h2><?php echo $promotion['title']; ?></h2>
                    <div class="promotion-period">
                        <i class="far fa-calendar-alt"></i> <?php echo $promotion['start_date']; ?> - <?php echo $promotion['end_date']; ?>
                    </div>
                    <p><?php echo $promotion['description']; ?></p>
                    <div class="promotion-discount">
                        <span><i class="fas fa-tag"></i> <?php echo $promotion['discount']; ?></span>
                    </div>
                    <a href="promotion.php?id=<?php echo $promotion['id']; ?>" class="btn-secondary">Xem chi tiết</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="newsletter-signup">
            <div class="newsletter-content">
                <h2>Đăng ký nhận thông tin khuyến mãi</h2>
                <p>Nhận ngay thông tin về các chương trình khuyến mãi mới nhất từ VJShop</p>
                <form action="subscribe.php" method="post" class="newsletter-form">
                    <input type="email" name="email" placeholder="Email của bạn" required>
                    <button type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sao chép mã giảm giá
    const copyButtons = document.querySelectorAll('.copy-coupon');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(() => {
                this.textContent = 'Đã sao chép';
                setTimeout(() => {
                    this.textContent = 'Sao chép';
                }, 2000);
            });
        });
    });
    
    // Thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            // Hiệu ứng nút
            this.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
            this.style.backgroundColor = '#2ecc71';
            
            // Animation sản phẩm
            const productCard = this.closest('.product-card');
            productCard.classList.add('pulse');
            
            // Reset sau 2 giây
            setTimeout(() => {
                this.innerHTML = 'Thêm vào giỏ';
                this.style.backgroundColor = '';
                productCard.classList.remove('pulse');
            }, 2000);
            
            // Gửi AJAX request để thêm vào giỏ hàng
            fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId + '&quantity=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng giỏ hàng
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                    }
                }
            });
        });
    });
});
</script>

<?php require_once 'footer.php'; ?>

