<?php require_once __DIR__ . '../../../../config/config_url.php'; ?>
<!-- Footer -->
<div>
    <div class="flex flex-col sm:grid grid-cols-[3fr_1fr_1fr] gap-14 my-10 text-sm">
        <div>
            <?php include __DIR__ . '/logo.php'; ?>
            <p class="w-full md:w-2/3 text-gray-500 text-left mt-3">
                Khám phá những xu hướng thời trang mới nhất, mang đến vẻ đẹp tự tin và cá tính cho bạn mỗi ngày.
            </p>
        </div>

        <div>
            <p class="text-xl font-medium mb-5">CÔNG TY</p>
            <ul class="flex flex-col gap-1 text-gray-600">
                <li>TRANG CHỦ</li>
                <li>VỀ CHÚNG TÔI</li>
                <li>LIÊN HỆ</li>
                <li>SẢN PHẨM</li>
                <li>VẬN CHUYỂN</li>
            </ul>
        </div>

        <div>
            <p class="text-xl font-medium mb-5">LIÊN HỆ</p>
            <ul class="flex flex-col gap-1 text-gray-600">
                <li>+1 234 567 890</li>
                <li>info@example.com</li>
                <li>TP HCM</li>
            </ul>
        </div>
    </div>

    <div>
        <hr />
        <p class="py-5 text-sm text-center">
            © 2023 Your Company. All rights reserved.
        </p>
    </div>
</div>

</div>
</div>
<!-- Tailwind flowbite-->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/js/cart.js" defer></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<?php
// Kiểm tra và hiển thị toast từ session
$toastMsg = $_SESSION['toast_success'] ?? null;
if ($toastMsg) {
    unset($_SESSION['toast_success']); // Xóa ngay để không hiển thị lại
    echo "
    <script>
        Toastify({
            text: '" . addslashes($toastMsg) . "',
            duration: 3000,
            gravity: 'top',
            position: 'right',
            close: true,
            style: {
                background: 'linear-gradient(to right, #00b09b, #96c93d)',
                minWidth: '300px',
                padding: '12px 16px',
                fontSize: '14px',
                borderRadius: '8px',
            }
        }).showToast();
    </script>
    ";
}
?>
<!-- AOS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
<!-- GSAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

</body>

</html>