<div class="border-t pt-10 sm:pt-16">
    <!-- Tiêu đề -->
    <div class="text-2xl mb-8 text-center sm:text-left">
        <p class="font-bold tracking-wide">
            ĐƠN HÀNG <span class="text-orange-500">CỦA TÔI</span>
        </p>
    </div>

    <!-- Danh sách đơn hàng -->
    <div class="flex flex-col gap-5">
        <?php foreach ($orders as $order): ?>
        <?php
            $status = htmlspecialchars($order['status']);
            $statusColor = match ($status) {
                'Đã giao' => 'bg-green-500 text-green-600',
                'Yêu cầu hủy' => 'bg-red-500 text-red-600',
                'Đang giao' => 'bg-yellow-400 text-yellow-500',
                default => 'bg-gray-400 text-gray-500'
            };
            ?>
        <!-- Card đơn hàng -->
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 px-5 py-6 sm:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                <!-- Thông tin đơn -->
                <div class="flex-1 text-sm sm:text-base text-gray-700">
                    <p class="font-semibold text-lg mb-1">
                        ĐƠN HÀNG #<?= htmlspecialchars($order['id']) ?>
                    </p>
                    <p class="mt-1">Tổng tiền:
                        <span class="font-bold text-green-600">
                            <?= number_format($order['amount'], 0, ',', '.') ?> VND
                        </span>
                    </p>
                    <p class="mt-1">
                        Ngày đặt: <span class="text-gray-500"><?= htmlspecialchars($order['date']) ?></span>
                    </p>
                    <p class="mt-1">
                        Thanh toán: <span class="text-gray-500"><?= htmlspecialchars($order['paymentMethod']) ?></span>
                    </p>
                </div>

                <!-- Trạng thái & nút -->
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between md:justify-end gap-3 md:gap-4 w-full md:w-auto">

                    <!-- Trạng thái -->
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full <?= $statusColor ?>"></span>
                        <p class="font-medium <?= explode(' ', $statusColor)[1] ?>">
                            <?= $status ?>
                        </p>
                    </div>

                    <!-- Link xem chi tiết -->
                    <a href="index.php?controllers=orderdetail&action=detail&id=<?= $order['id'] ?>"
                        class="text-blue-600 hover:text-blue-700 text-sm sm:text-base font-medium underline-offset-2 hover:underline transition">
                        Xem chi tiết đơn hàng
                    </a>

                    <!-- Nút hành động -->
                    <button
                        class="border border-gray-300 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition"
                        onclick="window.location.reload()">
                        Cập nhật trạng thái
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>