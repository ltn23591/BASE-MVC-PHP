<?php
require_once __DIR__ . '/ProductItem.php';

?>
<div class="my-10">
    <div class="text-center py-8 text-3xl">
        <?php Title("SẢN PHẨM", "MỚI NHẤT"); ?>
        <p class="w-3/4 m-auto text-xs sm:text-sm md:text-base text-gray-600">
            Khám phá sản phẩm mới nhất của chúng tôi!
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 autoplay ">
        <?php
        try {
            foreach (array_slice($products, 0, 10) as $p) {
                ProductItem($p['id'], $p['image'], $p['name'], $p['price']);
            }
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
        ?>
    </div>
</div>