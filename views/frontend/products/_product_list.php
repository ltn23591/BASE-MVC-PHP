<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <?php
        $images = json_decode($product['image'], true);
        $first_image = !empty($images) ? $images[0] : 'path/to/default/image.jpg';
        ?>
        <div class="product-item">
            <a href="index.php?controllers=product&action=detail&id=<?= $product['id'] ?>">
                <img class="w-full h-auto object-cover" src="<?= htmlspecialchars($first_image) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="p-2">
                    <h3 class="text-sm font-medium"><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="text-sm text-gray-600"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="col-span-full text-center text-gray-500">Không tìm thấy sản phẩm nào phù hợp.</p>
<?php endif; ?>