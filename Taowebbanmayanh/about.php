<?php
session_start();
require_once 'database.php';
require_once 'header.php';
?>

<div class="container">
    <div class="about-page fade-in">
        <h1 class="page-title">Về VJShop</h1>
        
        <div class="about-banner">
            <img src="/placeholder.svg?height=400&width=1200" alt="VJShop Store">
            <div class="banner-overlay">
                <h2>Đồng hành cùng đam mê nhiếp ảnh và công nghệ</h2>
            </div>
        </div>
        
        <div class="about-intro">
            <div class="intro-content">
                <h2>Câu chuyện của chúng tôi</h2>
                <p>VJShop được thành lập vào năm 2010 bởi một nhóm những người đam mê nhiếp ảnh và công nghệ. Xuất phát từ một cửa hàng nhỏ tại Quận 1, TP.HCM, đến nay VJShop đã trở thành một trong những chuỗi cửa hàng máy ảnh và thiết bị công nghệ uy tín hàng đầu Việt Nam với 5 chi nhánh trên toàn quốc.</p>
                <p>Với sứ mệnh mang đến những sản phẩm chất lượng cao và dịch vụ chuyên nghiệp, VJShop luôn nỗ lực không ngừng để đáp ứng nhu cầu ngày càng cao của khách hàng. Chúng tôi tự hào là đối tác chính thức của nhiều thương hiệu lớn như Sony, Canon, Nikon, Fujifilm, DJI, Apple, Dell, Asus...</p>
            </div>
            <div class="intro-image">
                <img src="/placeholder.svg?height=400&width=600" alt="VJShop Team">
            </div>
        </div>
        
        <div class="about-vision-mission">
            <div class="vision">
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h2>Tầm nhìn</h2>
                <p>Trở thành nhà bán lẻ thiết bị nhiếp ảnh và công nghệ hàng đầu Việt Nam, mang đến trải nghiệm mua sắm tuyệt vời và dịch vụ chuyên nghiệp cho khách hàng.</p>
            </div>
            <div class="mission">
                <div class="icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2>Sứ mệnh</h2>
                <p>Cung cấp sản phẩm chính hãng, chất lượng cao với giá cả cạnh tranh, đồng thời mang đến dịch vụ tư vấn chuyên nghiệp, hỗ trợ kỹ thuật tận tâm và chế độ bảo hành uy tín, giúp khách hàng có được trải nghiệm mua sắm tốt nhất.</p>
            </div>
        </div>
        
        <div class="about-values">
            <h2>Giá trị cốt lõi</h2>
            <div class="values-grid">
                <div class="value-item slide-up">
                    <div class="value-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Chất lượng</h3>
                    <p>Cam kết cung cấp sản phẩm chính hãng, chất lượng cao, đáp ứng tiêu chuẩn khắt khe của nhà sản xuất.</p>
                </div>
                <div class="value-item slide-up">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Uy tín</h3>
                    <p>Xây dựng niềm tin với khách hàng thông qua sự minh bạch, trung thực và đáng tin cậy trong mọi giao dịch.</p>
                </div>
                <div class="value-item slide-up">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Khách hàng là trọng tâm</h3>
                    <p>Đặt lợi ích và sự hài lòng của khách hàng lên hàng đầu, luôn lắng nghe và đáp ứng nhu cầu của khách hàng.</p>
                </div>
                <div class="value-item slide-up">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Đổi mới</h3>
                    <p>Không ngừng cải tiến, áp dụng công nghệ mới và phương pháp hiện đại để nâng cao chất lượng dịch vụ.</p>
                </div>
            </div>
        </div>
        
        <div class="about-team">
            <h2>Đội ngũ của chúng tôi</h2>
            <div class="team-grid">
                <div class="team-member fade-in">
                    <div class="member-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Nguyễn Văn A">
                    </div>
                    <div class="member-info">
                        <h3>Nguyễn Văn A</h3>
                        <p class="member-position">Giám đốc điều hành</p>
                        <p class="member-bio">Với hơn 15 năm kinh nghiệm trong lĩnh vực bán lẻ thiết bị công nghệ, anh A đã dẫn dắt VJShop phát triển mạnh mẽ và trở thành một trong những chuỗi cửa hàng uy tín nhất.</p>
                    </div>
                </div>
                <div class="team-member fade-in">
                    <div class="member-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Trần Thị B">
                    </div>
                    <div class="member-info">
                        <h3>Trần Thị B</h3>
                        <p class="member-position">Giám đốc marketing</p>
                        <p class="member-bio">Chị B là chuyên gia marketing với nhiều năm kinh nghiệm trong ngành công nghệ. Chị đã xây dựng thành công thương hiệu VJShop và chiến lược tiếp thị hiệu quả.</p>
                    </div>
                </div>
                <div class="team-member fade-in">
                    <div class="member-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Lê Văn C">
                    </div>
                    <div class="member-info">
                        <h3>Lê Văn C</h3>
                        <p class="member-position">Giám đốc kỹ thuật</p>
                        <p class="member-bio">Anh C là nhiếp ảnh gia chuyên nghiệp và chuyên gia kỹ thuật với kiến thức sâu rộng về máy ảnh và thiết bị công nghệ. Anh phụ trách đào tạo đội ngũ tư vấn viên của VJShop.</p>
                    </div>
                </div>
                <div class="team-member fade-in">
                    <div class="member-image">
                        <img src="/placeholder.svg?height=300&width=300" alt="Phạm Thị D">
                    </div>
                    <div class="member-info">
                        <h3>Phạm Thị D</h3>
                        <p class="member-position">Giám đốc dịch vụ khách hàng</p>
                        <p class="member-bio">Chị D có hơn 10 năm kinh nghiệm trong lĩnh vực chăm sóc khách hàng. Chị đã xây dựng đội ngũ CSKH chuyên nghiệp, tận tâm, luôn sẵn sàng hỗ trợ khách hàng.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="about-milestones">
            <h2>Những cột mốc phát triển</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2010</h3>
                        <p>Thành lập cửa hàng đầu tiên tại Quận 1, TP.HCM, chuyên kinh doanh máy ảnh và phụ kiện.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2013</h3>
                        <p>Mở rộng sang lĩnh vực laptop và thiết bị công nghệ. Khai trương chi nhánh thứ hai tại Quận 7, TP.HCM.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2016</h3>
                        <p>Trở thành đối tác chính thức của Sony, Canon và Nikon tại Việt Nam. Ra mắt website thương mại điện tử.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2019</h3>
                        <p>Mở rộng ra thị trường miền Bắc với chi nhánh tại Hà Nội. Đạt mốc 100,000 khách hàng thân thiết.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2022</h3>
                        <p>Khai trương chi nhánh tại Cần Thơ và Nha Trang. Đạt giải thưởng "Nhà bán lẻ thiết bị công nghệ uy tín".</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content slide-up">
                        <h3>2025</h3>
                        <p>Khai trương chi nhánh mới tại Đà Nẵng. Phát triển hệ thống cửa hàng trải nghiệm với không gian studio chuyên nghiệp.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="about-partners">
            <h2>Đối tác của chúng tôi</h2>
            <div class="partners-grid">
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Sony">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Canon">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Nikon">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Fujifilm">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="DJI">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Apple">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Dell">
                </div>
                <div class="partner-logo">
                    <img src="/placeholder.svg?height=100&width=200" alt="Asus">
                </div>
            </div>
        </div>
        
        <div class="about-cta">
            <h2>Trở thành một phần của VJShop</h2>
            <p>Chúng tôi luôn tìm kiếm những người tài năng, đam mê và nhiệt huyết để gia nhập đội ngũ VJShop. Nếu bạn yêu thích công nghệ, nhiếp ảnh và mong muốn phát triển trong môi trường năng động, hãy tham gia cùng chúng tôi!</p>
            <div class="cta-buttons">
                <a href="careers.php" class="btn-primary">Cơ hội nghề nghiệp</a>
                <a href="contact.php" class="btn-secondary">Liên hệ với chúng tôi</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation khi scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.slide-up, .fade-in');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if (elementPosition < screenPosition) {
                element.classList.add('animate');
            }
        });
    };
    
    // Chạy animation khi load trang
    animateOnScroll();
    
    // Chạy animation khi scroll
    window.addEventListener('scroll', animateOnScroll);
});
</script>

<?php require_once 'footer.php'; ?>

