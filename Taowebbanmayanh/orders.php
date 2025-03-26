<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Lấy thông tin người dùng
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Lọc đơn hàng
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Dữ liệu mẫu cho đơn hàng
$orders = [
    [
        'id' => 'DH123456',
        'date' => '10/05/2025',
        'status' => 'delivered',
        'status_text' => 'Đã giao hàng',
        'total' => 44490000,
        'products' => [
            [
                'id' => 1,
                'name' => 'Máy Ảnh Sony Alpha 7C II (Silver) | Chính Hãng',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 44490000,
                'quantity' => 1
            ]
        ]
    ],
    [
        'id' => 'DH123455',
        'date' => '05/05/2025',
        'status' => 'shipped',
        'status_text' => 'Đang vận chuyển',
        'total' => 21990000,
        'products' => [
            [
                'id' => 2,
                'name' => 'Máy ảnh Canon EOS R10 + Lens RF-S 18-45mm F4.5-6.3 IS STM | Chính Hãng',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 21990000,
                'quantity' => 1
            ]
        ]
    ],
    [
        'id' => 'DH123454',
        'date' => '01/05/2025',
        'status' => 'processing',
        'status_text' => 'Đang xử lý',
        'total' => 83980000,
        'products' => [
            [
                'id' => 5,
                'name' => 'Laptop Dell XPS 13 Plus 9320 (i7-1260P, 16GB, 512GB, Intel Iris Xe, 13.4" 3.5K OLED)',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 39990000,
                'quantity' => 1
            ],
            [
                'id' => 6,
                'name' => 'Laptop Apple MacBook Air M2 (8GB RAM, 256GB SSD, 13.6" Liquid Retina)',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 27990000,
                'quantity' => 1
            ],
            [
                'id' => 12,
                'name' => 'Đèn flash Godox V1 cho Sony | Chính hãng',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 4990000,
                'quantity' => 2
            ]
        ]
    ],
    [
        'id' => 'DH123453',
        'date' => '25/04/2025',
        'status' => 'cancelled',
        'status_text' => 'Đã hủy',
        'total' => 35990000,
        'products' => [
            [
                'id' => 7,
                'name' => 'Laptop Asus ROG Zephyrus G14 (Ryzen 9 6900HS, 16GB, 1TB, RTX 3060, 14" QHD 120Hz)',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 35990000,
                'quantity' => 1
            ]
        ]
    ],
    [
        'id' => 'DH123452',
        'date' => '20/04/2025',
        'status' => 'pending',
        'status_text' => 'Chờ thanh toán',
        'total' => 49990000,
        'products' => [
            [
                'id' => 9,
                'name' => 'Ống kính Sony FE 24-70mm f/2.8 GM II | Chính hãng',
                'image' => '/placeholder.svg?height=80&width=80',
                'price' => 49990000,
                'quantity' => 1
            ]
        ]
    ]
];

// Lọc theo trạng thái
if (!empty($status_filter)) {
    $orders = array_filter($orders, function($order) use ($status_filter) {
        return $order['status'] == $status_filter;
    });
}

// Tìm kiếm theo mã đơn hàng
if (!empty($search)) {
    $orders = array_filter($orders, function($order) use ($search) {
        return stripos($order['id'], $search) !== false;
    });
}

// Sắp xếp đơn hàng theo ngày mới nhất
usort($orders, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>

<div class="container">
    <div class="orders-page">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &gt; 
            <span>Đơn hàng của tôi</span>
        </div>
        
        <div class="orders-container">
            <div class="orders-header">
                <h1>Đơn hàng của tôi</h1>
                
                <div class="order-filter">
                    <div class="order-search">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Tìm kiếm đơn hàng..." value="<?php echo $search; ?>" onchange="searchOrders(  placeholder="Tìm kiếm đơn hàng..." value="<?php echo $search; ?>" onchange="searchOrders(this.value)">
                    </div>
                    
                    <select onchange="filterOrders(this.value)">
                        <option value="" <?php echo empty($status_filter) ? 'selected' : ''; ?>>Tất cả đơn hàng</option>
                        <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Chờ thanh toán</option>
                        <option value="processing" <?php echo $status_filter == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                        <option value="shipped" <?php echo $status_filter == 'shipped' ? 'selected' : ''; ?>>Đang vận chuyển</option>
                        <option value="delivered" <?php echo $status_filter == 'delivered' ? 'selected' : ''; ?>>Đã giao hàng</option>
                        <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                </div>
            </div>
            
            <?php if (empty($orders)): ?>
            <div class="no-orders">
                <div class="no-orders-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h2>Không tìm thấy đơn hàng nào</h2>
                <p>Bạn chưa có đơn hàng nào hoặc không có đơn hàng phù hợp với bộ lọc.</p>
                <a href="index.php" class="btn-primary">Tiếp tục mua sắm</a>
            </div>
            <?php else: ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                <div class="order-item">
                    <div class="order-header">
                        <div class="order-id">Đơn hàng #<?php echo $order['id']; ?></div>
                        <div class="order-date"><?php echo $order['date']; ?></div>
                        <div class="order-status status-<?php echo $order['status']; ?>"><?php echo $order['status_text']; ?></div>
                    </div>
                    
                    <div class="order-content">
                        <div class="order-products">
                            <?php foreach ($order['products'] as $product): ?>
                            <div class="order-product">
                                <div class="order-product-image">
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                </div>
                                <div class="order-product-info">
                                    <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="order-product-name"><?php echo $product['name']; ?></a>
                                    <div class="order-product-price"><?php echo number_format($product['price']); ?> đ</div>
                                    <div class="order-product-quantity">Số lượng: <?php echo $product['quantity']; ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-summary">
                            <div class="order-total">Tổng tiền: <?php echo number_format($order['total']); ?> đ</div>
                            <div class="order-actions">
                                <a href="order-detail.php?id=<?php echo $order['id']; ?>" class="btn-view-details">Xem chi tiết</a>
                                <?php if ($order['status'] == 'shipped' || $order['status'] == 'processing'): ?>
                                <a href="order-tracking.php?id=<?php echo $order['id']; ?>" class="btn-track-order">Theo dõi đơn hàng</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="pagination">
                <a href="#" class="disabled"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#"><i class="fas fa-chevron-right"></i></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function filterOrders(status) {
    const currentUrl = new URL(window.location.href);
    if (status) {
        currentUrl.searchParams.set('status', status);
    } else {
        currentUrl.searchParams.delete('status');
    }
    window.location.href = currentUrl.toString();
}

function searchOrders(query) {
    const currentUrl = new URL(window.location.href);
    if (query) {
        currentUrl.searchParams.set('search', query);
    } else {
        currentUrl.searchParams.delete('search');
    }
    window.location.href = currentUrl.toString();
}
</script>

<?php require_once 'footer.php'; ?>



