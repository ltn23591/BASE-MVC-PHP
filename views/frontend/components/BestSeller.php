<?php
require_once './includes/title.php';
include './public/assets/img/frontend_assets/assets.php';
?>


<?php
// Lọc những sản phẩm có bestseller = true
$bestsellers = array_filter($products, function ($p) {
    return !empty($p['bestseller']) && $p['bestseller'] === true;
});


?>

<div class="my-10">
    <div class="text-center py-8 text-3xl">
        <?php Title("SẢN PHẨM", "BÁN CHẠY"); ?>
        <p class="w-3/4 m-auto text-xs sm:text-sm md:text-base text-gray-600">
            Khám phá những sản phẩm bán chạy nhất được khách hàng yêu thích!
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6">
        <?php
        // Lấy 5 sản phẩm đầu tiên trong danh sách đã lọc
        foreach (array_slice($bestsellers, 0, 5) as $p) {
            ProductItem($p['_id'], $p['image'], $p['name'], $p['price']);
        }
        ?>
    </div>
</div>