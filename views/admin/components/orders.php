<div class="p-6">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">📦 Đơn hàng</h3>

    <div class="space-y-6">
        <?php foreach ($orders as $order): ?>
        <?php $isCanceled = ($order['status'] === 'Đã hủy'); ?>

        <form method="POST" action="index.php?controllers=admin&action=updateOrderStatus"
            class="w-[1000px] grid grid-cols-1 sm:grid-cols-5 gap-4 items-center bg-white border rounded-lg shadow-sm p-5 hover:shadow-md transition js-order-form">

            <!-- information -->
            <div>
                <p class="font-semibold text-gray-800">#<?= htmlspecialchars($order['id']) ?></p>
                <p class="text-sm text-gray-600">👤 User: <?= htmlspecialchars($order['user_id']) ?></p>
                <p class="font-semibold text-gray-800">#<?= htmlspecialchars($order['firstName']) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($order['lastName']) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($order['email']) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($order['street']) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($order['city']) ?></p>
            </div>

            <!-- Amount + Total -->
            <div>
                <p class="text-gray-700">Số lượng: <span class="font-medium"><?= (int)$order['quantity'] ?></span></p>
                <p class="text-gray-700">Tổng tiền:
                    <span class="font-semibold <?= $isCanceled ? 'text-red-600' : 'text-green-600' ?>">
                        <?= number_format((float)($order['amount'] ?? 0), 0, ',', '.') ?> đ
                    </span>
                </p>
            </div>

            <!-- Payment + Date -->
            <div>
                <p class="text-sm text-gray-500">📅 <?= htmlspecialchars($order['date']) ?></p>
            </div>

            <!-- Status -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <span class="text-sm text-gray-700 font-medium">Trạng thái:</span>
                <?php if ($isCanceled): ?>
                <span class="bg-red-100 text-red-600 px-3 py-1.5 rounded-md text-sm font-semibold">
                    Đã hủy
                </span>
                <?php else: ?>
                <select name="status"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <?php
                            $statuses = ['Đã đặt hàng', 'Đang đóng gói', 'Đã gửi', 'Đang giao', 'Đã giao', 'Đã hủy'];
                            foreach ($statuses as $st) {
                                $sel = ($order['status'] === $st) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($st) . '" ' . $sel . '>' . htmlspecialchars($st) . '</option>';
                            }
                            ?>
                </select>
                <?php endif; ?>
            </div>

            <!-- Action -->
            <div class="text-right">
                <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>" />
                <input type="hidden" name="ajax" value="1" />
                <button type="submit"
                    class="text-nowrap <?= $isCanceled ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' ?> text-white ml-5 px-5 py-2 rounded-lg shadow transition"
                    <?= $isCanceled ? 'disabled' : '' ?>>
                    <?= $isCanceled ? ' Đã hủy' : ' Cập nhật' ?>
                </button>
            </div>
        </form>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.querySelectorAll('.js-order-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data && data.success) {
                    if (window.Toastify) {
                        Toastify({
                            text: ' Đã cập nhật trạng thái đơn hàng',
                            duration: 2000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: "#16a34a"
                        }).showToast();
                    } else {
                        alert(' Cập nhật thành công');
                    }
                } else {
                    alert(' Cập nhật thất bại');
                }
            })
            .catch(() => alert(' Lỗi mạng'));
    });
});
</script>