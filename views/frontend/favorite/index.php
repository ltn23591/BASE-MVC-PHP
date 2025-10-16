<?php
include './public/assets/img/frontend_assets/assets.php';
include __DIR__ . '/../../layouts/title.php';
require __DIR__ . '/../components/ProductItem.php';
?>

<div class="container mx-auto px-4 py-8">
    <!-- Tiêu đề -->
    <div class="text-center mb-8">
        <?= Title("SẢN PHẨM", "YÊU THÍCH"); ?>
        <p class="text-gray-600 mt-2">Danh sách những sản phẩm bạn đã yêu thích</p>
    </div>

    <!-- Trạng thái chưa đăng nhập -->
    <?php if (!$isLoggedIn): ?>
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="w-24 h-24 mx-auto mb-4 text-gray-400">
                <i class="fa-solid fa-user-lock text-6xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-600 mb-2">Vui lòng đăng nhập</h3>
            <p class="text-gray-500 mb-6">Bạn cần đăng nhập để xem danh sách sản phẩm yêu thích</p>
            <div class="flex justify-center gap-4">
                <a href="index.php?controllers=auth&action=login" 
                   class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
                    🔐 Đăng nhập
                </a>
                <a href="index.php?controllers=auth&action=register" 
                   class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                    📝 Đăng ký
                </a>
            </div>
            <p class="text-gray-400 text-sm mt-4">
                Chưa có tài khoản? <a href="index.php?controllers=auth&action=register" class="text-blue-500 hover:underline">Đăng ký ngay</a>
            </p>
        </div>
    <?php else: ?>
        <!-- Đã đăng nhập: Hiển thị danh sách sản phẩm -->
        <?php if (!empty($favorites)): ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 mb-8">
                <?php foreach ($favorites as $product): ?>
                    <?php 
                    ProductItem(
                        $product['id'],
                        $product['image'],
                        $product['name'], 
                        $product['price']
                    );
                    ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Thống kê -->
            <div class="text-center text-gray-600">
                <p>Bạn có <span class="font-bold text-red-500 favorite-count"><?= count($favorites) ?></span> sản phẩm yêu thích</p>
            </div>
        <?php else: ?>
            <!-- Trạng thái trống (đã đăng nhập nhưng không có sản phẩm) -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-4 text-gray-300">
                    <i class="fa-regular fa-heart text-6xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-600 mb-2">Chưa có sản phẩm yêu thích</h3>
                <p class="text-gray-500 mb-6">Hãy thêm sản phẩm bạn yêu thích vào danh sách này!</p>
                <a href="index.php?controllers=product&action=index" 
                   class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
                    🛍️ Mua sắm ngay
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- JavaScript xử lý yêu thích -->
<script>
const userId = <?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null' ?>;
const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

// Hàm tạo toast
function createToast(message, isSuccess = true) {
    const background = isSuccess 
        ? 'linear-gradient(to right, #00b09b, #96c93d)'
        : 'linear-gradient(to right, #ff416c, #ff4b2b)';
    
    Toastify({
        text: message,
        duration: 3000,
        gravity: 'top',
        position: 'right',
        style: {
            background: background,
            minWidth: '300px',
            maxWidth: '350px',
            padding: '12px 16px',
            fontSize: '14px',
            borderRadius: '8px',
            fontWeight: '500'
        },
    }).showToast();
}

// Hàm xóa khỏi danh sách yêu thích
function removeFromFavorites(productId, productElement = null) {
    if (!isLoggedIn) {
        createToast('Vui lòng đăng nhập để sử dụng tính năng này.', false);
        setTimeout(() => {
            window.location.href = 'index.php?controllers=auth&action=login';
        }, 1500);
        return;
    }

    fetch('index.php?controllers=favorite&action=toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'removed') {
            createToast('❌ Đã xóa khỏi danh sách yêu thích!', false);
            
            // Xóa sản phẩm khỏi danh sách nếu đang ở trang favorites
            if (productElement) {
                productElement.remove();
                
                // Cập nhật số lượng sản phẩm
                updateFavoriteCount();
                
                // Kiểm tra nếu không còn sản phẩm nào thì hiển thị trạng thái trống
                checkEmptyState();
            }
        } else if (data.status === 'error') {
            createToast(data.message, false);
            // Nếu có lỗi đăng nhập, chuyển hướng đến trang đăng nhập
            if (data.message.includes('đăng nhập')) {
                setTimeout(() => {
                    window.location.href = 'index.php?controllers=auth&action=login';
                }, 1500);
            }
        }
    })
    .catch(err => {
        console.error('Lỗi yêu thích:', err);
        createToast('❌ Có lỗi xảy ra!', false);
    });
}

// Cập nhật số lượng sản phẩm
function updateFavoriteCount() {
    const productCount = document.querySelectorAll('.product-item').length;
    const countElement = document.querySelector('.favorite-count');
    if (countElement) {
        countElement.textContent = productCount;
    }
}

// Kiểm tra trạng thái trống
function checkEmptyState() {
    const productGrid = document.querySelector('.grid');
    if (productGrid && productGrid.children.length === 0) {
        // Tự động reload trang để hiển thị trạng thái trống
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
}

// Thêm event listener cho các nút tim trong danh sách
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý khi click vào tim trong danh sách yêu thích
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const productElement = this.closest('.product-item');
            removeFromFavorites(productId, productElement);
        });
    });

    // Xử lý khi click vào nút đăng nhập trong thông báo
    document.querySelectorAll('.login-redirect-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'index.php?controllers=auth&action=login';
        });
    });
});
</script>