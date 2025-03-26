<?php
session_start();
require_once 'database.php';
require_once 'header.php';

$success = '';
$error = '';

// Xử lý form liên hệ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        $error = 'Vui lòng điền đầy đủ thông tin';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ';
    } else {
        // Trong thực tế, bạn sẽ lưu thông tin liên hệ vào database hoặc gửi email
        // Ở đây chúng ta chỉ giả lập thành công
        $success = 'Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ phản hồi trong thời gian sớm nhất!';
    }
}
?>

<div class="container">
    <div class="contact-page fade-in">
        <h1 class="page-title">Liên hệ với chúng tôi</h1>
        
        <div class="contact-intro">
            <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Vui lòng liên hệ với chúng tôi qua form bên dưới hoặc thông tin liên hệ của chúng tôi.</p>
        </div>
        
        <div class="contact-container">
            <div class="contact-info">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Địa chỉ</h3>
                        <p>123 Nguyễn Văn Linh, Quận 7, TP.HCM</p>
                        <p>456 Lê Lợi, Quận 1, TP.HCM</p>
                        <p>789 Nguyễn Văn Linh, Quận Hải Châu, Đà Nẵng</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Điện thoại</h3>
                        <p>Hotline: 1900 1234</p>
                        <p>Hỗ trợ kỹ thuật: 1900 4567</p>
                        <p>Bảo hành: 1900 7890</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p>Thông tin chung: info@vjshop.vn</p>
                        <p>Hỗ trợ khách hàng: support@vjshop.vn</p>
                        <p>Kinh doanh: sales@vjshop.vn</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <h3>Giờ làm việc</h3>
                        <p>Thứ 2 - Thứ 6: 8:00 - 21:00</p>
                        <p>Thứ 7 - Chủ nhật: 8:00 - 22:00</p>
                        <p>Ngày lễ: 9:00 - 20:00</p>
                    </div>
                </div>
                
                <div class="social-connect">
                    <h3>Kết nối với chúng tôi</h3>
                    <div class="social-icons">
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="tiktok"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-container">
                <h2>Gửi tin nhắn cho chúng tôi</h2>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <form class="contact-form" method="POST" action="">
                    <div class="form-group">
                        <label for="name">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Tiêu đề <span class="required">*</span></label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Nội dung <span class="required">*</span></label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Gửi tin nhắn</button>
                </form>
            </div>
        </div>
        
        <div class="map-container">
            <h2>Bản đồ cửa hàng</h2>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5177580567147!2d106.69916347469967!3d10.771600089387894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3a5bb9e35!2zMTIzIE5ndXnhu4VuIMSQw6xuaCBDaGnhu4N1LCBQaMaw4budbmcgNiwgUXXhuq1uIDMsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1682956214221!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        
        <div class="faq-section">
            <h2>Câu hỏi thường gặp</h2>
            
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Làm thế nào để đặt hàng trên website?</h3>
                        <span class="accordion-icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="accordion-content">
                        <p>Để đặt hàng trên website VJShop, bạn chỉ cần thực hiện các bước sau:</p>
                        <ol>
                            <li>Tìm kiếm và chọn sản phẩm bạn muốn mua</li>
                            <li>Nhấn nút "Thêm vào giỏ hàng"</li>
                            <li>Vào giỏ hàng và nhấn "Tiến hành thanh toán"</li>
                            <li>Điền thông tin giao hàng và chọn phương thức thanh toán</li>
                            <li>Xác nhận đơn hàng</li>
                        </ol>
                        <p>Sau khi đặt hàng thành công, bạn sẽ nhận được email xác nhận đơn hàng.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Chính sách bảo hành của VJShop như thế nào?</h3>
                        <span class="accordion-icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="accordion-content">
                        <p>VJShop áp dụng chính sách bảo hành chính hãng cho tất cả sản phẩm. Thời gian bảo hành tùy thuộc vào từng loại sản phẩm và hãng sản xuất:</p>
                        <ul>
                            <li>Máy ảnh, máy quay: 24 tháng</li>
                            <li>Ống kính: 12-24 tháng tùy hãng</li>
                            <li>Laptop: 12-24 tháng tùy hãng</li>
                            <li>Phụ kiện: 3-12 tháng tùy loại</li>
                        </ul>
                        <p>Để yêu cầu bảo hành, bạn có thể mang sản phẩm đến trực tiếp cửa hàng hoặc liên hệ với bộ phận CSKH qua số điện thoại 1900 7890.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>VJShop có ship hàng toàn quốc không?</h3>
                        <span class="accordion-icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="accordion-content">
                        <p>Có, VJShop cung cấp dịch vụ giao hàng toàn quốc thông qua các đơn vị vận chuyển uy tín như GHN, GHTK, Viettel Post, J&T Express.</p>
                        <p>Thời gian giao hàng dự kiến:</p>
                        <ul>
                            <li>Nội thành TP.HCM, Hà Nội, Đà Nẵng: 1-2 ngày</li>
                            <li>Các tỉnh thành khác: 2-5 ngày</li>
                            <li>Vùng sâu vùng xa: 5-7 ngày</li>
                        </ul>
                        <p>Đơn hàng từ 2 triệu đồng trở lên sẽ được miễn phí vận chuyển (áp dụng cho khu vực nội thành).</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Làm thế nào để theo dõi đơn hàng?</h3>
                        <span class="accordion-icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="accordion-content">
                        <p>Bạn có thể theo dõi đơn hàng của mình bằng một trong các cách sau:</p>
                        <ol>
                            <li>Đăng nhập vào tài khoản VJShop và vào mục "Đơn hàng của tôi"</li>
                            <li>Sử dụng mã đơn hàng và email để tra cứu trên trang web</li>
                            <li>Kiểm tra email xác nhận đơn hàng và nhấp vào liên kết theo dõi</li>
                            <li>Liên hệ trực tiếp với bộ phận CSKH qua số điện thoại 1900 1234</li>
                        </ol>
                        <p>Chúng tôi cũng sẽ gửi thông báo qua email hoặc SMS khi đơn hàng của bạn được xử lý, đang vận chuyển và đã giao thành công.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý accordion
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const accordionItem = this.parentElement;
            const accordionContent = this.nextElementSibling;
            const accordionIcon = this.querySelector('.accordion-icon i');
            
            // Đóng tất cả các accordion khác
            document.querySelectorAll('.accordion-item').forEach(item => {
                if (item !== accordionItem && item.classList.contains('active')) {
                    item.classList.remove('active');
                    item.querySelector('.accordion-content').style.maxHeight = null;
                    item.querySelector('.accordion-icon i').className = 'fas fa-plus';
                }
            });
            
            // Toggle accordion hiện tại
            accordionItem.classList.toggle('active');
            
            if (accordionItem.classList.contains('active')) {
                accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
                accordionIcon.className = 'fas fa-minus';
            } else {
                accordionContent.style.maxHeight = null;
                accordionIcon.className = 'fas fa-plus';
            }
        });
    });
    
    // Form validation
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            // Xóa thông báo lỗi cũ
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            
            // Kiểm tra tên
            if (name.value.trim() === '') {
                showError(name, 'Vui lòng nhập họ và tên');
                valid = false;
            }
            
            // Kiểm tra email
            if (email.value.trim() === '') {
                showError(email, 'Vui lòng nhập email');
                valid = false;
            } else if (!isValidEmail(email.value)) {
                showError(email, 'Email không hợp lệ');
                valid = false;
            }
            
            // Kiểm tra số điện thoại
            if (phone.value.trim() === '') {
                showError(phone, 'Vui lòng nhập số điện thoại');
                valid = false;
            } else if (!isValidPhone(phone.value)) {
                showError(phone, 'Số điện thoại không hợp lệ');
                valid = false;
            }
            
            // Kiểm tra tiêu đề
            if (subject.value.trim() === '') {
                showError(subject, 'Vui lòng nhập tiêu đề');
                valid = false;
            }
            
            // Kiểm tra nội dung
            if (message.value.trim() === '') {
                showError(message, 'Vui lòng nhập nội dung');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
    
    function showError(input, message) {
        const formGroup = input.parentElement;
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.textContent = message;
        formGroup.appendChild(errorMessage);
        input.classList.add('error');
    }
    
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    function isValidPhone(phone) {
        const re = /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
        return re.test(phone);
    }
});
</script>

<?php require_once 'footer.php'; ?>

