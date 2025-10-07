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
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/js/cart.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</body>

</html>