<?php
session_start();
require_once 'database.php';

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý cập nhật giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $remove = isset($_POST['remove']) ? intval($_POST['remove']) : 0;
    
    // Xóa sản phẩm khỏi giỏ hàng
    if ($remove) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    } 
    // Cập nhật số lượng
    else if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    // Cập nhật tổng số sản phẩm trong giỏ hàng
    $cart_count = 0;
    foreach ($_SESSION['cart'] as $qty) {
        $cart_count += $qty;
    }
    $_SESSION['cart_count'] = $cart_count;
    
    // Tính lại tổng tiền
    $total_price = 0;
    $subtotal = 0;
    
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $product = getProductById($pid);
        if ($product) {
            if ($pid == $product_id) {
                $subtotal = number_format($product['price'] * $quantity) . ' đ';
            }
            $total_price += $product['price'] * $qty;
        }
    }
    
    // Trả về kết quả
    echo json_encode([
        'success' => true,
        'cart_count' => $cart_count,
        'subtotal' => $subtotal,
        'total' => number_format($total_price) . ' đ',
        'reload' => false
    ]);
} else {
    // Trả về lỗi nếu không phải phương thức POST
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không hợp lệ'
    ]);
}
?>
