<?php
session_start();
require_once 'database.php';
require_once 'header.php';

// Lấy danh sách tin tức
$news = [
    [
        'id' => 1,
        'title' => 'Sony ra mắt máy ảnh Alpha 7C II với nhiều cải tiến đáng giá',
        'summary' => 'Sony vừa chính thức giới thiệu máy ảnh mirrorless full-frame Alpha 7C II với nhiều nâng cấp về cảm biến, bộ xử lý và khả năng quay video.',
        'content' => '<p>Sony vừa chính thức giới thiệu máy ảnh mirrorless full-frame Alpha 7C II, phiên bản nâng cấp của dòng máy ảnh nhỏ gọn Alpha 7C. Mẫu máy ảnh mới được trang bị cảm biến CMOS Exmor R 33MP, bộ xử lý hình ảnh BIONZ XR mới nhất, khả năng chụp liên tiếp 10fps và quay video 4K 60p.</p>
                      <p>Alpha 7C II vẫn giữ thiết kế nhỏ gọn đặc trưng của dòng 7C, nhưng được bổ sung thêm nhiều tính năng cao cấp từ dòng Alpha 7 IV như hệ thống lấy nét tự động AI với khả năng nhận diện mắt người, động vật và chim. Máy cũng được trang bị màn hình LCD xoay lật linh hoạt, khe cắm thẻ nhớ kép và pin dung lượng cao.</p>
                      <p>Đặc biệt, Alpha 7C II có khả năng kết nối không dây nhanh chóng thông qua Wi-Fi 6 và Bluetooth 5.0, cho phép truyền ảnh trực tiếp đến điện thoại thông minh hoặc máy tính bảng. Máy cũng hỗ trợ quay video 10-bit 4:2:2 nội bộ và S-Log3 cho các nhà làm phim.</p>
                      <p>Sony Alpha 7C II sẽ được bán ra thị trường từ tháng 6/2025 với giá khởi điểm 44.490.000 đồng cho thân máy và 50.990.000 đồng cho bộ kit kèm ống kính FE 28-60mm f/4-5.6.</p>',
        'image' => '/placeholder.svg?height=400&width=600',
        'category' => 'Sản phẩm mới',
        'author' => 'Admin VJShop',
        'date' => '05/05/2025',
        'views' => 1250,
        'tags' => ['Sony', 'Alpha', 'Máy ảnh', 'Mirrorless']
    ],
    [
        'id' => 2,
        'title' => 'Hướng dẫn chọn mua laptop gaming phù hợp với nhu cầu và ngân sách',
        'summary' => 'Bài viết chia sẻ những kinh nghiệm và lưu ý quan trọng khi chọn mua laptop gaming, giúp bạn tìm được chiếc máy phù hợp nhất.',
        'content' => '<p>Chọn mua một chiếc laptop gaming phù hợp không phải là điều đơn giản, đặc biệt khi thị trường có quá nhiều lựa chọn với mức giá và cấu hình đa dạng. Bài viết này sẽ giúp bạn hiểu rõ những yếu tố quan trọng cần cân nhắc khi chọn mua laptop gaming.</p>
                      <h2>1. Xác định ngân sách</h2>
                      <p>Đây là yếu tố đầu tiên và quan trọng nhất. Laptop gaming có giá từ khoảng 20 triệu đến hơn 100 triệu đồng. Xác định rõ ngân sách sẽ giúp bạn thu hẹp phạm vi lựa chọn và tập trung vào những mẫu máy phù hợp.</p>
                      <h2>2. Hiểu rõ nhu cầu sử dụng</h2>
                      <p>Bạn chơi những game gì? Esports như LMHT, CSGO hay các game AAA đòi hỏi cấu hình cao như Cyberpunk 2077? Bạn có sử dụng máy cho công việc đồ họa, render video không? Hiểu rõ nhu cầu sẽ giúp bạn chọn được cấu hình phù hợp.</p>
                      <h2>3. CPU và GPU</h2>
                      <p>Đây là hai thành phần quan trọng nhất của laptop gaming. Hiện nay, các CPU Intel Core i5, i7, i9 thế hệ 12, 13 hoặc AMD Ryzen 5, 7, 9 series 6000, 7000 là lựa chọn tốt. Về GPU, tùy theo ngân sách, bạn có thể chọn từ NVIDIA GTX 1650 đến RTX 4090 hoặc AMD Radeon RX 6000 series.</p>
                      <h2>4. RAM và ổ cứng</h2>
                      <p>Tối thiểu 16GB RAM cho gaming hiện đại, và nên chọn máy có khả năng nâng cấp RAM. Về ổ cứng, SSD NVMe ít nhất 512GB là cần thiết, và nếu có thể, nên chọn máy có thêm khe cắm để mở rộng sau này.</p>
                      <h2>5. Màn hình</h2>
                      <p>Màn hình với tần số quét cao (144Hz trở lên) sẽ mang lại trải nghiệm gaming mượt mà hơn. Độ phân giải Full HD là đủ cho hầu hết người dùng, nhưng nếu ngân sách cho phép, QHD hoặc 4K sẽ mang lại hình ảnh sắc nét hơn.</p>
                      <h2>6. Hệ thống tản nhiệt</h2>
                      <p>Đây là yếu tố quan trọng nhưng thường bị bỏ qua. Laptop gaming mạnh sẽ sinh nhiều nhiệt, vì vậy hệ thống tản nhiệt tốt sẽ giúp máy hoạt động ổn định và bền lâu hơn.</p>
                      <h2>7. Pin và tính di động</h2>
                      <p>Nếu bạn thường xuyên di chuyển, hãy cân nhắc đến trọng lượng máy và thời lượng pin. Tuy nhiên, hầu hết laptop gaming đều có thời lượng pin khiêm tốn và khá nặng.</p>
                      <p>Hy vọng những thông tin trên sẽ giúp bạn chọn được chiếc laptop gaming phù hợp nhất với nhu cầu và ngân sách. Nếu cần tư vấn thêm, đừng ngần ngại liên hệ với đội ngũ chuyên viên tại VJShop.</p>',
        'image' => '/placeholder.svg?height=400&width=600',
        'category' => 'Hướng dẫn',
        'author' => 'Chuyên gia VJShop',
        'date' => '03/05/2025',
        'views' => 980,
        'tags' => ['Laptop', 'Gaming', 'Hướng dẫn', 'Mẹo mua sắm']
    ],
    [
        'id' => 3,
        'title' => '5 mẹo chụp ảnh phong cảnh đẹp như nhiếp ảnh gia chuyên nghiệp',
        'summary' => 'Khám phá những bí quyết giúp bạn chụp được những bức ảnh phong cảnh ấn tượng, ngay cả khi bạn chỉ là người mới bắt đầu.',
        'content' => '<p>Chụp ảnh phong cảnh là một trong những thể loại nhiếp ảnh phổ biến nhất, nhưng để có được những bức ảnh thực sự ấn tượng đòi hỏi nhiều hơn là chỉ đơn giản nhấn nút chụp. Dưới đây là 5 mẹo giúp bạn nâng cao chất lượng ảnh phong cảnh của mình.</p>
                      <h2>1. Chọn thời điểm vàng trong ngày</h2>
                      <p>Ánh sáng là yếu tố quan trọng nhất trong nhiếp ảnh phong cảnh. Thời điểm vàng để chụp ảnh phong cảnh là lúc bình minh và hoàng hôn, khi ánh sáng mềm, ấm và tạo ra những bóng đổ dài đầy nghệ thuật. Tránh chụp vào giữa trưa khi ánh sáng quá gắt, tạo ra những bóng đổ cứng và thiếu chiều sâu.</p>
                      <h2>2. Sử dụng quy tắc 1/3</h2>
                      <p>Thay vì đặt chủ thể chính ở giữa khung hình, hãy áp dụng quy tắc 1/3 bằng cách chia khung hình thành 9 phần bằng nhau và đặt các yếu tố quan trọng của bức ảnh tại các điểm giao nhau hoặc dọc theo các đường chia. Điều này sẽ tạo ra bố cục cân bằng và hấp dẫn hơn.</p>
                      <h2>3. Sử dụng điểm dẫn nhìn</h2>
                      <p>Một bức ảnh phong cảnh tốt thường có một điểm dẫn nhìn để thu hút người xem vào bức ảnh và dẫn mắt họ qua các yếu tố khác nhau. Điểm dẫn nhìn có thể là một con đường, dòng sông, hàng rào, hoặc bất kỳ yếu tố tuyến tính nào khác trong khung cảnh.</p>
                      <h2>4. Thêm yếu tố tiền cảnh</h2>
                      <p>Để tạo chiều sâu cho bức ảnh, hãy thêm một yếu tố tiền cảnh thú vị như tảng đá, cây cối, hoặc hoa. Điều này không chỉ tạo ra cảm giác về không gian ba chiều mà còn giúp người xem cảm nhận được quy mô của phong cảnh.</p>
                      <h2>5. Sử dụng bộ lọc ND và GND</h2>
                      <p>Bộ lọc mật độ trung tính (ND) và mật độ trung tính gradient (GND) là công cụ vô giá cho nhiếp ảnh phong cảnh. Bộ lọc ND giúp bạn sử dụng tốc độ màn trập chậm hơn để tạo hiệu ứng mờ cho nước hoặc mây, trong khi bộ lọc GND giúp cân bằng độ phơi sáng giữa bầu trời sáng và mặt đất tối hơn.</p>
                      <p>Ngoài ra, đừng quên mang theo chân máy để đảm bảo ảnh sắc nét, đặc biệt khi chụp trong điều kiện ánh sáng yếu hoặc khi sử dụng tốc độ màn trập chậm. Và cuối cùng, hãy thử nghiệm với các góc độ và bố cục khác nhau - đôi khi những bức ảnh tốt nhất đến từ những góc nhìn không quen thuộc.</p>
                      <p>Hy vọng những mẹo này sẽ giúp bạn nâng cao kỹ năng chụp ảnh phong cảnh của mình. Hãy nhớ rằng, thực hành là chìa khóa để trở thành một nhiếp ảnh gia giỏi!</p>',
        'image' => '/placeholder.svg?height=400&width=600',
        'category' => 'Mẹo nhiếp ảnh',
        'author' => 'Nhiếp ảnh gia VJShop',
        'date' => '01/05/2025',
        'views' => 1560,
        'tags' => ['Nhiếp ảnh', 'Phong cảnh', 'Mẹo chụp ảnh', 'Kỹ thuật']
    ],
    [
        'id' => 4,
        'title' => 'VJShop khai trương chi nhánh mới tại Đà Nẵng',
        'summary' => 'VJShop mở rộng mạng lưới với chi nhánh mới tại Đà Nẵng, mang đến trải nghiệm mua sắm tuyệt vời cho khách hàng miền Trung.',
        'content' => '<p>VJShop vừa chính thức khai trương chi nhánh mới tại thành phố Đà Nẵng vào ngày 01/05/2025, đánh dấu bước phát triển quan trọng trong chiến lược mở rộng mạng lưới của công ty.</p>
                      <p>Tọa lạc tại số 123 Nguyễn Văn Linh, quận Hải Châu, chi nhánh mới có diện tích hơn 500m², được thiết kế hiện đại với không gian trưng bày rộng rãi, thoáng đãng. Tại đây, khách hàng có thể trải nghiệm và mua sắm đầy đủ các sản phẩm máy ảnh, máy quay phim, ống kính, phụ kiện và laptop từ các thương hiệu hàng đầu như Sony, Canon, Nikon, Fujifilm, DJI, Apple, Dell, Asus...</p>
                      <p>Ông Nguyễn Văn A, Giám đốc VJShop, chia sẻ: "Việc mở rộng chi nhánh tại Đà Nẵng là một bước đi chiến lược trong kế hoạch phát triển của VJShop. Chúng tôi muốn mang đến trải nghiệm mua sắm tốt nhất cho khách hàng miền Trung, với đầy đủ sản phẩm chính hãng, dịch vụ chuyên nghiệp và chế độ bảo hành uy tín."</p>
                      <p>Nhân dịp khai trương, VJShop Đà Nẵng triển khai nhiều chương trình khuyến mãi hấp dẫn từ ngày 01/05 đến 15/05/2025:</p>
                      <ul>
                          <li>Giảm giá đến 30% cho nhiều sản phẩm máy ảnh và laptop</li>
                          <li>Tặng phiếu mua hàng trị giá 1 triệu đồng cho hóa đơn từ 20 triệu</li>
                          <li>Trả góp 0% lãi suất trong 12 tháng</li>
                          <li>Bốc thăm trúng thưởng với giải đặc biệt là máy ảnh Sony Alpha 7C II</li>
                      </ul>
                      <p>Chi nhánh VJShop Đà Nẵng sẽ hoạt động từ 8h00 đến 21h00 hàng ngày, kể cả cuối tuần và ngày lễ. Ngoài ra, khách hàng cũng có thể mua sắm online thông qua website hoặc ứng dụng di động của VJShop với dịch vụ giao hàng nhanh trong ngày tại khu vực Đà Nẵng.</p>
                      <p>Đây là chi nhánh thứ 5 của VJShop trên toàn quốc, sau các chi nhánh tại TP.HCM, Hà Nội, Cần Thơ và Nha Trang. Công ty dự kiến sẽ tiếp tục mở rộng mạng lưới với thêm 3 chi nhánh mới tại các thành phố lớn trong năm 2025.</p>',
        'image' => '/placeholder.svg?height=400&width=600',
        'category' => 'Tin tức',
        'author' => 'Ban biên tập VJShop',
        'date' => '02/05/2025',
        'views' => 875,
        'tags' => ['VJShop', 'Khai trương', 'Đà Nẵng', 'Chi nhánh mới']
    ]
];

// Lấy chi tiết tin tức nếu có id
$news_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_news = null;

if ($news_id > 0) {
    foreach ($news as $item) {
        if ($item['id'] == $news_id) {
            $current_news = $item;
            break;
        }
    }
}

// Lấy danh sách tin tức theo danh mục
$category = isset($_GET['category']) ? $_GET['category'] : '';
$filtered_news = [];

if ($category) {
    foreach ($news as $item) {
        if ($item['category'] == $category) {
            $filtered_news[] = $item;
        }
    }
} else {
    $filtered_news = $news;
}
?>

<div class="container">
    <?php if ($current_news): ?>
    <!-- Chi tiết tin tức -->
    <div class="news-detail fade-in">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &gt; 
            <a href="news.php">Tin tức</a> &gt; 
            <a href="news.php?category=<?php echo urlencode($current_news['category']); ?>"><?php echo $current_news['category']; ?></a> &gt; 
            <span><?php echo $current_news['title']; ?></span>
        </div>
        
        <article class="news-article">
            <h1><?php echo $current_news['title']; ?></h1>
            
            <div class="article-meta">
                <span class="article-author"><i class="fas fa-user"></i> <?php echo $current_news['author']; ?></span>
                <span class="article-date"><i class="far fa-calendar-alt"></i> <?php echo $current_news['date']; ?></span>
                <span class="article-views"><i class="far fa-eye"></i> <?php echo number_format($current_news['views']); ?> lượt xem</span>
            </div>
            
            <div class="article-summary">
                <?php echo $current_news['summary']; ?>
            </div>
            
            <div class="article-image">
                <img src="<?php echo $current_news['image']; ?>" alt="<?php echo $current_news['title']; ?>">
            </div>
            
            <div class="article-content">
                <?php echo $current_news['content']; ?>
            </div>
            
            <div class="article-tags">
                <span>Tags:</span>
                <?php foreach ($current_news['tags'] as $tag): ?>
                <a href="news.php?tag=<?php echo urlencode($tag); ?>"><?php echo $tag; ?></a>
                <?php endforeach; ?>
            </div>
            
            <div class="article-share">
                <span>Chia sẻ:</span>
                <a href="#" class="facebook-share"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="twitter-share"><i class="fab fa-twitter"></i></a>
                <a href="#" class="linkedin-share"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="pinterest-share"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </article>
        
        <div class="related-news">
            <h2>Tin tức liên quan</h2>
            <div class="news-grid">
                <?php 
                $related = [];
                $count = 0;
                foreach ($news as $item) {
                    if ($item['id'] != $current_news['id'] && $item['category'] == $current_news['category'] && $count < 3) {
                        $related[] = $item;
                        $count++;
                    }
                }
                
                // Nếu không đủ tin cùng danh mục, lấy thêm tin khác
                if ($count < 3) {
                    foreach ($news as $item) {
                        if ($item['id'] != $current_news['id'] && !in_array($item, $related) && $count < 3) {
                            $related[] = $item;
                            $count++;
                        }
                    }
                }
                
                foreach ($related as $item): 
                ?>
                <div class="news-card slide-up">
                    <a href="news.php?id=<?php echo $item['id']; ?>">
                        <div class="news-image">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                        </div>
                        <div class="news-info">
                            <h3><?php echo $item['title']; ?></h3>
                            <div class="news-meta">
                                <span><i class="far fa-calendar-alt"></i> <?php echo $item['date']; ?></span>
                                <span><i class="far fa-eye"></i> <?php echo number_format($item['views']); ?></span>
                            </div>
                            <p><?php echo $item['summary']; ?></p>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Danh sách tin tức -->
    <div class="news-page">
        <h1 class="page-title">Tin tức</h1>
        
        <div class="news-categories">
            <a href="news.php" class="<?php echo empty($category) ? 'active' : ''; ?>">Tất cả</a>
            <a href="news.php?category=Tin+tức" class="<?php echo $category == 'Tin tức' ? 'active' : ''; ?>">Tin tức</a>
            <a href="news.php?category=Sản+phẩm+mới" class="<?php echo $category == 'Sản phẩm mới' ? 'active' : ''; ?>">Sản phẩm mới</a>
            <a href="news.php?category=Mẹo+nhiếp+ảnh" class="<?php echo $category == 'Mẹo nhiếp ảnh' ? 'active' : ''; ?>">Mẹo nhiếp ảnh</a>
            <a href="news.php?category=Hướng+dẫn" class="<?php echo $category == 'Hướng dẫn' ? 'active' : ''; ?>">Hướng dẫn</a>
        </div>
        
        <?php if (empty($filtered_news)): ?>
        <div class="no-results">
            <p>Không có tin tức nào trong danh mục này.</p>
        </div>
        <?php else: ?>
        <div class="featured-news">
            <?php $featured = $filtered_news[0]; ?>
            <div class="featured-news-card fade-in">
                <a href="news.php?id=<?php echo $featured['id']; ?>">
                    <div class="featured-news-image">
                        <img src="<?php echo $featured['image']; ?>" alt="<?php echo $featured['title']; ?>">
                    </div>
                    <div class="featured-news-info">
                        <span class="news-category"><?php echo $featured['category']; ?></span>
                        <h2><?php echo $featured['title']; ?></h2>
                        <div class="news-meta">
                            <span><i class="fas fa-user"></i> <?php echo $featured['author']; ?></span>
                            <span><i class="far fa-calendar-alt"></i> <?php echo $featured['date']; ?></span>
                            <span><i class="far fa-eye"></i> <?php echo number_format($featured['views']); ?></span>
                        </div>
                        <p><?php echo $featured['summary']; ?></p>
                        <span class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="news-list">
            <?php 
            // Bỏ qua tin đầu tiên đã hiển thị ở featured
            array_shift($filtered_news);
            foreach ($filtered_news as $index => $item): 
            ?>
            <div class="news-card <?php echo $index % 2 == 0 ? 'fade-in' : 'slide-up'; ?>">
                <a href="news.php?id=<?php echo $item['id']; ?>">
                    <div class="news-image">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                        <span class="news-category"><?php echo $item['category']; ?></span>
                    </div>
                    <div class="news-info">
                        <h3><?php echo $item['title']; ?></h3>
                        <div class="news-meta">
                            <span><i class="fas fa-user"></i> <?php echo $item['author']; ?></span>
                            <span><i class="far fa-calendar-alt"></i> <?php echo $item['date']; ?></span>
                            <span><i class="far fa-eye"></i> <?php echo number_format($item['views']); ?></span>
                        </div>
                        <p><?php echo $item['summary']; ?></p>
                        <span class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chia sẻ bài viết
    const shareButtons = document.querySelectorAll('.article-share a');
    
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = window.location.href;
            const title = document.querySelector('.news-article h1').textContent;
            
            if (this.classList.contains('facebook-share')) {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, 'facebook-share', 'width=580,height=296');
            } else if (this.classList.contains('twitter-share')) {
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`, 'twitter-share', 'width=580,height=296');
            } else if (this.classList.contains('linkedin-share')) {
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, 'linkedin-share', 'width=580,height=296');
            } else if (this.classList.contains('pinterest-share')) {
                const image = document.querySelector('.article-image img').src;
                window.open(`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(url)}&media=${encodeURIComponent(image)}&description=${encodeURIComponent(title)}`, 'pinterest-share', 'width=580,height=296');
            }
        });
    });
});
</script>

<?php require_once 'footer.php'; ?>


