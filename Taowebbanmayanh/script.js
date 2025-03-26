/**
 * VJShop - Main JavaScript File
 * Kết nối và điều khiển tất cả chức năng của website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo giỏ hàng
    initializeCart();

    // Khởi tạo chức năng đăng nhập
    initializeAuth();

    // Khởi tạo hiệu ứng UI
    initializeUIEffects();

    // Khởi tạo tìm kiếm
    initializeSearch();

    // Khởi tạo menu di động
    initializeMobileMenu();
});

/**
 * Khởi tạo và quản lý giỏ hàng
 */
function initializeCart() {
    // Thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const quantity = document.querySelector('.quantity-input') ?
                parseInt(document.querySelector('.quantity-input').value) : 1;

            // Hiệu ứng nút
            this.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
            this.style.backgroundColor = '#2ecc71';

            // Animation sản phẩm
            const productCard = this.closest('.product-card, .product-list-item');
            if (productCard) productCard.classList.add('pulse');

            // Reset sau 2 giây
            setTimeout(() => {
                this.innerHTML = 'Thêm vào giỏ';
                this.style.backgroundColor = '';
                if (productCard) productCard.classList.remove('pulse');
            }, 2000);

            // Gửi AJAX request để thêm vào giỏ hàng
            fetch('add-to-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId + '&quantity=' + quantity
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật số lượng giỏ hàng
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;

                            // Hiệu ứng nhấp nháy số lượng giỏ hàng
                            cartCount.classList.add('cart-count-update');
                            setTimeout(() => {
                                cartCount.classList.remove('cart-count-update');
                            }, 1000);
                        }

                        // Hiển thị thông báo thành công
                        showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                    } else {
                        showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                });
        });
    });

    // Cập nhật số lượng trong trang giỏ hàng
    const quantityControls = document.querySelectorAll('.quantity-control');
    if (quantityControls.length > 0) {
        quantityControls.forEach(control => {
            const decreaseBtn = control.querySelector('.decrease-btn');
            const increaseBtn = control.querySelector('.increase-btn');
            const input = control.querySelector('.quantity-input');
            const productId = input ? input.getAttribute('data-id') : null;

            if (decreaseBtn && increaseBtn && input && productId) {
                decreaseBtn.addEventListener('click', () => updateCartItemQuantity(productId, -1, input));
                increaseBtn.addEventListener('click', () => updateCartItemQuantity(productId, 1, input));
                input.addEventListener('change', () => updateCartItemQuantity(productId, 0, input));
            }
        });
    }

    // Xóa sản phẩm khỏi giỏ hàng
    const removeButtons = document.querySelectorAll('.remove-item-btn');
    if (removeButtons.length > 0) {
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');

                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    removeCartItem(productId);
                }
            });
        });
    }

    // So sánh sản phẩm
    const compareButtons = document.querySelectorAll('.compare-btn');
    if (compareButtons.length > 0) {
        compareButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const productId = this.getAttribute('data-id');

                if (this.classList.contains('active')) {
                    this.classList.remove('active');
                    this.innerHTML = '+ So sánh';
                    removeCompareItem(productId);
                } else {
                    this.classList.add('active');
                    this.innerHTML = '- Bỏ so sánh';
                    addCompareItem(productId);
                }
            });
        });
    }
}

/**
 * Cập nhật số lượng sản phẩm trong giỏ hàng
 */
function updateCartItemQuantity(productId, change, input) {
    let quantity = parseInt(input.value);

    if (change !== 0) {
        quantity += change;
    }

    if (quantity < 1) quantity = 1;
    input.value = quantity;

    fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền
                const subtotalElement = document.querySelector(`.cart-item[data-id="${productId}"] .subtotal`);
                if (subtotalElement) {
                    subtotalElement.textContent = data.subtotal;
                }

                // Cập nhật tổng giỏ hàng
                const totalElement = document.querySelector('.summary-row.total span:last-child');
                if (totalElement) {
                    totalElement.textContent = data.total;
                }

                // Cập nhật số lượng trên header
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }

                // Reload trang nếu cần cập nhật toàn bộ
                if (data.reload) {
                    window.location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'error');
        });
}

/**
 * Xóa sản phẩm khỏi giỏ hàng
 */
function removeCartItem(productId) {
    fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&remove=1`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Xóa phần tử khỏi DOM
                const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`);
                if (cartItem) {
                    cartItem.classList.add('fade-out');
                    setTimeout(() => {
                        cartItem.remove();

                        // Kiểm tra nếu giỏ hàng trống
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }

                // Cập nhật tổng giỏ hàng
                const totalElement = document.querySelector('.summary-row.total span:last-child');
                if (totalElement) {
                    totalElement.textContent = data.total;
                }

                // Cập nhật số lượng trên header
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }

                showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi xóa sản phẩm!', 'error');
        });
}

/**
 * Thêm sản phẩm vào danh sách so sánh
 */
function addCompareItem(productId) {
    // Lưu vào localStorage
    let compareList = JSON.parse(localStorage.getItem('compareList')) || [];
    if (!compareList.includes(productId)) {
        compareList.push(productId);
        localStorage.setItem('compareList', JSON.stringify(compareList));
    }

    // Hiển thị thông báo
    showNotification('Đã thêm sản phẩm vào danh sách so sánh!', 'success');

    // Cập nhật số lượng so sánh
    updateCompareCount();
}

/**
 * Xóa sản phẩm khỏi danh sách so sánh
 */
function removeCompareItem(productId) {
    // Xóa khỏi localStorage
    let compareList = JSON.parse(localStorage.getItem('compareList')) || [];
    compareList = compareList.filter(id => id != productId);
    localStorage.setItem('compareList', JSON.stringify(compareList));

    // Hiển thị thông báo
    showNotification('Đã xóa sản phẩm khỏi danh sách so sánh!', 'success');

    // Cập nhật số lượng so sánh
    updateCompareCount();
}

/**
 * Cập nhật số lượng sản phẩm so sánh
 */
function updateCompareCount() {
    const compareList = JSON.parse(localStorage.getItem('compareList')) || [];
    const compareCount = document.getElementById('compare-count');

    if (compareCount) {
        compareCount.textContent = compareList.length;

        if (compareList.length > 0) {
            compareCount.style.display = 'inline-block';
        } else {
            compareCount.style.display = 'none';
        }
    }
}

/**
 * Khởi tạo chức năng đăng nhập
 */
function initializeAuth() {
    // Facebook Login
    const fbLoginBtn = document.getElementById('facebook-login-btn');
    if (fbLoginBtn) {
        fbLoginBtn.addEventListener('click', function() {
            // Trong thực tế, bạn sẽ sử dụng Facebook SDK
            fbLogin();
        });
    }

    // Google Login
    const googleLoginBtn = document.getElementById('google-login-btn');
    if (googleLoginBtn) {
        googleLoginBtn.addEventListener('click', function() {
            // Trong thực tế, bạn sẽ sử dụng Google API
            googleLogin();
        });
    }

    // Đăng xuất
    const logoutLink = document.querySelector('a[href="logout.php"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();

            if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                window.location.href = 'logout.php';
            }
        });
    }
}

/**
 * Đăng nhập bằng Facebook
 */
function fbLogin() {
    // Trong thực tế, bạn sẽ sử dụng Facebook SDK
    // Ở đây chúng ta giả lập đăng nhập thành công
    window.location.href = 'login.php?facebook_login=success';

    /*
    FB.login(function(response) {
        if (response.authResponse) {
            // Người dùng đã đăng nhập thành công
            FB.api('/me', {fields: 'name,email'}, function(response) {
                // Gửi thông tin đến server để xử lý đăng nhập
                window.location.href = 'facebook-callback.php?name=' + response.name + '&email=' + response.email;
            });
        }
    }, {scope: 'public_profile,email'});
    */
}

/**
 * Đăng nhập bằng Google
 */
function googleLogin() {
    // Trong thực tế, bạn sẽ sử dụng Google API
    // Ở đây chúng ta giả lập đăng nhập thành công
    window.location.href = 'login.php?google_login=success';

    /*
    google.accounts.id.prompt();
    */
}

/**
 * Khởi tạo hiệu ứng UI
 */
function initializeUIEffects() {
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

    // Dropdown menu
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Accordion
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

    // Sao chép mã giảm giá
    const copyButtons = document.querySelectorAll('.copy-coupon');

    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(() => {
                this.textContent = 'Đã sao chép';
                setTimeout(() => {
                    this.textContent = 'Sao chép';
                }, 2000);

                showNotification('Đã sao chép mã giảm giá: ' + code, 'success');
            });
        });
    });
}

/**
 * Khởi tạo chức năng tìm kiếm
 */
function initializeSearch() {
    const searchForm = document.querySelector('.search-bar');
    const searchInput = document.querySelector('.search-bar input');
    const searchButton = document.querySelector('.search-bar button');

    if (searchForm && searchInput && searchButton) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (searchInput.value.trim() !== '') {
                window.location.href = 'search.php?q=' + encodeURIComponent(searchInput.value.trim());
            } else {
                searchInput.focus();
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                if (searchInput.value.trim() !== '') {
                    window.location.href = 'search.php?q=' + encodeURIComponent(searchInput.value.trim());
                }
            }
        });
    }
}

/**
 * Khởi tạo menu di động
 */
function initializeMobileMenu() {
    const header = document.querySelector('header');
    const mainNav = document.querySelector('.main-nav');

    if (header && mainNav) {
        // Tạo nút toggle menu
        if (window.innerWidth < 768 && !document.querySelector('.mobile-menu-toggle')) {
            const mobileMenuToggle = document.createElement('button');
            mobileMenuToggle.className = 'mobile-menu-toggle';
            mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';

            header.insertBefore(mobileMenuToggle, mainNav);
            mainNav.style.display = 'none';

            mobileMenuToggle.addEventListener('click', function() {
                if (mainNav.style.display === 'none') {
                    mainNav.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-times"></i>';
                } else {
                    mainNav.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-bars"></i>';
                }
            });
        }

        // Responsive adjustments
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                if (!document.querySelector('.mobile-menu-toggle')) {
                    const mobileMenuToggle = document.createElement('button');
                    mobileMenuToggle.className = 'mobile-menu-toggle';
                    mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';

                    header.insertBefore(mobileMenuToggle, mainNav);
                    mainNav.style.display = 'none';

                    mobileMenuToggle.addEventListener('click', function() {
                        if (mainNav.style.display === 'none') {
                            mainNav.style.display = 'block';
                            this.innerHTML = '<i class="fas fa-times"></i>';
                        } else {
                            mainNav.style.display = 'none';
                            this.innerHTML = '<i class="fas fa-bars"></i>';
                        }
                    });
                }
            } else {
                const toggle = document.querySelector('.mobile-menu-toggle');
                if (toggle) {
                    toggle.remove();
                    mainNav.style.display = 'block';
                }
            }
        });
    }
}

/**
 * Hiển thị thông báo
 */
function showNotification(message, type = 'info') {
    // Kiểm tra xem đã có container thông báo chưa
    let notificationContainer = document.getElementById('notification-container');

    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.id = 'notification-container';
        document.body.appendChild(notificationContainer);
    }

    // Tạo thông báo mới
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;

    // Thêm icon tùy theo loại thông báo
    let icon = '';
    switch (type) {
        case 'success':
            icon = '<i class="fas fa-check-circle"></i>';
            break;
        case 'error':
            icon = '<i class="fas fa-exclamation-circle"></i>';
            break;
        case 'warning':
            icon = '<i class="fas fa-exclamation-triangle"></i>';
            break;
        default:
            icon = '<i class="fas fa-info-circle"></i>';
    }

    notification.innerHTML = `
        ${icon}
        <span>${message}</span>
        <button class="close-notification"><i class="fas fa-times"></i></button>
    `;

    // Thêm vào container
    notificationContainer.appendChild(notification);

    // Hiệu ứng hiển thị
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Tự động đóng sau 5 giây
    const timeout = setTimeout(() => {
        closeNotification(notification);
    }, 5000);

    // Xử lý nút đóng
    const closeButton = notification.querySelector('.close-notification');
    closeButton.addEventListener('click', () => {
        clearTimeout(timeout);
        closeNotification(notification);
    });
}

/**
 * Đóng thông báo
 */
function closeNotification(notification) {
    notification.classList.remove('show');

    // Xóa khỏi DOM sau khi animation kết thúc
    setTimeout(() => {
        if (notification.parentElement) {
            notification.parentElement.removeChild(notification);
        }
    }, 300);
}