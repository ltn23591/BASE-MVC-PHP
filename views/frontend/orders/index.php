<div class="max-w-5xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📦 Đơn hàng của bạn</h2>

    <?php if (empty($orders)): ?>
    <p class="text-gray-500">Bạn chưa có đơn hàng nào.</p>
    <?php else: ?>
    <?php foreach ($orders as $order): ?>
    <div class="border p-5 rounded-lg mb-4 bg-white shadow-sm hover:shadow-md transition">
        <p><strong>Mã đơn:</strong> #<?= $order['id'] ?></p>
        <p><strong>Trạng thái:</strong>
            <span class="text-blue-600 font-medium"><?= htmlspecialchars($order['status']) ?></span>
        </p>
        <p><strong>Tổng tiền:</strong> <?= number_format($order['amount'], 0, ',', '.') ?>đ</p>
        <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['date']) ?></p>

        <div class="mt-3 flex gap-3">
            <a href="index.php?controllers=orderdetail&action=detail&id=<?= $order['id'] ?>"
                class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fa-solid fa-magnifying-glass"></i> Xem chi tiết
            </a>

            <?php if (in_array($order['status'], ['Chờ xác nhận', 'Đã đặt hàng', 'Đang đóng gói'])): ?>
            <form method="POST" action="index.php?controllers=order&action=cancel"
                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    <i class="fa-solid fa-xmark"></i> Hủy đơn hàng
                </button>
            </form>
            <?php elseif ($order['status'] === 'Đã hủy'): ?>
            <span class="text-red-500 font-semibold">Đơn hàng đã bị hủy</span>
            <?php else: ?>
            <span class="text-gray-500 italic">Không thể hủy (đang giao hoặc đã giao)</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>