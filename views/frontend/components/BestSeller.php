<?php
require_once './public/assets/img/frontend_assets/assets.php';
require_once './views/frontend/components/ProductItem.php';
?>

<div class="my-10">
    <div class="text-center py-8 text-3xl">
        <?php Title("SẢN PHẨM", "BÁN CHẠY"); ?>
        <p class="w-3/4 m-auto text-xs sm:text-sm md:text-base text-gray-600">
            Khám phá những sản phẩm bán chạy nhất được khách hàng yêu thích!
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6">
        <!-- Lấy 5 sản phẩm được seller -->
        <?php foreach (array_slice($bestsellers, 0, 5) as $p): ?>
        <?php ProductItem($p['id'], $p['image'], $p['name'], $p['price']); ?>
        <?php endforeach; ?>
    </div>
</div>