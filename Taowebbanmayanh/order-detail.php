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

// Lấy ID đơn hàng
$order_id = isset($_GET['id']) ? $_GET['id'] : '';

// Nếu không có ID đơn hàng, chuyển hướng về trang đơn hàng
if (empty($order_id)) {
    header('Location: orders.php');
    exit;
}

// Dữ liệu mẫu cho đơn hàng chi tiết
$order = [
    'id' => 'DH123456',
    'date' => '10/05/2025',
    'status' => 'delivered',
    'status_text' => 'Đã giao hàng',
    'total' => 44490000,
    'subtotal' => 44490000,
    'shipping' => 0,
    'discount' => 0,
    'payment_method' => 'Thanh toán khi nhận hàng (COD)',
    'shipping_address' => [
        'name' => $user_name,
        'phone' => '0987654321',
        'address' => '123 Nguyễn Văn Linh, Phường Tân Phong, Quận 7',
        'city' => 'TP. Hồ Chí Minh'
    ],
    'products' => [
        [
            'id' => 1,
            'name' => 'Máy Ảnh Sony Alpha 7C II (Silver) | Chính Hãng',
            'image' => '/placeholder.svg?height=80&width=80',
            'price' => 44490000,
            'quantity' => 1
        ]
    ],
    'timeline' => [
        [
            'date' => '10/05/2025 15:30',
            'title' => 'Đã giao hàng',
            'description' => 'Đơn hàng đã được giao thành công.',
            'active' => true
        ],
        [
            'date' => '09/05/2025 10:15',
            'title' => 'Đang vận chuyển',
            'description' => 'Đơn hàng đang được vận chuyển đến địa chỉ của bạn.',
            'active' => true
        ],
        [
            'date' => '08/05/2025 14:20',
            'title' => 'Đang xử lý',
            'description' => 'Đơn hàng của bạn đang được chuẩn bị.',
            'active' => true
        ],
        [
            'date' => '08/05/2025 09:45',
            'title' => 'Đã xác nhận',
            'description' => 'Đơn hàng của bạn đã được xác nhận.',
            'active' => true
        ],
        [
            'date' => '08/05/2025 09:30',
            'title' => 'Chờ xác nhận',
            'description' => 'Đơn hàng của bạn đang chờ xác nhận.',
            'active' => true
        ]
    ]
];

// Nếu ID đơn hàng không phải là DH123456, sử dụng dữ liệu mẫu khác
if ($order_id != 'DH123456') {
    $order = [
        'id' => $order_id,
        'date' => '05/05/2025',
        'status' => 'processing',
        'status_text' => 'Đang xử lý',
        'total' => 83980000,
        'subtotal' => 83980000,
        'shipping' => 0,
        'discount' => 0,
        'payment_method' => 'Chuyển khoản ngân hàng',
        'shipping_address' => [
            'name' => $user_name,
            'phone' => '0987654321',
            'address' => '456 Lê Lợi, Phường Bến Nghé, Quận 1',
            'city' => 'TP. Hồ Chí Minh'
        ],
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
        ],
        'timeline' => [
            [
                'date' => '05/05/2025 14:20',
                'title' => 'Đang xử lý',
                'description' => 'Đơn hàng của bạn đang được chuẩn bị.',
                'active' => true
            ],
            [
                'date' => '05/05/2025 09:45',
                'title' => 'Đã xác nhận',
                'description' => 'Đơn hàng của bạn đã được xác nhận.',
                'active' => true
            ],
            [
                'date' => '05/05/2025 09:30',
                'title' => 'Chờ xác nhận',
                'description' => 'Đơn hàng của bạn đang chờ x��c nhận.',
                'active' => true
            ]
        ]
    ];
}
?>

<div class="container">
    <div class="orders-page">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &gt; 
            <a href="orders.php">Đơn hàng của tôi</a> &gt; 
            <span>Chi tiết đơn hàng #<?php echo $order['id']; ?></span>
        </div>
        
        <div class="order-detail-container">
            <div class="order-detail-header">
                <h1>Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>
                <div class="order-detail-status status-<?php echo $order['status']; ?>"><?php echo $order['status_text']; ?></div>
            </div>
            
            <div class="order-info-grid">
                <div class="order-info-card">
                    <h3>Thông tin đơn hàng</h3>
                    <div class="info-item">
                        <div class="info-item-label">Mã đơn hàng:</div>
                        <div class="info-item-value"><?php echo $order['id']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Ngày đặt hàng:</div>
                        <div class="info-item-value"><?php echo $order['date']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Trạng thái:</div>
                        <div class="info-item-value"><?php echo $order['status_text']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Phương thức thanh toán:</div>
                        <div class="info-item-value"><?php echo $order['payment_method']; ?></div>
                    </div>
                </div>
                
                <div class="order-info-card">
                    <h3>Địa chỉ giao hàng</h3>
                    <div class="info-item">
                        <div class="info-item-label">Người nhận:</div>
                        <div class="info-item-value"><?php echo $order['shipping_address']['name']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Số điện thoại:</div>
                        <div class="info-item-value"><?php echo $order['shipping_address']['phone']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Địa chỉ:</div>
                        <div class="info-item-value"><?php echo $order['shipping_address']['address']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Thành phố:</div>
                        <div class="info-item-value"><?php echo $order['shipping_address']['city']; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="order-timeline">
                <h3>Trạng thái đơn hàng</h3>
                <div class="timeline">
                    <?php foreach ($order['timeline'] as $timeline_item): ?>
                    <div class="timeline-item <?php echo $timeline_item['active'] ? 'active' : ''; ?>">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-date"><?php echo $timeline_item['date']; ?></div>
                            <div class="timeline-title"><?php echo $timeline_item['title']; ?></div>
                            <div class="timeline-description"><?php echo $timeline_item['description']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <h3>Sản phẩm đã đặt</h3>
            <table class="order-products-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['products'] as $product): ?>
                    <tr>
                        <td>
                            <div class="product-cell">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                <div class="product-cell-info">
                                    <h4><a href="product-detail.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h4>
                                </div>
                            </div>
                        </td>
                        <td><?php echo number_format($product['price']); ?> đ</td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo number_format($product['price'] * $product['quantity']); ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="order-summary-card">
                <h3>Tổng cộng</h3>
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span><?php echo number_format($order['subtotal']); ?> đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span><?php echo $order['shipping'] > 0 ? number_format($order['shipping']) . ' đ' : 'Miễn phí'; ?></span>
                </div>
                <?php if ($order['discount'] > 0): ?>
                <div class="summary-row">
                    <span>Giảm giá:</span>
                    <span>-<?php echo number_format($order['discount']); ?> đ</span>
                </div>
                <?php endif; ?>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <span><?php echo number_format($order['total']); ?> đ</span>
                </div>
            </div>
            
            <div class="order-actions-footer">
                <a href="orders.php" class="back-to-orders">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách đơn hàng
                </a>
                
                <div class="order-buttons">
                    <?php if ($order['status'] == 'delivered'): ?>
                    <a href="#" class="btn-reorder" onclick="reorderItems(); return false;">Đặt lại</a>
                    <?php elseif ($order['status'] == 'pending' || $order['status'] == 'processing'): ?>
                    <a href="#" class="btn-cancel-order" onclick="cancelOrder(); return false;">Hủy đơn hàng</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function reorderItems() {
    if (confirm('Bạn có muốn đặt lại đơn hàng này không?')) {
        // Trong thực tế, bạn sẽ gửi AJAX request để thêm các sản phẩm vào giỏ hàng
        alert('Đã thêm các sản phẩm vào giỏ hàng!');
        window.location.href = 'cart.php';
    }
}

function cancelOrder() {
    if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
        // Trong thực tế, bạn sẽ gửi AJAX request để hủy đơn hàng
        alert('Đơn hàng đã được hủy thành công!');
        window.location.href = 'orders.php';
    }
}
</script>

<?php require_once 'footer.php'; ?>

