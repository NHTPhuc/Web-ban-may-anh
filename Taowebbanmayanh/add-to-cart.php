<?php
session_start();
require_once 'database.php';

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Kiểm tra sản phẩm tồn tại
    $product = getProductById($product_id);
    
    if ($product) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        // Cập nhật tổng số sản phẩm trong giỏ hàng
        $cart_count = 0;
        foreach ($_SESSION['cart'] as $qty) {
            $cart_count += $qty;
        }
        $_SESSION['cart_count'] = $cart_count;
        
        // Trả về kết quả thành công
        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => $cart_count
        ]);
    } else {
        // Trả về lỗi nếu sản phẩm không tồn tại
        echo json_encode([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại'
        ]);
    }
} else {
    // Trả về lỗi nếu không phải phương thức POST
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không hợp lệ'
    ]);
}
?>
