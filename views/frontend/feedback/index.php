<?php
include './public/assets/img/frontend_assets/assets.php';
include __DIR__ . '/../layouts/title.php';

?>

<div class="border-t-2 pt-10 transition-opacity ease-in-out duration-500 opacity-100">

    <!-- Header -->
    <div class="text-center mb-10">
        <?= Title("ĐÁNH GIÁ", "SẢN PHẨM") ?>
        <p class="text-gray-600 mt-2 text-sm">Chia sẻ trải nghiệm của bạn để giúp người khác chọn mua dễ dàng hơn 💬</p>
    </div>

    <!-- Product Info -->
    <div class="max-w-3xl mx-auto bg-white shadow border rounded-md p-6 flex flex-col sm:flex-row gap-6">
        <img src="<?= htmlspecialchars($getProduct['image'][0]) ?>" alt="<?= htmlspecialchars($getProduct['name']) ?>"
            class="w-full sm:w-1/3 h-60 object-cover rounded">

        <div class="flex-1">
            <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($getProduct['name']) ?></h2>
            <p class="text-gray-600 mb-2">Giá:
                <span class="font-semibold text-orange-500">
                    <?= number_format($getProduct['price'], 0, ',', '.') ?> VND
                </span>
            </p>
            <p class="text-gray-500 text-sm leading-relaxed mb-3">
                <?= htmlspecialchars($getProduct['description']) ?>
            </p>

            <div class="flex items-center gap-1 text-yellow-400">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-regular fa-star"></i>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <div class="max-w-3xl mx-auto bg-white shadow border rounded-md mt-10 p-8">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">📝 Viết đánh giá của bạn</h3>

        <form id="reviewForm" method="POST" action="index.php?controllers=rating&action=store">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($getProduct['id']) ?>">
            <input type="hidden" name="rating" id="rating-value" value="0">

            <div class="flex items-center gap-1 mb-5" id="star-container">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <img src="<?= $assets['star_dull_icon'] ?>" data-value="<?= $i ?>"
                    class="w-7 cursor-pointer transition-transform duration-150 hover:scale-110 star-icon" alt="star">
                <?php endfor; ?>
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Viết nhận xét:
                </label>
                <textarea id="comment" name="comment" rows="4"
                    class="w-full border rounded-md px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-sm"
                    placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."></textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="index.php?controllers=order&action=index"
                    class="px-5 py-2 text-sm border rounded hover:bg-gray-100 transition">← Quay lại</a>
                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-md">
                    Gửi đánh giá
                </button>
            </div>
        </form>
    </div>

    <!-- Danh sách đánh giá -->
    <div class="max-w-3xl mx-auto mt-12">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">⭐ Đánh giá của khách hàng</h3>
        <?php if (!empty($reviews)): ?>
        <div class="space-y-5">
            <?php foreach ($reviews as $review): ?>
            <div class="border-b pb-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="font-semibold text-gray-800"><?= htmlspecialchars($review['user_name']) ?></span>
                    <p class="text-xs text-gray-400"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></p>
                </div>
                <div class="flex items-center gap-0.5 mt-1 text-yellow-400">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-solid fa-star <?= $i <= $review['rating'] ? '' : 'text-gray-300' ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mt-2"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-gray-500 italic">Chưa có đánh giá nào cho sản phẩm này.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".star-icon");
    const ratingValue = document.getElementById("rating-value");
    let selected = 0; // giá trị sao được chọn

    // Khi rê chuột qua sao
    stars.forEach((star, index) => {
        star.addEventListener("mouseover", () => {
            stars.forEach((s, i) => {
                s.src = i <= index ? "<?= $assets['star_icon'] ?>" :
                    "<?= $assets['star_dull_icon'] ?>";
            });
        });

        // Khi rời chuột khỏi vùng sao  trở lại trạng thái đã chọn
        star.addEventListener("mouseout", () => {
            stars.forEach((s, i) => {
                s.src = i < selected ? "<?= $assets['star_icon'] ?>" :
                    "<?= $assets['star_dull_icon'] ?>";
            });
        });

        // Khi click cố định lựa chọn
        star.addEventListener("click", () => {
            selected = index + 1;
            ratingValue.value = selected;
            stars.forEach((s, i) => {
                s.src = i < selected ? "<?= $assets['star_icon'] ?>" :
                    "<?= $assets['star_dull_icon'] ?>";
            });
        });
    });
});
</script>