<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Lấy danh sách sản phẩm từ database
$category = isset($_GET['category']) ? $_GET['category'] : '';
$price_filter = isset($_GET['price']) ? $_GET['price'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$view = isset($_GET['view']) ? $_GET['view'] : 'grid';

$products = getProducts($category, $price_filter, $sort);

// Lấy danh sách khuyến mãi nổi bật
$promotions = [
    [
        'id' => 1,
        'title' => 'Siêu Sale Máy Ảnh - Giảm đến 30%',
        'image' => '/placeholder.svg?height=300&width=600',
        'end_date' => '15/05/2025'
    ],
    [
        'id' => 2,
        'title' => 'Laptop Gaming - Quà tặng khủng',
        'image' => '/placeholder.svg?height=300&width=600',
        'end_date' => '30/05/2025'
    ],
    [
        'id' => 4,
        'title' => 'Sinh nhật VJShop - Giảm sốc toàn bộ sản phẩm',
        'image' => '/placeholder.svg?height=300&width=600',
        'end_date' => '30/05/2025'
    ]
];

// Lấy tin tức mới nhất
$latest_news = [
    [
        'id' => 1,
        'title' => 'Sony ra mắt máy ảnh Alpha 7C II với nhiều cải tiến đáng giá',
        'image' => '/placeholder.svg?height=200&width=300',
        'date' => '05/05/2025',
        'summary' => 'Sony vừa chính thức giới thiệu máy ảnh mirrorless full-frame Alpha 7C II với nhiều nâng cấp về cảm biến, bộ xử lý và khả năng quay video.'
    ],
    [
        'id' => 4,
        'title' => 'VJShop khai trương chi nhánh mới tại Đà Nẵng',
        'image' => '/placeholder.svg?height=200&width=300',
        'date' => '02/05/2025',
        'summary' => 'VJShop mở rộng mạng lưới với chi nhánh mới tại Đà Nẵng, mang đến trải nghiệm mua sắm tuyệt vời cho khách hàng miền Trung.'
    ]
];
?>

<div class="container">
    <!-- Banner chính -->
    <div class="main-banner">
        <div class="banner-slider">
            <div class="banner-slide active">
                <img src="/placeholder.svg?height=500&width=1200" alt="VJShop Banner">
                <div class="banner-content">
                    <h2>Máy ảnh Sony Alpha 7C II</h2>
                    <p>Nhỏ gọn, mạnh mẽ, đa năng</p>
                    <a href="product-detail.php?id=1" class="btn-primary">Xem ngay</a>
                </div>
            </div>
        </div>
        <div class="banner-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <!-- Phần giới thiệu shop - Di chuyển từ trái sang phải -->
    <div class="shop-intro">
        <div class="shop-intro-content">
            <div class="shop-intro-text">
                <h2>Chào mừng đến với VJShop</h2>
                <p>VJShop là cửa hàng chuyên cung cấp các sản phẩm máy ảnh, ống kính, laptop và phụ kiện chính hãng với
                    chất lượng cao và giá cả cạnh tranh. Với hơn 10 năm kinh nghiệm, chúng tôi tự hào là đối tác tin cậy
                    của nhiều thương hiệu lớn như Sony, Canon, Nikon, Apple, Dell và nhiều hãng khác.</p>
                <p>Đến với VJShop, bạn không chỉ mua sắm sản phẩm mà còn nhận được dịch vụ tư vấn chuyên nghiệp, bảo
                    hành uy tín và hậu mãi chu đáo.</p>
            </div>
            <div class="shop-intro-image">
                <img src="/placeholder.svg?height=400&width=600" alt="VJShop Store">
            </div>
        </div>
        <div class="shop-intro-stats">
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Năm kinh nghiệm</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">5</div>
                <div class="stat-label">Chi nhánh toàn quốc</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Sản phẩm chính hãng</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50.000+</div>
                <div class="stat-label">Khách hàng hài lòng</div>
            </div>
        </div>
    </div>

    <!-- Danh mục sản phẩm -->
    <div class="category-nav">
        <a href="index.php" class="<?php echo empty($category) ? 'active' : ''; ?>">Tất cả sản phẩm</a>
        <a href="index.php?category=camera" class="<?php echo $category == 'camera' ? 'active' : ''; ?>">Máy Ảnh</a>
        <a href="index.php?category=lens" class="<?php echo $category == 'lens' ? 'active' : ''; ?>">Ống Kính</a>
        <a href="index.php?category=laptop" class="<?php echo $category == 'laptop' ? 'active' : ''; ?>">Laptop</a>
        <a href="index.php?category=accessory" class="<?php echo $category == 'accessory' ? 'active' : ''; ?>">Phụ
            Kiện</a>
    </div>

    <!-- Bộ lọc giá -->
    <div class="price-filter">
        <h3>Mức giá:</h3>
        <div class="price-filter-options">
            <a href="index.php?category=<?php echo $category; ?>&price=under30&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>"
                class="<?php echo $price_filter == 'under30' ? 'active' : ''; ?>">Dưới 30 triệu</a>
            <a href="index.php?category=<?php echo $category; ?>&price=30-40&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>"
                class="<?php echo $price_filter == '30-40' ? 'active' : ''; ?>">Từ 30-40 triệu</a>
            <a href="index.php?category=<?php echo $category; ?>&price=40-60&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>"
                class="<?php echo $price_filter == '40-60' ? 'active' : ''; ?>">Từ 40-60 triệu</a>
            <a href="index.php?category=<?php echo $category; ?>&price=over60&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>"
                class="<?php echo $price_filter == 'over60' ? 'active' : ''; ?>">Trên 60 triệu</a>
        </div>
    </div>

    <!-- Sắp xếp và hiển thị -->
    <div class="product-controls">
        <div class="sort-options">
            <label for="sort-select">Sắp xếp:</label>
            <select id="sort-select" onchange="window.location.href=this.value">
                <option
                    value="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=default&view=<?php echo $view; ?>"
                    <?php echo $sort == 'default' ? 'selected' : ''; ?>>Mặc định</option>
                <option
                    value="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=price_asc&view=<?php echo $view; ?>"
                    <?php echo $sort == 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                <option
                    value="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=price_desc&view=<?php echo $view; ?>"
                    <?php echo $sort == 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                <option
                    value="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=name_asc&view=<?php echo $view; ?>"
                    <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                <option
                    value="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=name_desc&view=<?php echo $view; ?>"
                    <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
            </select>
        </div>

        <div class="display-options">
            <span>Hiển thị:</span>
            <div class="view-buttons">
                <a href="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=<?php echo $sort; ?>&view=grid"
                    class="view-button <?php echo $view == 'grid' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </a>
                <a href="index.php?category=<?php echo $category; ?>&price=<?php echo $price_filter; ?>&sort=<?php echo $sort; ?>&view=list"
                    class="view-button <?php echo $view == 'list' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </a>
            </div>
            <span>Sản phẩm: <?php echo count($products); ?></span>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <?php if ($view == 'grid'): ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
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
                        <span
                            class="discount">-<?php echo number_format(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>%</span>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($product['gift']) && $product['gift'] > 0): ?>
                    <div class="product-gift">
                        <i class="fas fa-gift"></i> Quà tặng: <?php echo number_format($product['gift']); ?>đ
                    </div>
                    <?php endif; ?>
                </div>
            </a>

            <div class="product-actions">
                <a href="#" class="compare-btn" data-id="<?php echo $product['id']; ?>">+ So sánh</a>
                <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">
                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
        <div class="product-list-item slide-up">
            <?php if (isset($product['hot']) && $product['hot']): ?>
            <div class="product-badge">SẢN PHẨM HOT</div>
            <?php endif; ?>

            <div class="product-list-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>

            <div class="product-list-info">
                <h3 class="product-list-title">
                    <a href="product-detail.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                </h3>

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

                <div class="product-list-description">
                    <?php echo substr($product['description'], 0, 200); ?>...
                </div>

                <div class="product-list-bottom">
                    <div class="product-list-price">
                        <span class="current-price"><?php echo number_format($product['price']); ?> đ</span>
                        <?php if (isset($product['old_price']) && is_numeric($product['old_price']) && $product['old_price'] > 0): ?>
                        <div>
                            <span class="old-price"><?php echo number_format($product['old_price']); ?> đ</span>
                            <span
                                class="discount">-<?php echo number_format(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>%</span>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($product['gift']) && $product['gift'] > 0): ?>
                        <div class="product-gift">
                            <i class="fas fa-gift"></i> Quà tặng: <?php echo number_format($product['gift']); ?>đ
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-list-actions">
                        <a href="#" class="compare-btn" data-id="<?php echo $product['id']; ?>">+ So sánh</a>
                        <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Khuyến mãi nổi bật -->
    <div class="featured-promotions">
        <h2 class="section-title">Khuyến mãi nổi bật</h2>
        <div class="promotions-slider">
            <?php foreach ($promotions as $promotion): ?>
            <div class="promotion-slide fade-in">
                <a href="promotion.php?id=<?php echo $promotion['id']; ?>">
                    <img src="<?php echo $promotion['image']; ?>" alt="<?php echo $promotion['title']; ?>">
                    <div class="promotion-info">
                        <h3><?php echo $promotion['title']; ?></h3>
                        <p>Kết thúc: <?php echo $promotion['end_date']; ?></p>
                        <span class="view-more">Xem chi tiết <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tin tức mới nhất -->
    <div class="latest-news">
        <h2 class="section-title">Tin tức mới nhất</h2>
        <div class="news-grid">
            <?php foreach ($latest_news as $news): ?>
            <div class="news-card slide-up">
                <a href="news.php?id=<?php echo $news['id']; ?>">
                    <div class="news-image">
                        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                    </div>
                    <div class="news-info">
                        <h3><?php echo $news['title']; ?></h3>
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i> <?php echo $news['date']; ?>
                        </div>
                        <p><?php echo $news['summary']; ?></p>
                        <span class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="view-all-news">
            <a href="news.php" class="btn-secondary">Xem tất cả tin tức</a>
        </div>
    </div>

    <!-- Kết nối các trang -->
    <div class="page-connections">
        <h2>Khám phá thêm</h2>
        <div class="connections-grid">
            <div class="connection-item">
                <h3>Giỏ hàng</h3>
                <p>Xem và quản lý sản phẩm trong giỏ hàng của bạn.</p>
                <a href="cart.php">Đến giỏ hàng</a>
            </div>
            <div class="connection-item">
                <h3>Khuyến mãi</h3>
                <p>Khám phá các chương trình khuyến mãi hấp dẫn.</p>
                <a href="promotion.php">Xem khuyến mãi</a>
            </div>
            <div class="connection-item">
                <h3>Tin tức</h3>
                <p>Cập nhật tin tức mới nhất về công nghệ và nhiếp ảnh.</p>
                <a href="news.php">Đọc tin tức</a>
            </div>
            <div class="connection-item">
                <h3>Liên hệ</h3>
                <p>Liên hệ với chúng tôi nếu bạn cần hỗ trợ.</p>
                <a href="contact.php">Liên hệ ngay</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>