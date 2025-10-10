<div class="p-6">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">📋 Thống kê doanh thu theo trạng thái</h3>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr
                    class="border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <th class="px-5 py-3">
                        Trạng thái đơn hàng
                    </th>
                    <th class="px-5 py-3 text-right">
                        Tổng doanh thu
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($revenueByStatus as $row): ?>
                <tr class="border-b border-gray-200 bg-white hover:bg-gray-50">
                    <td class="px-5 py-4 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap"><?= htmlspecialchars($row['status']) ?></p>
                    </td>
                    <td class="px-5 py-4 text-sm text-right">
                        <p class="text-green-600 font-semibold whitespace-no-wrap">
                            <?= number_format($row['total_revenue'], 0, ',', '.') ?> VND
                        </p>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>