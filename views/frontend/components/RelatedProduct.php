<?php
require_once './includes/title.php';
require_once __DIR__ . '/ProductItem.php';
if (!isset($product)) {
    echo 'khong co san pham nao';
}
$category = $product['category'];
$subCategory = $product['subCategory'];
$related = [];

// Lọc sản phẩm cùng category và subCategory

foreach ($products as $p) {
    if (
        $p['_id'] !== $product['_id'] &&
        $p['category'] === $category &&
        $p['subCategory'] === $subCategory
    ) {
        $related[] = $p;
    }
    if (count($related) >= 5) break; // chỉ lấy 5 sản phẩm
}
?>

<div className='my-24'>
    <div className="text-center text-3xl py-2">
        <? Title("SẢN PHẨM", "LIÊN QUAN") ?>
    </div>
    <div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6'>
        <?php
        // Lấy 5 sản phẩm liên quan
        foreach (array_slice($related, 0, 10) as $p) {
            ProductItem($p['_id'], $p['image'], $p['name'], $p['price']);
        }
        ?>
    </div>
</div>