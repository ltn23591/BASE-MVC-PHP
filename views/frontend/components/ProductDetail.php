<?php
include './public/assets/img/frontend_assets/assets.php';
include __DIR__ . '/../layouts/title.php';
require __DIR__ . '/ProductItem.php';

$emptyStars  = 5 - $averageRating;
?>
<div class="border-t-2 pt-10 transition-opacity ease-in-out duration-500 opacity-100">

    <!-- Product Data -->
    <div class="flex gap-12 sm:gap-12 flex-col sm:flex-row">
        <!-- Product Images -->
        <div class="flex-1 flex flex-col-reverse gap-3 sm:flex-row">
            <!-- Thumbnail list -->
            <div
                class="flex sm:flex-col overflow-x-auto sm:overflow-y-scroll justify-between sm:justify-normal sm:w-[18.7%] w-full">
                <?php foreach ($product['image'] as $item): ?>
                <img src="<?= htmlspecialchars($item) ?>" alt="thumb"
                    class="w-[24%] sm:w-full sm:mb-3 flex shrink-0 cursor-pointer"
                    onclick="document.getElementById('mainImage').src='<?= htmlspecialchars($item) ?>'">
                <?php endforeach; ?>

            </div>

            <!-- Main image -->
            <div class="w-full sm:w-[80%]">
                <img id="mainImage" src="<?= htmlspecialchars($product['image'][0]) ?>" class="w-full h-auto" alt="">
            </div>
        </div>

        <!-- Product Info -->
        <div class="flex-1 text-left">
            <h1 class="font-medium text-2xl mt-2">
                <?= htmlspecialchars($product['name']) ?>
            </h1>
            <div class="flex items-center gap-1 mt-2">
                <!-- Sao vàng -->
                <?php for ($i = 0; $i < $averageRating; $i++): ?>
                <img src="<?= $assets['star_icon'] ?>" alt="⭐" class="w-3.5">
                <?php endfor; ?>
                <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                <img src="<?= $assets['star_dull_icon'] ?>" alt="" class="w-3.5">
                <?php endfor; ?>
            </div>
            <!-- Giá -->
            <p class="mt-5 text-3xl font-medium">
                <?= number_format(htmlspecialchars($product['price']), 0, ',', '.') ?> VND
            </p>
            <!-- Mô tả ngắn -->
            <?php $sizes = !empty($product['sizes']) ? json_decode($product['sizes'], true) : []; ?>
            <div class="flex flex-col gap-4 my-8">
                <p>Chọn kích thước</p>
                <div class="flex gap-2">
                    <?php if (!empty($productSizes)): ?>
                    <?php foreach ($productSizes as $row): ?>
                    <button class="size-btn border py-2 px-4 bg-gray-100"
                        onclick="selectSize('<?= $row['size'] ?>', this)">
                        <?= htmlspecialchars($row['size']) ?> (<?= (int)$row['quantity'] ?>)
                    </button>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-gray-500 italic">Sản phẩm này hiện chưa có size nào.</p>
                    <?php endif; ?>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-4">Số lượng tồn kho: <span class="font-bold"><?= $totalProduct ?></span>
            </p>

            <div class="mt-4 flex items-center gap-3">
                <?php if ((int)($totalProduct ?? 0) > 0): ?>
                <button
                    onclick="addToCartt(<?= $product['id'] ?>,'<?= $product['name'] ?>','<?= $product['image'][0] ?>', <?= $product['price'] ?>)"
                    class="bg-black text-white px-2 py-3 text-sm active:bg-gray-700 hover:bg-gray-800 transition">
                    THÊM VÀO GIỎ HÀNG
                </button>
                <button
                    onclick="buyNow(<?= $product['id'] ?>,'<?= $product['name'] ?>','<?= $product['image'][0] ?>', <?= $product['price'] ?>)"
                    class="bg-orange-400 text-white px-2 py-3 text-sm active:bg-gray-700 hover:bg-orange-500 transition">
                    MUA NGAY
                </button>
                <button onclick="addToFavorites(<?= $product['id'] ?>)"
                    class="w-10 h-10 flex items-center justify-center border border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                    <i class="fa fa-heart text-lg"></i>
                </button>
                <?php else: ?>
                <button class="bg-gray-400 text-white px-4 py-3 text-sm cursor-not-allowed" disabled>HẾT HÀNG</button>
                <?php endif; ?>
            </div>

            <hr class="mt-8 sm:w-4/5">
            <div class="text-sm text-gray-500 mt-5 flex flex-col gap-1">
                <p>Sản phẩm chính hãng 100%</p>
                <p>Hỗ trợ thanh toán khi nhận hàng (COD)</p>
                <p>Chính sách đổi trả dễ dàng trong vòng 7 ngày</p>
            </div>
        </div>
    </div>

    <!-- Description & Reviews -->
    <div class="mt-20 w-full max-w mx-auto">
        <!-- Tabs -->
        <div class="flex border-b text-sm font-medium text-gray-600">
            <button id="tab-desc"
                class="tab-btn border-b-2 border-blue-600 text-blue-600 px-5 py-3 focus:outline-none transition">
                📄 Mô tả sản phẩm
            </button>
            <button id="tab-reviews"
                class="tab-btn border-b-2 border-transparent hover:border-blue-400 hover:text-blue-600 px-5 py-3 focus:outline-none transition">
                ⭐ Đánh giá <?= $totalReviewsResult ?>
            </button>
        </div>

        <!-- Nội dung mô tả -->
        <div id="content-desc" class="tab-content border px-6 py-6 text-sm text-gray-600 leading-relaxed space-y-4">
            <p>
                <?= htmlspecialchars($product['description']) ?>
            </p>
            <ul class="list-disc pl-6">
                <li>✔️ Sản phẩm chính hãng, chất lượng cao.</li>
                <li>✔️ Thiết kế hiện đại phù hợp với xu hướng.</li>
                <li>✔️ Bảo hành lên tới 12 tháng.</li>
            </ul>
        </div>

        <!-- Nội dung đánh giá -->
        <div id="content-reviews" class="tab-content hidden border px-6 py-6 text-sm text-gray-600 space-y-6">
            <?php if (!empty($getAllRatings)): ?>
            <?php foreach ($getAllRatings as $review): ?>
            <div class="border-b border-gray-200 pb-5">
                <div class="flex items-start gap-4">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold">
                            <?= strtoupper(substr($review['name'], 0, 1)) ?>
                        </div>
                    </div>

                    <!-- Nội dung đánh giá -->
                    <div class="flex-1">
                        <!-- Tên & số sao -->
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-gray-800"><?= htmlspecialchars($review['name']) ?></p>
                            <p class="text-xs text-gray-400"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                            </p>
                        </div>

                        <!-- Hiển thị sao -->
                        <div class="flex items-center gap-0.5 mt-1">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="<?= $i <= $review['rating'] ? '#facc15' : '#e5e7eb' ?>" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l1.624 3.904
                                        4.216.345c1.164.095 1.636 1.545.747 2.305l-3.203 2.713
                                        1.007 4.062c.275 1.11-.934 1.986-1.897 1.384L12 16.347
                                        8.294 17.923c-.963.602-2.172-.273-1.897-1.384l1.007-4.062
                                        -3.203-2.713c-.889-.76-.417-2.21.747-2.305l4.216-.345
                                        1.624-3.904z" clip-rule="evenodd" />
                            </svg>
                            <?php endfor; ?>
                        </div>

                        <!-- Bình luận -->
                        <p class="mt-2 text-gray-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($review['comment'])) ?>
                        </p>

                        <!-- (Tuỳ chọn) ảnh review nếu thêm cột image_review -->
                        <!--
                        <div class="flex gap-2 mt-3">
                            <img src="link_anh.jpg" alt="" class="w-20 h-20 object-cover rounded border">
                            <img src="link_anh2.jpg" alt="" class="w-20 h-20 object-cover rounded border">
                        </div>
                        -->

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-500 italic">Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php endif; ?>

        </div>


    </div>
    <!-- Sản phẩm liên quan -->
    <div class='my-24'>
        <div class="text-center text-3xl py-2">
            <?php if (!empty($related) && count($related) > 0): ?>
            <?= Title("SẢN PHẨM", "LIÊN QUAN"); ?>
            <?php else: ?>
            <?= $empty; ?>
            <?php endif; ?>

        </div>
        <div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 mb-5'>
            <?php
            foreach ($related as $p) {
                ProductItem($p['id'], $p['image'], $p['name'], $p['price']);
            }
            ?>
        </div>
    </div>
</div>

<script src="./public/assets/js/favorite.js"></script>

<!-- JS chuyển tab -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const tabDesc = document.getElementById("tab-desc");
    const tabReviews = document.getElementById("tab-reviews");
    const contentDesc = document.getElementById("content-desc");
    const contentReviews = document.getElementById("content-reviews");

    tabDesc.addEventListener("click", () => {
        tabDesc.classList.add("border-blue-600", "text-blue-600");
        tabReviews.classList.remove("border-blue-600", "text-blue-600");
        contentDesc.classList.remove("hidden");
        contentReviews.classList.add("hidden");
    });

    tabReviews.addEventListener("click", () => {
        tabReviews.classList.add("border-blue-600", "text-blue-600");
        tabDesc.classList.remove("border-blue-600", "text-blue-600");
        contentReviews.classList.remove("hidden");
        contentDesc.classList.add("hidden");
    });
});
</>

