<?php include __DIR__ . '/../layouts/title.php';
print_r($items);
?>

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
            <div class="py-4 grid grid-cols-[4fr_1fr_1fr_1fr] items-center gap-4">
                <div class="flex items-start gap-5">
                    <img class="w-20 h-20 object-cover border" src="<?= BASE_URL . $item['image'] ?>" alt="">
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