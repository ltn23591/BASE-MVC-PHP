<div class="p-6">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">📊 Thống kê doanh thu</h3>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Tổng Doanh Thu</h4>
            <p class="text-3xl font-bold mt-2"><?= number_format($totalRevenue ?? 0, 0, ',', '.') ?> VND</p>
            <p class="text-sm opacity-80 mt-1">Tất cả đơn "Đã giao"</p>
        </div>

        <div class="bg-indigo-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Hôm nay</h4>
            <p class="text-3xl font-bold mt-2"><?= number_format($todayRevenue ?? 0, 0, ',', '.') ?> VND</p>
            <p class="text-sm opacity-80 mt-1"><?= date('d/m/Y') ?></p>
        </div>

        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Chờ xác nhận</h4>
            <p class="text-3xl font-bold mt-2"><?= number_format($statusRevenues['Chờ xác nhận'] ?? 0, 0, ',', '.') ?>
                VND</p>
        </div>

        <div class="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold">Đang giao</h4>
            <p class="text-3xl font-bold mt-2"><?= number_format($statusRevenues['Đang giao'] ?? 0, 0, ',', '.') ?> VND
            </p>
        </div>
    </div>

    <!-- Danh sách đơn hàng gần đây -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-semibold text-gray-700 mb-4"> Đơn hàng gần đây</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Mã ĐH</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Khách hàng</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Ngày đặt</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm text-gray-600">Tổng tiền</th>
                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm text-gray-600">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php if (!empty($recentOrders)): ?>
                    <?php foreach ($recentOrders as $order): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="text-left py-3 px-4 font-medium">#<?= htmlspecialchars($order['id']) ?></td>
                        <td class="text-left py-3 px-4"><?= htmlspecialchars($order['user_name'] ?? 'Khách vãng lai') ?>
                        </td>
                        <td class="text-left py-3 px-4"><?= date('d/m/Y', strtotime($order['date'])) ?></td>
                        <td class="text-right py-3 px-4 font-semibold">
                            <?= number_format($order['amount'], 0, ',', '.') ?> VND</td>
                        <td class="text-center py-3 px-4">
                            <?php
                                    $statusClass = '';
                                    switch ($order['status']) {
                                        case 'Chờ xác nhận':
                                            $statusClass = 'bg-blue-200 text-blue-800';
                                            break;
                                        case 'Đang giao':
                                            $statusClass = 'bg-orange-200 text-orange-800';
                                            break;
                                        case 'Đã giao':
                                            $statusClass = 'bg-green-200 text-green-800';
                                            break;
                                        case 'Đã hủy':
                                            $statusClass = 'bg-red-200 text-red-800';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-200 text-gray-800';
                                            break;
                                    }
                                    ?>
                            <span class="py-1 px-3 rounded-full text-xs font-medium <?= $statusClass ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Chưa có đơn hàng nào.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>