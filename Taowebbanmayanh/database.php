<?php
// Kết nối đến cơ sở dữ liệu
function connectDB() {
    // Thông tin kết nối database
    $host = 'localhost';
    $dbname = 'camera_shop';
    $username = 'root';
    $password = '';
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        // Nếu chưa có database, tạo dữ liệu mẫu
        return null;
    }
}

// Lấy danh sách sản phẩm
function getProducts($category = '', $price_filter = '', $sort = 'default') {
    $conn = connectDB();
    
    // Nếu không có kết nối database, trả về dữ liệu mẫu
    if (!$conn) {
        return getSampleProducts($category, $price_filter, $sort);
    }
    
    // Truy vấn SQL với bộ lọc
    $sql = "SELECT * FROM products";
    $conditions = [];
    
    if ($category) {
        $conditions[] = "category = :category";
    }
    
    if ($price_filter) {
        switch ($price_filter) {
            case 'under30':
                $conditions[] = "price < 30000000";
                break;
            case '30-40':
                $conditions[] = "price >= 30000000 AND price <= 40000000";
                break;
            case '40-60':
                $conditions[] = "price >= 40000000 AND price <= 60000000";
                break;
            case 'over60':
                $conditions[] = "price > 60000000";
                break;
        }
    }
    
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    
    // Sắp xếp
    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY price DESC";
            break;
        case 'name_asc':
            $sql .= " ORDER BY name ASC";
            break;
        case 'name_desc':
            $sql .= " ORDER BY name DESC";
            break;
        default:
            $sql .= " ORDER BY id ASC";
            break;
    }
    
    $stmt = $conn->prepare($sql);
    
    if ($category) {
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy thông tin sản phẩm theo ID
function getProductById($id) {
    $conn = connectDB();
    
    // Nếu không có kết nối database, trả về dữ liệu mẫu
    if (!$conn) {
        return getSampleProductById($id);
    }
    
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lấy sản phẩm liên quan
function getRelatedProducts($id, $category, $limit = 4) {
    $conn = connectDB();
    
    // Nếu không có kết nối database, trả về dữ liệu mẫu
    if (!$conn) {
        return getSampleRelatedProducts($id, $category, $limit);
    }
    
    $sql = "SELECT * FROM products WHERE category = :category AND id != :id LIMIT :limit";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Đăng ký người dùng mới
function registerUser($name, $email, $password) {
    $conn = connectDB();
    
    // Nếu không có kết nối database, trả về false
    if (!$conn) {
        return false;
    }
    
    // Kiểm tra email đã tồn tại chưa
    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return ['success' => false, 'message' => 'Email đã được sử dụng'];
    }
    
    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Thêm người dùng mới
    $sql = "INSERT INTO users (name, email, password, created_at) VALUES (:name, :email, :password, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        return ['success' => true, 'user_id' => $conn->lastInsertId()];
    } else {
        return ['success' => false, 'message' => 'Đăng ký thất bại'];
    }
}

// Đăng nhập
function loginUser($email, $password) {
    $conn = connectDB();
    
    // Nếu không có kết nối database, kiểm tra với dữ liệu mẫu
    if (!$conn) {
        // Dữ liệu mẫu cho đăng nhập
        $sample_users = [
            [
                'id' => 1,
                'name' => 'Người dùng mẫu',
                'email' => 'user@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
        ];
        
        foreach ($sample_users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                return ['success' => true, 'user' => $user];
            }
        }
        
        return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
    }
    
    // Tìm người dùng theo email
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        return ['success' => true, 'user' => $user];
    } else {
        return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
    }
}

// Dữ liệu mẫu cho sản phẩm
function getSampleProducts($category = '', $price_filter = '', $sort = 'default') {
    $products = [
        // Máy ảnh
        [
            'id' => 1,
            'name' => 'Máy Ảnh Sony Alpha 7C II (Silver) | Chính Hãng',
            'price' => 44490000,
            'old_price' => 50990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'camera',
            'gift' => 2480000,
            'hot' => false,
            'rating' => 4.5,
            'rating_count' => 7,
            'description' => 'Máy ảnh Sony Alpha 7C II là phiên bản nâng cấp của dòng máy ảnh mirrorless full-frame nhỏ gọn nhất của Sony. Với cảm biến CMOS Exmor R 33MP, bộ xử lý hình ảnh BIONZ XR, khả năng chụp liên tiếp 10fps và quay video 4K 60p, Alpha 7C II mang đến hiệu suất cao trong một thân máy nhỏ gọn.'
        ],
        [
            'id' => 2,
            'name' => 'Máy ảnh Canon EOS R10 + Lens RF-S 18-45mm F4.5-6.3 IS STM | Chính Hãng',
            'price' => 21990000,
            'old_price' => 28330000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'camera',
            'gift' => 0,
            'hot' => false,
            'rating' => 4.2,
            'rating_count' => 5,
            'description' => 'Canon EOS R10 là máy ảnh mirrorless APS-C nhỏ gọn với cảm biến 24.2MP, bộ xử lý DIGIC X, quay video 4K 30p và chụp liên tiếp 15fps. Kết hợp với ống kính RF-S 18-45mm F4.5-6.3 IS STM nhỏ gọn, đây là bộ máy ảnh lý tưởng cho người mới bắt đầu và nhiếp ảnh gia đường phố.'
        ],
        [
            'id' => 3,
            'name' => 'Máy ảnh Sony Alpha A7 Mark IV + Lens 28-70mm f/3.5-5.6 | Chính hàng',
            'price' => 54490000,
            'old_price' => 59990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'camera',
            'gift' => 890000,
            'hot' => false,
            'rating' => 5,
            'rating_count' => 7,
            'description' => 'Sony Alpha A7 IV là máy ảnh mirrorless full-frame thế hệ mới với cảm biến 33MP, bộ xử lý BIONZ XR, quay video 4K 60p và hệ thống lấy nét tự động tiên tiến. Kết hợp với ống kính 28-70mm f/3.5-5.6, đây là bộ máy ảnh đa năng phù hợp cho cả nhiếp ảnh và quay phim.'
        ],
        [
            'id' => 4,
            'name' => 'Máy Ảnh Canon EOS R10 + Lens RF-S 18-150mm f/3.5-6.3 IS STM | Chính Hãng',
            'price' => 30990000,
            'old_price' => 36380000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'camera',
            'gift' => 0,
            'hot' => false,
            'rating' => 4.3,
            'rating_count' => 6,
            'description' => 'Canon EOS R10 kết hợp với ống kính RF-S 18-150mm f/3.5-6.3 IS STM đa dụng, cho phép bạn chụp từ góc rộng đến tele với một ống kính duy nhất. Với cảm biến 24.2MP, bộ xử lý DIGIC X và khả năng quay video 4K, đây là bộ máy ảnh linh hoạt cho nhiều thể loại nhiếp ảnh.'
        ],
        
        // Laptop
        [
            'id' => 5,
            'name' => 'Laptop Dell XPS 13 Plus 9320 (i7-1260P, 16GB, 512GB, Intel Iris Xe, 13.4" 3.5K OLED)',
            'price' => 39990000,
            'old_price' => 45990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'laptop',
            'gift' => 1500000,
            'hot' => true,
            'rating' => 4.8,
            'rating_count' => 12,
            'description' => 'Dell XPS 13 Plus 9320 là laptop cao cấp với thiết kế mỏng nhẹ, bàn phím haptic và touchpad vô hình. Trang bị CPU Intel Core i7-1260P, RAM 16GB LPDDR5, SSD 512GB và màn hình OLED 3.5K sắc nét, đây là lựa chọn hoàn hảo cho người dùng đòi hỏi hiệu suất cao và trải nghiệm hình ảnh tuyệt vời.'
        ],
        [
            'id' => 6,
            'name' => 'Laptop Apple MacBook Air M2 (8GB RAM, 256GB SSD, 13.6" Liquid Retina)',
            'price' => 27990000,
            'old_price' => 32990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'laptop',
            'gift' => 0,
            'hot' => true,
            'rating' => 4.9,
            'rating_count' => 18,
            'description' => 'MacBook Air M2 là laptop mỏng nhẹ với thiết kế mới, chip Apple M2 mạnh mẽ, màn hình Liquid Retina 13.6 inch sắc nét và thời lượng pin lên đến 18 giờ. Với hiệu suất vượt trội và tính di động cao, đây là lựa chọn lý tưởng cho công việc và giải trí hàng ngày.'
        ],
        [
            'id' => 7,
            'name' => 'Laptop Asus ROG Zephyrus G14 (Ryzen 9 6900HS, 16GB, 1TB, RTX 3060, 14" QHD 120Hz)',
            'price' => 35990000,
            'old_price' => 41990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'laptop',
            'gift' => 2000000,
            'hot' => true,
            'rating' => 4.7,
            'rating_count' => 15,
            'description' => 'ASUS ROG Zephyrus G14 là laptop gaming mỏng nhẹ với CPU AMD Ryzen 9 6900HS, GPU NVIDIA RTX 3060, RAM 16GB DDR5 và SSD 1TB. Màn hình 14" QHD 120Hz với độ phủ màu 100% DCI-P3 mang đến trải nghiệm chơi game và làm việc sáng tạo tuyệt vời trong một thiết kế nhỏ gọn.'
        ],
        [
            'id' => 8,
            'name' => 'Laptop MSI Creator Z16 (i7-12700H, 32GB, 1TB, RTX 3060, 16" QHD+ 120Hz)',
            'price' => 45990000,
            'old_price' => 52990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'laptop',
            'gift' => 3000000,
            'hot' => false,
            'rating' => 4.6,
            'rating_count' => 9,
            'description' => 'MSI Creator Z16 là laptop cao cấp dành cho người sáng tạo nội dung với CPU Intel Core i7-12700H, GPU NVIDIA RTX 3060, RAM 32GB và SSD 1TB. Màn hình 16" QHD+ 120Hz với độ phủ màu 100% DCI-P3 và hệ thống âm thanh cao cấp mang đến trải nghiệm làm việc và giải trí đỉnh cao.'
        ],
        
        // Ống kính
        [
            'id' => 9,
            'name' => 'Ống kính Sony FE 24-70mm f/2.8 GM II | Chính hãng',
            'price' => 49990000,
            'old_price' => 54990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'lens',
            'gift' => 0,
            'hot' => false,
            'rating' => 4.9,
            'rating_count' => 11,
            'description' => 'Sony FE 24-70mm f/2.8 GM II là ống kính zoom tiêu chuẩn cao cấp thế hệ thứ hai với thiết kế nhỏ gọn hơn, nhẹ hơn và hiệu suất quang học vượt trội. Với khẩu độ f/2.8 cố định, động cơ lấy nét XD Linear và các phần tử quang học tiên tiến, đây là ống kính đa năng hoàn hảo cho nhiếp ảnh chuyên nghiệp.'
        ],
        [
            'id' => 10,
            'name' => 'Ống kính Canon RF 15-35mm f/2.8L IS USM | Chính hãng',
            'price' => 53990000,
            'old_price' => 57990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'lens',
            'gift' => 0,
            'hot' => false,
            'rating' => 4.8,
            'rating_count' => 8,
            'description' => 'Canon RF 15-35mm f/2.8L IS USM là ống kính zoom góc rộng cao cấp dòng L với khẩu độ f/2.8 cố định, chống rung quang học 5 stop và động cơ lấy nét USM siêu âm. Với dải tiêu cự từ góc siêu rộng 15mm đến góc rộng tiêu chuẩn 35mm, đây là ống kính lý tưởng cho phong cảnh, kiến trúc và quay phim.'
        ],
        
        // Phụ kiện
        [
            'id' => 11,
            'name' => 'Chân máy ảnh Manfrotto Befree Advanced Carbon Fiber | Chính hãng',
            'price' => 7990000,
            'old_price' => 8990000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'accessory',
            'gift' => 0,
            'hot' => false,
            'rating' => 4.7,
            'rating_count' => 14,
            'description' => 'Manfrotto Befree Advanced Carbon Fiber là chân máy ảnh cao cấp làm từ sợi carbon nhẹ và bền. Với khả năng chịu tải 8kg, chiều cao tối đa 150cm và trọng lượng chỉ 1.25kg khi gập lại còn 40cm, đây là chân máy lý tưởng cho nhiếp ảnh phong cảnh và du lịch.'
        ],
        [
            'id' => 12,
            'name' => 'Đèn flash Godox V1 cho Sony | Chính hãng',
            'price' => 4990000,
            'old_price' => 5490000,
            'image' => '/placeholder.svg?height=300&width=300',
            'category' => 'accessory',
            'gift' => 0,
            'hot' => true,
            'rating' => 4.6,
            'rating_count' => 13,
            'description' => 'Godox V1 là đèn flash cao cấp với đầu tròn, hỗ trợ TTL, HSS 1/8000s và pin lithium tích hợp. Với công suất GN 60, thời gian tái sạc nhanh 1.5 giây và khả năng điều khiển không dây 2.4GHz, đây là đèn flash linh hoạt cho nhiều thể loại nhiếp ảnh từ chân dung đến sự kiện.'
        ]
    ];
    
    // Lọc theo danh mục
    if ($category) {
        $products = array_filter($products, function($product) use ($category) {
            return $product['category'] == $category;
        });
    }
    
    // Lọc theo giá
    if ($price_filter) {
        $filtered_products = [];
        foreach ($products as $product) {
            switch ($price_filter) {
                case 'under30':
                    if ($product['price'] < 30000000) {
                        $filtered_products[] = $product;
                    }
                    break;
                case '30-40':
                    if ($product['price'] >= 30000000 && $product['price'] <= 40000000) {
                        $filtered_products[] = $product;
                    }
                    break;
                case '40-60':
                    if ($product['price'] >= 40000000 && $product['price'] <= 60000000) {
                        $filtered_products[] = $product;
                    }
                    break;
                case 'over60':
                    if ($product['price'] > 60000000) {
                        $filtered_products[] = $product;
                    }
                    break;
            }
        }
        $products = $filtered_products;
    }
    
    // Sắp xếp
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
    
    return array_values($products);
}

// Lấy thông tin sản phẩm mẫu theo ID
function getSampleProductById($id) {
    $products = getSampleProducts();
    
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            // Thêm thông tin chi tiết cho sản phẩm
            $product['specs'] = [
                'Thương hiệu' => explode(' ', $product['name'])[1],
                'Model' => explode(' ', $product['name'])[2] . ' ' . (isset(explode(' ', $product['name'])[3]) ? explode(' ', $product['name'])[3] : ''),
                'Bảo hành' => '24 tháng',
                'Xuất xứ' => 'Chính hãng'
            ];
            
            // Thêm thông số kỹ thuật dựa vào danh mục
            if ($product['category'] == 'camera') {
                $product['specs'] = array_merge($product['specs'], [
                    'Cảm biến' => 'CMOS Full-frame 33MP',
                    'Bộ xử lý' => 'BIONZ XR / DIGIC X',
                    'Dải ISO' => '100-51200 (mở rộng: 50-204800)',
                    'Tốc độ màn trập' => '1/8000 - 30 giây',
                    'Tốc độ chụp liên tiếp' => 'Lên đến 10 fps',
                    'Màn hình' => 'LCD 3.0 inch, 1.04 triệu điểm',
                    'Khe thẻ nhớ' => 'SD/SDHC/SDXC (UHS-II)',
                    'Pin' => 'NP-FZ100, khoảng 500 ảnh',
                    'Kích thước' => '124 x 71.1 x 63.8 mm',
                    'Trọng lượng' => 'Khoảng 509g (chỉ thân máy)'
                ]);
            } else if ($product['category'] == 'laptop') {
                $product['specs'] = array_merge($product['specs'], [
                    'CPU' => strpos($product['name'], 'Ryzen') !== false ? 'AMD Ryzen 9' : 'Intel Core i7',
                    'RAM' => strpos($product['name'], '32GB') !== false ? '32GB DDR5' : '16GB DDR5',
                    'Ổ cứng' => strpos($product['name'], '1TB') !== false ? 'SSD 1TB NVMe' : 'SSD 512GB NVMe',
                    'Card đồ họa' => strpos($product['name'], 'RTX') !== false ? 'NVIDIA GeForce RTX 3060 6GB' : 'Intel Iris Xe Graphics',
                    'Màn hình' => strpos($product['name'], 'OLED') !== false ? 'OLED 3.5K (3456 x 2160)' : 'IPS LCD QHD+ (2560 x 1600)',
                    'Kết nối' => 'Thunderbolt 4, USB-C, USB-A, HDMI, Wi-Fi 6E, Bluetooth 5.2',
                    'Hệ điều hành' => strpos($product['name'], 'MacBook') !== false ? 'macOS' : 'Windows 11 Home',
                    'Pin' => 'Khoảng 10-12 giờ sử dụng',
                    'Kích thước' => '320 x 220 x 16.8 mm',
                    'Trọng lượng' => 'Khoảng 1.5kg'
                ]);
            } else if ($product['category'] == 'lens') {
                $product['specs'] = array_merge($product['specs'], [
                    'Tiêu cự' => strpos($product['name'], '24-70mm') !== false ? '24-70mm' : '15-35mm',
                    'Khẩu độ tối đa' => 'f/2.8 cố định',
                    'Cấu trúc quang học' => '18 thấu kính trong 14 nhóm',
                    'Số lá khẩu' => '11 lá (khẩu tròn)',
                    'Khoảng cách lấy nét tối thiểu' => '0.38m',
                    'Hệ số phóng đại tối đa' => '0.24x',
                    'Kích thước filter' => '82mm',
                    'Chống rung' => 'Có (5 stops)',
                    'Kích thước' => '87.8 x 120mm',
                    'Trọng lượng' => 'Khoảng 695g'
                ]);
            } else if ($product['category'] == 'accessory') {
                $product['specs'] = array_merge($product['specs'], [
                    'Loại' => strpos($product['name'], 'Chân máy') !== false ? 'Chân máy ảnh' : 'Đèn flash',
                    'Vật liệu' => strpos($product['name'], 'Carbon') !== false ? 'Carbon Fiber' : 'Nhựa và kim loại',
                    'Khả năng chịu tải' => strpos($product['name'], 'Chân máy') !== false ? '8kg' : 'N/A',
                    'Chiều cao tối đa' => strpos($product['name'], 'Chân máy') !== false ? '150cm' : 'N/A',
                    'Chiều dài khi gập' => strpos($product['name'], 'Chân máy') !== false ? '40cm' : 'N/A',
                    'Công suất' => strpos($product['name'], 'flash') !== false ? 'GN 60' : 'N/A',
                    'Thời gian tái sạc' => strpos($product['name'], 'flash') !== false ? '1.5 giây' : 'N/A',
                    'Kết nối không dây' => strpos($product['name'], 'flash') !== false ? '2.4GHz' : 'N/A',
                    'Kích thước' => strpos($product['name'], 'Chân máy') !== false ? '40 x 10 x 10 cm (khi gập)' : '76 x 112 x 93 mm',
                    'Trọng lượng' => strpos($product['name'], 'Chân máy') !== false ? '1.25kg' : '420g'
                ]);
            }
            
            return $product;
        }
    }
    
    return null;
}

// Lấy sản phẩm liên quan mẫu
function getSampleRelatedProducts($id, $category, $limit = 4) {
    $products = getSampleProducts();
    $related = [];
    $count = 0;
    
    foreach ($products as $product) {
        if ($product['id'] != $id && $product['category'] == $category && $count < $limit) {
            $related[] = $product;
            $count++;
        }
    }
    
    // Nếu không đủ sản phẩm cùng danh mục, lấy thêm sản phẩm khác
    if ($count < $limit) {
        foreach ($products as $product) {
            if ($product['id'] != $id && !in_array($product, $related) && $count < $limit) {
                $related[] = $product;
                $count++;
            }
        }
    }
    
    return $related;
}
?>

