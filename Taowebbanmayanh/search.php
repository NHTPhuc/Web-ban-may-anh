<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Lấy từ khóa tìm kiếm
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$view = isset($_GET['view']) ? $_GET['view'] : 'grid';

// Tìm kiếm sản phẩm
$products = [];

if (!empty($query)) {
    $all_products = getSampleProducts();
    
    foreach ($all_products as $product) {
        // Tìm kiếm theo tên sản phẩm
        if (stripos($product['name'], $query) !== false || 
            stripos($product['description'], $query) !== false) {
            
            // Lọc theo danh mục nếu có
            if (empty($category) || $product['category'] == $category) {
                $products[] = $product;
            }
        }
    }
    
    // Sắp xếp kết quả
    switch ($sort) {
        case 'price_asc':
            usort($products, function($a, $b) {
                return $a['price'] - $b['price'];
            });
            break;
        case 'price_desc':
            usort($products, function($a, $b) {
                return $b['price'] - $a['price'];
            });
            break;
        case 'name_asc':
            usort($products, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            break;
        case 'name_desc':
            usort($products, function($a, $b) {
                return strcmp($b['name'], $a['name']);
            });
            break;
    }
}
?>

<div class="container">
    <div class="search-results-page">
        <h1 class="page-title">Kết quả tìm kiếm: "<?php echo htmlspecialchars($query); ?>"</h1>
        
        <?php if (empty($query)): ?>
        <div class="search-empty">
            <div class="search-empty-icon">
                <i class="fas fa-search"></i>
            </div>
            <h2>Vui lòng nhập từ khóa tìm kiếm</h2>
            <p>Nhập từ khóa để tìm kiếm sản phẩm bạn cần.</p>
            <div class="search-form">
                <form action="search.php" method="get">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." autofocus>
                    <button type="submit">Tìm kiếm</button>
                </form>
            </div>
        </div>
        <?php elseif (empty($products)): ?>
        <div class="search-empty">
            <div class="search-empty-icon">
                <i class="fas fa-search"></i>
            </div>
            <h2>Không tìm thấy kết quả</h2>
            <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($query); ?>".</p>
            <p>Vui lòng thử lại với từ khóa khác hoặc xem các gợi ý dưới đây.</p>
            <div class="search-suggestions">
                <h3>Gợi ý tìm kiếm:</h3>
                <ul>
                    <li>Kiểm tra lỗi chính tả</li>
                    <li>Sử dụng từ khóa ngắn gọn hơn</li>
                    <li>Thử tìm kiếm với từ khóa khác</li>
                    <li>Tìm kiếm theo danh mục sản phẩm</li>
                </ul>
            </div>
            <a href="index.php" class="btn-primary">Quay lại trang chủ</a>
        </div>
        <?php else: ?>
        <div class="search-filters">
            <div class="category-nav">
                <a href="search.php?q=<?php echo urlencode($query); ?>&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>" class="<?php echo empty($category) ? 'active' : ''; ?>">Tất cả</a>
                <a href="search.php?q=<?php echo urlencode($query); ?>&category=camera&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>" class="<?php echo $category == 'camera' ? 'active' : ''; ?>">Máy Ảnh</a>
                <a href="search.php?q=<?php echo urlencode($query); ?>&category=lens&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>" class="<?php echo $category == 'lens' ? 'active' : ''; ?>">Ống Kính</a>
                <a href="search.php?q=<?php echo urlencode($query); ?>&category=laptop&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>" class="<?php echo $category == 'laptop' ? 'active' : ''; ?>">Laptop</a>
                <a href="search.php?q=<?php echo urlencode($query); ?>&category=accessory&sort=<?php echo $sort; ?>&view=<?php echo $view; ?>" class="<?php echo $category == 'accessory' ? 'active' : ''; ?>">Phụ Kiện</a>
            </div>
            
            <div class="product-controls">
                <div class="sort-options">
                    <label for="sort-select">Sắp xếp:</label>
                    <select id="sort-select" onchange="window.location.href=this.value">
                        <option value="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=default&view=<?php echo $view; ?>" <?php echo $sort == 'default' ? 'selected' : ''; ?>>Mặc định</option>
                        <option value="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=price_asc&view=<?php echo $view; ?>" <?php echo $sort == 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                        <option value="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=price_desc&view=<?php echo $view; ?>" <?php echo $sort == 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                        <option value="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=name_asc&view=<?php echo $view; ?>" <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                        <option value="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=name_desc&view=<?php echo $view; ?>" <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
                    </select>
                </div>
                
                <div class="display-options">
                    <span>Hiển thị:</span>
                    <div class="view-buttons">
                        <a href="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>&view=grid" class="view-button <?php echo $view == 'grid' ? 'active' : ''; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </a>
                        <a href="search.php?q=<?php echo urlencode($query); ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>&view=list" class="view-button <?php echo $view == 'list' ? 'active' : ''; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        </a>
                    </div>
                    <span>Sản phẩm: <?php echo count($products); ?></span>
                </div>
            </div>
        </div>
        
        <div class="search-results">
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
                                <span class="discount">-<?php echo number_format(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>%</span>
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
                        <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">Thêm vào giỏ</button>
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
                                <?php if (isset($product['old_price']) && $product['old_price'] > 0): ?>
                                <div>
                                    <span class="old-price"><?php echo number_format($product['old_price']); ?> đ</span>
                                    <span class="discount">-<?php echo number_format(($product['old_price'] - $product['price']) / $product['old_price'] * 100); ?>%</span>
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
                                <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các chức năng JavaScript
    initializeCart();
    initializeUIEffects();
});
</script>

<?php require_once 'footer.php'; ?>
