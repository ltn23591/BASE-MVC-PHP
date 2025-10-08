<div class="border-t pt-16">
    <div class="text-2xl mb-4">
        <p class="font-bold">ĐƠN HÀNG <span class="text-orange-500">CỦA TÔI</span></p>
    </div>

    <div>
        <?php foreach ($orders as $order): ?>
        <div class="py-4 border-t text-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-sm">
                <p class="sm:text-base font-medium">ĐƠN HÀNG #<?= htmlspecialchars($order['id']) ?></p>
                <div class="flex items-center gap-3 mt-1 text-base text-gray-700">
                    <p>Tổng tiền: <?= number_format($order['amount'], 0, ',', '.') ?> VND</p>
                </div>
                <p class="mt-1">
                    NGÀY:
                    <span class="text-gray-400"><?= htmlspecialchars($order['date']) ?></span>
                </p>
                <p class="mt-1">
                    Phương thức thanh toán:
                    <span class="text-gray-400"><?= htmlspecialchars($order['paymentMethod']) ?></span>
                </p>
            </div>
            <div class="md:w-1/2 flex justify-between">
                <div class="flex items-center gap-2">
                    <p class="min-w-2 h-2 rounded-full bg-green-500"></p>
                    <p class="text-sm md:text-base">
                        <?= htmlspecialchars($order['status']) ?>
                    </p>
                    <a href="index.php?controllers=orderdetail&action=detail&id=<?= $order['id'] ?>">Xem chi
                        tiết đơn hàng</a>
                </div>


                <?php if ($order['status'] === 'Đã giao'): ?>

                <div class=" flex flex-col gap-2">
                    <div class="border px-4 py-2 text-sm font-medium rounded-sm">Đánh giá sản phẩm</div>
                    <?php else: ?>
                    <button class="border px-4 py-2 text-sm font-medium rounded-sm"
                        onclick="window.location.href = window.location.href">
                        Cập nhật trạng thái
                    </button>
                    <?php endif; ?>


                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>