<?php include __DIR__ . '/../layouts/title.php'; ?>

<div class="container max-w-5xl mx-auto px-4 py-10">

    <!-- 🧾 Tiêu đề -->
    <div class="text-3xl font-bold text-center mb-10">
        <?= Title("CHI TIẾT", "ĐƠN HÀNG") ?>
    </div>

    <!--🧑‍💼 Thông tin đơn hàng -->
    <div class="bg-white shadow rounded p-6 mb-10 border">
        <h2 class="text-xl font-semibold mb-4">📦 Thông tin đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 text-sm">
            <p><b>Họ tên:</b> <?= htmlspecialchars($order['firstName'] . ' ' . $order['lastName']) ?></p>
            <p><b>Số điện thoại:</b> <?= htmlspecialchars($order['phone']) ?></p>
            <p><b>Địa chỉ:</b>
                <?= htmlspecialchars($order['street'] . ', ' . $order['city'] . ', ' . $order['country']) ?></p>
            <p><b>Trạng thái:</b> <span class="text-orange-500"><?= htmlspecialchars($order['status']) ?></span></p>
            <p><b>Phương thức thanh toán:</b> <?= htmlspecialchars($order['paymentMethod']) ?></p>
            <p><b>Ngày đặt hàng:</b> <?= date('d/m/Y H:i', $order['date']) ?></p>
            <p><b>Tổng sản phẩm:</b> <?= htmlspecialchars($order['quantity']) ?></p>
            <p><b>Tổng tiền:</b> <?= number_format($order['amount'], 0, ',', '.') ?> VND</p>
        </div>
    </div>

    <!-- 🛍️ Danh sách sản phẩm -->
    <div class="bg-white shadow rounded p-6 border">
        <h2 class="text-xl font-semibold mb-6">🛒 Sản phẩm trong đơn hàng</h2>

        <?php if (!empty($items)): ?>
        <div class="divide-y">
            <?php foreach ($items as $item): ?>
            <?php
                // Decode the image JSON and get the first image.
                $images = json_decode($item['image'], true);
                $first_image = !empty($images) ? $images[0] : ''; // Set empty string if no image
            ?>
            <div class="py-4 grid grid-cols-[4fr_1fr_1fr_1fr_1fr] items-center gap-4">
                <div class="flex items-start gap-5">
                    <?php if ($first_image): ?>
                    <img class="w-20 h-20 object-cover border" src="<?= htmlspecialchars($first_image) ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>">
                    <?php endif; ?>
                    <div>
                        <p class="font-medium"><?= htmlspecialchars($item['name']) ?></p>
                        <p class="text-sm text-gray-500">Size: <?= htmlspecialchars($item['size']) ?></p>
                    </div>
                </div>
                <div class="text-center">
                    <?= number_format($item['price'], 0, ',', '.') ?> VND
                </div>
                <div class="text-center">
                    <?= htmlspecialchars($item['quantity']) ?>
                </div>
                <div class="text-right font-semibold">
                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-right mt-8 text-lg font-semibold">
            Tổng cộng: <span class="text-orange-600"><?= number_format($order['amount'], 0, ',', '.') ?> VND</span>
        </div>
        <?php else: ?>
        <p class="text-gray-500">Không có sản phẩm nào trong đơn hàng này.</p>
        <?php endif; ?>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-10 text-center">
        <a href="index.php?controllers=order&action=index"
            class="bg-black text-white px-8 py-3 rounded hover:bg-gray-800 transition">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>

</div>

<!-- Rating Modal -->
<div id="ratingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Đánh giá sản phẩm</h2>
        <form id="ratingForm" action="index.php?controllers=rating&action=store" method="POST">
            <input type="hidden" name="product_id" id="modalProductId">
            <input type="hidden" name="order_id" id="modalOrderId">

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Đánh giá của bạn:</label>
                <div class="flex flex-row-reverse items-center justify-end">
                    <input type="radio" name="rating" id="star1" value="1" class="hidden" required><label for="star1"
                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                    <input type="radio" name="rating" id="star2" value="2" class="hidden"><label for="star2"
                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                    <input type="radio" name="rating" id="star3" value="3" class="hidden"><label for="star3"
                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                    <input type="radio" name="rating" id="star4" value="4" class="hidden"><label for="star4"
                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                    <input type="radio" name="rating" id="star5" value="5" class="hidden"><label for="star5"
                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                </div>
            </div>

            <div class="mb-6">
                <label for="comment" class="block text-gray-700 mb-2">Bình luận:</label>
                <textarea name="comment" id="comment" rows="4" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeRatingModal()"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Hủy</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRatingModal(productId, orderId) {
    document.getElementById('modalProductId').value = productId;
    document.getElementById('modalOrderId').value = orderId;
    document.getElementById('ratingModal').classList.remove('hidden');
}

function closeRatingModal() {
    document.getElementById('ratingModal').classList.add('hidden');
}

// Star rating interaction
const stars = document.querySelectorAll('input[name="rating"] + label');
const ratingContainer = stars[0].parentElement;

ratingContainer.addEventListener('click', (e) => {
    if (e.target.tagName === 'LABEL') {
        const clickedStarValue = e.target.previousElementSibling.value;
        stars.forEach((star, index) => {
            if (index < clickedStarValue) {
                star.classList.remove('text-gray-400');
                star.classList.add('text-yellow-500');
            } else {
                star.classList.remove('text-yellow-500');
                star.classList.add('text-gray-400');
            }
        });
    }
});
</script>