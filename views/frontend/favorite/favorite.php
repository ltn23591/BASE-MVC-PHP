<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-semibold mb-8">❤️ Sản phẩm yêu thích của bạn</h1>

    <?php if (!empty($favorites)): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <?php foreach ($favorites as $item): ?>
                <div class="border rounded-lg p-3 shadow hover:shadow-lg transition">
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="w-full h-48 object-cover rounded">
                    <p class="mt-3 font-medium"><?= htmlspecialchars($item['name']) ?></p>
                    <p class="text-sm text-gray-500"><?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                    <button class="bg-red-500 text-white w-full mt-3 py-2 text-sm"
                        onclick="addToFavorites(<?= $item['id'] ?>)">Xóa</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500">Bạn chưa có sản phẩm yêu thích nào.</p>
    <?php endif; ?>
</div>
