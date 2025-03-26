<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lấy thông tin sản phẩm trong giỏ hàng
$cart_items = [];
$total_price = 0;
$total_discount = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $product = getProductById($product_id);
    if ($product) {
        $product['quantity'] = $quantity;
        $product['subtotal'] = $product['price'] * $quantity;
        $cart_items[] = $product;
        
        $total_price += $product['subtotal'];
        if (isset($product['old_price']) && $product['old_price'] > 0) {
            $total_discount += ($product['old_price'] - $product['price']) * $quantity;
        }
    }
}

// Xử lý mã giảm giá
$coupon_code = '';
$coupon_discount = 0;
$coupon_error = '';
$coupon_success = '';

if (isset($_POST['apply_coupon'])) {
    $coupon_code = $_POST['coupon_code'];
    
    // Kiểm tra mã giảm giá (mã mẫu: WELCOME10, SALE20)
    if ($coupon_code == 'WELCOME10') {
        $coupon_discount = $total_price * 0.1;
        $coupon_success = 'Áp dụng mã giảm giá thành công: Giảm 10%';
    } elseif ($coupon_code == 'SALE20') {
        $coupon_discount = $total_price * 0.2;
        $coupon_success = 'Áp dụng mã giảm giá thành công: Giảm 20%';
    } else {
        $coupon_error = 'Mã giảm giá không hợp lệ hoặc đã hết hạn';
    }
}

// Tính tổng thanh toán
$final_total = $total_price - $coupon_discount;
?>

<div class="container">
    <h1 class="page-title">Giỏ hàng của bạn</h1>
    
    <?php if (empty($cart_items)): ?>
    <div class="empty-cart fade-in">
        <div class="empty-cart-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <h2>Giỏ hàng trống</h2>
        <p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
        <a href="index.php" class="btn-primary">Tiếp tục mua sắm</a>
    </div>
    <?php else: ?>
    <div class="cart-container">
        <div class="cart-items">
            <div class="cart-header">
                <div class="cart-product-col">Sản phẩm</div>
                <div class="cart-price-col">Đơn giá</div>
                <div class="cart-quantity-col">Số lượng</div>
                <div class="cart-subtotal-col">Thành tiền</div>
                <div class="cart-action-col"></div>
            </div>
            
            <?php foreach ($cart_items as $item): ?>
            <div class="cart-item slide-up" data-id="<?php echo $item['id']; ?>">
                <div class="cart-product-col">
                    <div class="cart-product-info">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div>
                            <h3><a href="product-detail.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a></h3>
                            <?php if (isset($item['gift']) && $item['gift'] > 0): ?>
                            <div class="product-gift">
                                <i class="fas fa-gift"></i> Quà tặng: <?php echo number_format($item['gift']); ?>đ
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="cart-price-col">
                    <div class="product-price">
                        <span class="current-price"><?php echo number_format($item['price']); ?> đ</span>
                        <?php if (isset($item['old_price']) && $item['old_price'] > 0): ?>
                        <span class="old-price"><?php echo number_format($item['old_price']); ?> đ</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="cart-quantity-col">
                    <div class="quantity-control">
                        <button class="quantity-btn decrease-btn" data-id="<?php echo $item['id']; ?>">-</button>
                        <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-id="<?php echo $item['id']; ?>">
                        <button class="quantity-btn increase-btn" data-id="<?php echo $item['id']; ?>">+</button>
                    </div>
                </div>
                <div class="cart-subtotal-col">
                    <span class="subtotal"><?php echo number_format($item['subtotal']); ?> đ</span>
                </div>
                <div class="cart-action-col">
                    <button class="remove-item-btn" data-id="<?php echo $item['id']; ?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cart-summary">
            <h2>Tóm tắt đơn hàng</h2>
            
            <div class="coupon-form">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" value="<?php echo $coupon_code; ?>">
                        <button type="submit" name="apply_coupon">Áp dụng</button>
                    </div>
                    <?php if ($coupon_error): ?>
                    <div class="coupon-error"><?php echo $coupon_error; ?></div>
                    <?php endif; ?>
                    <?php if ($coupon_success): ?>
                    <div class="coupon-success"><?php echo $coupon_success; ?></div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="summary-details">
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span><?php echo number_format($total_price); ?> đ</span>
                </div>
                <?php if ($total_discount > 0): ?>
                <div class="summary-row discount">
                    <span>Giảm giá sản phẩm:</span>
                    <span>-<?php echo number_format($total_discount); ?> đ</span>
                </div>
                <?php endif; ?>
                <?php if ($coupon_discount > 0): ?>
                <div class="summary-row discount">
                    <span>Giảm giá mã khuyến mãi:</span>
                    <span>-<?php echo number_format($coupon_discount); ?> đ</span>
                </div>
                <?php endif; ?>
                <div class="summary-row shipping">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <span><?php echo number_format($final_total); ?> đ</span>
                </div>
            </div>
            
            <div class="cart-actions">
                <a href="index.php" class="continue-shopping">Tiếp tục mua sắm</a>
                <a href="checkout.php" class="checkout-btn">Tiến hành thanh toán</a>
            </div>
            
            <div class="payment-methods-info">
                <h3>Chấp nhận thanh toán</h3>
                <div class="payment-icons">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-jcb"></i>
                    <i class="fab fa-cc-paypal"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="recommended-products">
        <h2>Có thể bạn cũng thích</h2>
        <div class="product-grid">
            <?php 
            $recommended = getSampleProducts('', '', 'default');
            $recommended = array_slice($recommended, 0, 4);
            foreach ($recommended as $product): 
            ?>
            <div class="product-card fade-in">
                <?php if (isset($product['hot']) && $product['hot']): ?>
                <div class="product-badge">SẢN PHẨM HOT</div>
                <?php endif; ?>
                
                <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                    <div class="product-image">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo $product['name']; ?></h3>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $product['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 <= $product['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="count">(<?php echo $product['rating_count']; ?>)</span>
                        </div>
                        
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
                    <a href="#" class="compare-btn" data-id="<?php echo $product['id']; ?>">+ So sánh</a>
                    <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">Thêm vào giỏ</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật số lượng
    const updateQuantity = (productId, quantity) => {
        fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền
                const subtotalElement = document.querySelector(`.cart-item[data-id="${productId}"] .subtotal`);
                if (subtotalElement) {
                    subtotalElement.textContent = data.subtotal;
                }
                
                // Cập nhật tổng giỏ hàng
                document.querySelector('.summary-row.total span:last-child').textContent = data.total;
                
                // Cập nhật số lượng trên header
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
                
                // Reload trang nếu cần cập nhật toàn bộ
                if (data.reload) {
                    window.location.reload();
                }
            }
        });
    };
    
    // Xử lý nút tăng số lượng
    const increaseButtons = document.querySelectorAll('.increase-btn');
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const inputElement = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(inputElement.value) + 1;
            inputElement.value = quantity;
            updateQuantity(productId, quantity);
        });
    });
    
    // Xử lý nút giảm số lượng
    const decreaseButtons = document.querySelectorAll('.decrease-btn');
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const inputElement = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(inputElement.value) - 1;
            if (quantity < 1) quantity = 1;
            inputElement.value = quantity;
            updateQuantity(productId, quantity);
        });
    });
    
    // Xử lý khi thay đổi input số lượng
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-id');
            let quantity = parseInt(this.value);
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                this.value = 1;
            }
            updateQuantity(productId, quantity);
        });
    });
    
    // Xử lý nút xóa sản phẩm
    const removeButtons = document.querySelectorAll('.remove-item-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                fetch('update-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&remove=1`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Xóa phần tử khỏi DOM
                        const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`);
                        if (cartItem) {
                            cartItem.classList.add('fade-out');
                            setTimeout(() => {
                                cartItem.remove();
                                
                                // Kiểm tra nếu giỏ hàng trống
                                if (document.querySelectorAll('.cart-item').length === 0) {
                                    window.location.reload();
                                }
                            }, 300);
                        }
                        
                        // Cập nhật tổng giỏ hàng
                        document.querySelector('.summary-row.total span:last-child').textContent = data.total;
                        
                        // Cập nhật số lượng trên header
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }
                    }
                });
            }
        });
    });
    
    // Thêm vào giỏ hàng từ sản phẩm đề xuất
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
