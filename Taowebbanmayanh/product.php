<?php
// Sample product data - in a real application, this would come from a database
$products = [
    [
        'id' => 1,
        'name' => 'Máy Ảnh Sony Alpha 7C II (Silver)',
        'category' => 'Mirrorless',
        'price' => 44490000,
        'old_price' => 50990000,
        'discount' => 6500000,
        'image' => '/images/sony-alpha-7c.jpg',
        'rating' => 4.5,
        'reviews' => 7,
        'is_hot' => true,
        'gift' => 2480000,
        'brand' => 'Sony',
        'description' => 'Máy ảnh Sony Alpha 7C II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame nhỏ gọn nhất của Sony. Với cảm biến CMOS Exmor R 33MP, bộ xử lý hình ảnh BIONZ XR, khả năng chụp liên tiếp 10fps và quay video 4K 60p, Alpha 7C II mang đến hiệu suất cao trong một thân máy nhỏ gọn.',
        'specifications' => [
            'Cảm biến' => 'CMOS Exmor R Full-frame 33MP',
            'Bộ xử lý hình ảnh' => 'BIONZ XR',
            'Dải ISO' => '100-51200 (mở rộng: 50-204800)',
            'Tốc độ chụp liên tiếp' => '10 fps',
            'Màn hình' => 'LCD cảm ứng 3.0" 1.04 triệu điểm',
            'EVF' => 'OLED 2.36 triệu điểm',
            'Video' => '4K 60p, Full HD 120p',
            'Kết nối' => 'Wi-Fi, Bluetooth, USB-C, HDMI, Mic, Headphone',
            'Pin' => 'NP-FZ100 (Khoảng 740 ảnh)',
            'Kích thước' => '124.0 x 71.1 x 59.7 mm',
            'Trọng lượng' => '509g (bao gồm pin và thẻ nhớ)'
        ],
        'features' => [
            'Cảm biến Full-frame 33MP cho chất lượng hình ảnh vượt trội',
            'Thân máy nhỏ gọn, nhẹ nhất trong dòng máy ảnh full-frame',
            'Chống rung trong thân máy 5 trục',
            'Lấy nét tự động nhanh với 759 điểm AF pha',
            'Nhận diện và theo dõi chủ thể thông minh với AI',
            'Quay video 4K 60p không crop',
            'Kết nối không dây Wi-Fi và Bluetooth',
            'Pin dung lượng cao, chụp được khoảng 740 ảnh'
        ],
        'images' => [
            '/images/sony-alpha-7c-1.jpg',
            '/images/sony-alpha-7c-2.jpg',
            '/images/sony-alpha-7c-3.jpg',
            '/images/sony-alpha-7c-4.jpg'
        ]
    ],
    // Other products would be defined here
];

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Find the product
$product = null;
foreach ($products as $p) {
    if ($p['id'] === $product_id) {
        $product = $p;
        break;
    }
}

// If product not found, redirect to home page
if (!$product) {
    header('Location: index.php');
    exit;
}

// Format price in Vietnamese Dong
function format_price($price) {
    return number_format($price, 0, ',', '.') . ' ₫';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - VJ Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional styles for product page */
        .product-detail {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .product-gallery {
            display: flex;
            flex-direction: column;
        }
        
        .main-image {
            height: 400px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .thumbnails {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            border: 2px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
        }
        
        .thumbnail.active {
            border-color: #e74c3c;
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-info-detail {
            padding: 20px;
        }
        
        .product-title-detail {
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .product-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
            color: #666;
            font-size: 14px;
        }
        
        .product-price-detail {
            margin-bottom: 20px;
        }
        
        .current-price-detail {
            font-size: 28px;
            font-weight: bold;
            color: #e74c3c;
        }
        
        .old-price-detail {
            font-size: 18px;
            color: #999;
            text-decoration: line-through;
            margin-left: 10px;
        }
        
        .discount-detail {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e74c3c;
            color: white;
            border-radius: 4px;
            margin-left: 10px;
            font-size: 14px;
        }
        
        .product-description {
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .quantity-selector label {
            margin-right: 10px;
        }
        
        .quantity-selector .quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .quantity-selector button {
            width: 40px;
            height: 40px;
            background-color: #f5f5f5;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        
        .quantity-selector input {
            width: 60px;
            height: 40px;
            border: none;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            text-align: center;
            font-size: 16px;
        }
        
        .product-actions-detail {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .buy-now-btn {
            flex: 1;
            padding: 15px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .buy-now-btn:hover {
            background-color: #c0392b;
        }
        
        .add-to-cart-btn-detail {
            flex: 1;
            padding: 15px;
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .add-to-cart-btn-detail:hover {
            background-color: #e5e5e5;
        }
        
        .product-features {
            margin-top: 30px;
        }
        
        .product-features h3 {
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .features-list {
            list-style: disc;
            padding-left: 20px;
            margin-bottom: 20px;
        }
        
        .features-list li {
            margin-bottom: 10px;
        }
        
        .specifications-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .specifications-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .specifications-table th, .specifications-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .specifications-table th {
            width: 30%;
            font-weight: 600;
        }
        
        @media (min-width: 768px) {
            .product-detail {
                display: flex;
            }
            
            .product-gallery {
                width: 50%;
                padding: 20px;
            }
            
            .product-info-detail {
                width: 50%;
                border-left: 1px solid #eee;
            }
        }
        
        @media (max-width: 767px) {
            .main-image {
                height: 300px;
            }
            
            .product-actions-detail {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="index.php">
                        <h1>VJ Shop</h1>
                    </a>
                </div>
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="user-actions">
                    <a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
                    <a href="login.php" class="login-btn"><i class="fas fa-user"></i> Đăng nhập</a>
                </div>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php?category=DSLR">Máy Ảnh DSLR</a></li>
                    <li><a href="index.php?category=Mirrorless" class="<?php echo $product['category'] === 'Mirrorless' ? 'active' : ''; ?>">Máy Ảnh Mirrorless</a></li>
                    <li><a href="index.php?category=Compact">Máy Ảnh Compact</a></li>
                    <li><a href="index.php?category=Instax">Máy Ảnh Instax</a></li>
                    <li><a href="index.php?category=Medium Format">Máy Ảnh Medium Format</a></li>
                    <li><a href="index.php?category=Film">Máy Ảnh Film</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &gt;
            <a href="index.php?category=<?php echo urlencode($product['category']); ?>"><?php echo htmlspecialchars($product['category']); ?></a> &gt;
            <span><?php echo htmlspecialchars($product['name']); ?></span>
        </div>
        
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image">
                    <img id="main-product-image" src="<?php echo $product['image'] ? $product['image'] : '/placeholder.svg?height=400&width=400'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                
                <div class="thumbnails">
                    <div class="thumbnail active" data-image="<?php echo $product['image']; ?>">
                        <img src="<?php echo $product['image'] ? $product['image'] : '/placeholder.svg?height=80&width=80'; ?>" alt="Thumbnail 1">
                    </div>
                    
                    <?php if (isset($product['images']) && is_array($product['images'])): ?>
                        <?php foreach ($product['images'] as $index => $image): ?>
                            <div class="thumbnail" data-image="<?php echo $image; ?>">
                                <img src="<?php echo $image ? $image : '/placeholder.svg?height=80&width=80'; ?>" alt="Thumbnail <?php echo $index + 2; ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="product-info-detail">
                <h1 class="product-title-detail"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="product-meta">
                    <div class="product-brand">
                        <span>Thương hiệu:</span> <?php echo htmlspecialchars($product['brand']); ?>
                    </div>
                    
                    <div class="product-rating-detail">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($product['rating'])): ?>
                                <i class="fas fa-star"></i>
                            <?php elseif ($i - 0.5 <= $product['rating']): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span>(<?php echo $product['reviews']; ?> đánh giá)</span>
                    </div>
                </div>
                
                <div class="product-price-detail">
                    <span class="current-price-detail"><?php echo format_price($product['price']); ?></span>
                    
                    <?php if ($product['old_price'] > $product['price']): ?>
                        <span class="old-price-detail"><?php echo format_price($product['old_price']); ?></span>
                        <span class="discount-detail">Giảm <?php echo format_price($product['discount']); ?></span>
                    <?php endif; ?>
                </div>
                
                <?php if (isset($product['description'])): ?>
                    <div class="product-description">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </div>
                <?php endif; ?>
                
                <div class="quantity-selector">
                    <label for="quantity">Số lượng:</label>
                    <div class="quantity">
                        <button id="decrease-quantity">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="10">
                        <button id="increase-quantity">+</button>
                    </div>
                </div>
                
                <div class="product-actions-detail">
                    <button class="buy-now-btn">Mua ngay</button>
                    <button class="add-to-cart-btn-detail">Thêm vào giỏ hàng</button>
                </div>
                
                <?php if ($product['gift'] > 0): ?>
                    <div class="product-gift-detail">
                        <h3>Quà tặng kèm:</h3>
                        <p><i class="fas fa-gift"></i> Phiếu quà tặng trị giá <?php echo format_price($product['gift']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="product-features">
            <h3>Tính năng nổi bật</h3>
            
            <?php if (isset($product['features']) && is_array($product['features'])): ?>
                <ul class="features-list">
                    <?php foreach ($product['features'] as $feature): ?>
                        <li><?php echo htmlspecialchars($feature); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <h3>Thông số kỹ thuật</h3>
            
            <?php if (isset($product['specifications']) && is_array($product['specifications'])): ?>
                <table class="specifications-table">
                    <?php foreach ($product['specifications'] as $spec => $value): ?>
                        <tr>
                            <th><?php echo htmlspecialchars($spec); ?></th>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Về VJ Shop</h3>
                    <ul>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                        <li><a href="careers.php">Tuyển dụng</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Hỗ trợ khách hàng</h3>
                    <ul>
                        <li><a href="faq.php">Câu hỏi thường gặp</a></li>
                        <li><a href="shipping.php">Chính sách vận chuyển</a></li>
                        <li><a href="warranty.php">Chính sách bảo hành</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Liên hệ với chúng tôi</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</p>
                        <p><i class="fas fa-phone"></i> Hotline: 1900 1234</p>
                        <p><i class="fas fa-envelope"></i> Email: info@vjshop.vn</p>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Chat với chúng tôi</h3>
                    <div class="chat-options">
                        <a href="#" class="chat-btn facebook">
                            <i class="fab fa-facebook-messenger"></i> Chat Facebook
                            <span class="chat-time">(9h-22h)</span>
                        </a>
                        <a href="#" class="chat-btn zalo">
                            <i class="fas fa-comment"></i> Chat Zalo
                            <span class="chat-time">(9h-22h)</span>
                        </a>
                        <a href="#" class="chat-btn hotline">
                            <i class="fas fa-phone-alt"></i> Hotline Tư Vấn
                            <span class="chat-time">(9h-19h)</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 VJ Shop - Cửa hàng máy ảnh chính hãng. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thumbnail gallery
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImage = document.getElementById('main-product-image');
            
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('active'));
                    
                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                    
                    // Update main image
                    mainImage.src = this.dataset.image;
                });
            });
            
            // Quantity selector
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decrease-quantity');
            const increaseBtn = document.getElementById('increase-quantity');
            
            decreaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value < 10) {
                    quantityInput.value = value + 1;
                }
            });
            
            // Add to cart button
            const addToCartBtn = document.querySelector('.add-to-cart-btn-detail');
            
            addToCartBtn.addEventListener('click', function() {
                const quantity = parseInt(quantityInput.value);
                
                // Simple animation
                this.innerHTML = '<i class="fas fa-check"></i> Đã thêm vào giỏ';
                this.style.backgroundColor = '#27ae60';
                this.style.backgroundColor = '#27ae60';
                this.style.color = 'white';
                this.style.backgroundColor = '#27ae60';
                this.style.color = 'white';
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = 'Thêm vào giỏ hàng';
                    this.style.backgroundColor = '';
                    this.style.color = '';
                }, 2000);
                
                // In a real application, you would send an AJAX request to add the product to the cart
                console.log(`Product added to cart, quantity: ${quantity}`);
            });
            
            // Buy now button
            const buyNowBtn = document.querySelector('.buy-now-btn');
            
            buyNowBtn.addEventListener('click', function() {
                const quantity = parseInt(quantityInput.value);
                
                // In a real application, you would redirect to checkout page
                console.log(`Proceeding to checkout with quantity: ${quantity}`);
                window.location.href = `checkout.php?product_id=<?php echo $product_id; ?>&quantity=${quantity}`;
            });
        });
    </script>
</body>
</html>


