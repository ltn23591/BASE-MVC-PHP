<?php if (empty($_SESSION['user_id'])): ?>
<div class="text-center">
    <p class="text-2xl font-medium text-gray-800">
        Đăng ký ngay và nhận giảm giá 20%
    </p>
    <p class="text-gray-400 mt-2">
        Nhận ưu đãi, cập nhật sản phẩm mới mỗi tuần
    </p>

    <div class="text-center my-6">
    <a href="index.php?controllers=auth&action=login&state=Sign up"
       class="inline-block bg-black text-white text-sm px-6 py-3 rounded hover:bg-gray-800 transition">
        ĐĂNG KÝ NGAY
    </a>
</div>
<?php endif; ?>
