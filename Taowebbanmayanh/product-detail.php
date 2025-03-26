<?php
require_once 'database.php';
require_once 'header.php';

// Lấy thông tin sản phẩm từ ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = getProductById($product_id);

// Nếu không tìm thấy sản phẩm, chuyển hướng về trang chủ
if (!$product) {
    header('Location: index.php');
    exit;
}

// Lấy sản phẩm liên quan
$related_products = getRelatedProducts($product_id, $product['category']);
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="index.php" class="text-gray-700 hover:text-blue-600">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="#" class="text-gray-700 hover:text-blue-600">
                            <?php echo $product['category']; ?>
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-500"><?php echo $product['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Hình ảnh sản phẩm -->
        <div>
            <div class="border rounded-lg p-4 mb-4">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-auto object-contain">
            </div>
            <div class="grid grid-cols-5 gap-2">
                <?php for($i = 0; $i < 5; $i++): ?>
                <div class="border rounded-lg p-2 cursor-pointer hover:border-blue-500">
                    <img src="<?php echo $product['image']; ?>" alt="Thumbnail" class="w-full h-auto object-contain">
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div>
            <h1 class="text-2xl font-bold mb-4"><?php echo $product['name']; ?></h1>
            
            <div class="flex items-center gap-2 mb-4">
                <?php for($i = 0; $i < 5; $i++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="<?php echo $i < $product['rating'] ? 'gold' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.  stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17.91 14.14 19.27 21.02 12 17.77 4.73 21.02 6.09 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <?php endfor; ?>
                <span>(<?php echo $product['rating_count']; ?> đánh giá)</span>
            </div>
            
            <div class="mb-6">
                <div class="text-3xl font-bold text-red-600 mb-2"><?php echo number_format($product['price']); ?> đ</div>
                <?php if (isset($product['old_price']) && $product['old_price'] > 0): ?>
                <div class="flex items-center gap-2">
                    <span class="line-through text-gray-500"><?php echo number_format($product['old_price']); ?> đ</span>
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded">Tiết kiệm <?php echo number_format($product['old_price'] - $product['price']); ?> đ</span>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="border-t border-b py-4 mb-6">
                <h3 class="font-bold mb-2">Thông số kỹ thuật:</h3>
                <ul class="space-y-2">
                    <?php foreach($product['specs'] as $key => $value): ?>
                    <li class="flex">
                        <span class="w-1/3 text-gray-600"><?php echo $key; ?>:</span>
                        <span class="w-2/3 font-medium"><?php echo $value; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="mb-6">
                <h3 class="font-bold mb-2">Quà tặng kèm:</h3>
                <?php if (isset($product['gift']) && $product['gift'] > 0): ?>
                <div class="flex items-center gap-2 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path><path d="M12 8l4 4 4-4"></path><path d="M16 4v8"></path><path d="M8 16l-4-4 4-4"></path><path d="M4 12h16"></path></svg>
                    <span>Phiếu quà tặng trị giá <?php echo number_format($product['gift']); ?>đ</span>
                </div>
                <?php else: ?>
                <p class="text-gray-600">Không có quà tặng kèm</p>
                <?php endif; ?>
            </div>
            
            <div class="flex gap-4 mb-6">
                <div class="flex border rounded-md">
                    <button class="px-3 py-2 border-r hover:bg-gray-100">-</button>
                    <input type="number" value="1" min="1" class="w-16 text-center">
                    <button class="px-3 py-2 border-l hover:bg-gray-100">+</button>
                </div>
                <button class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 flex-grow">Thêm vào giỏ hàng</button>
            </div>
            
            <div class="flex gap-4">
                <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                    Yêu thích
                </button>
                <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    So sánh
                </button>
            </div>
        </div>
    </div>

    <!-- Mô tả sản phẩm -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-4">Mô tả sản phẩm</h2>
        <div class="prose max-w-none">
            <?php echo $product['description']; ?>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Sản phẩm liên quan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($related_products as $related): ?>
            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <a href="product-detail.php?id=<?php echo $related['id']; ?>">
                    <div class="p-4 flex justify-center">
                        <img src="<?php echo $related['image']; ?>" alt="<?php echo $related['name']; ?>" class="h-48 object-contain">
                    </div>
                    <div class="p-4">
                        <h3 class="text-blue-600 hover:text-blue-800 mb-2"><?php echo $related['name']; ?></h3>
                        <div class="font-bold text-xl mb-1"><?php echo number_format($related['price']); ?> đ</div>
                        <?php if (isset($related['old_price']) && $related['old_price'] > 0): ?>
                        <div class="flex gap-2 items-center">
                            <span class="line-through text-gray-500"><?php echo number_format($related['old_price']); ?> đ</span>
                            <span class="text-red-600 font-medium">GIẢM <?php echo number_format($related['old_price'] - $related['price']); ?> đ</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

