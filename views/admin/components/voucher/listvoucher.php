<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🎟️ Danh sách Voucher</h1>
            <a href="index.php?controller=admin&action=addVoucher" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">
                + Thêm Voucher
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Mã voucher</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Giá trị (%)</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Ngày bắt đầu</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Ngày kết thúc</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $i = 1; foreach($vouchers as $voucher): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700"><?= $i++ ?></td>
                            <td class="px-6 py-4 font-medium text-gray-800"><?= $voucher['code'] ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= $voucher['discount'] ?>%</td>
                            <td class="px-6 py-4 text-gray-600"><?= $voucher['start_date'] ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $voucher['end_date'] ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php if (strtotime($voucher['end_date']) < time()): ?>
                                    <span class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded-full">Hết hạn</span>
                                <?php else: ?>
                                    <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">Còn hiệu lực</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="index.php?controller=admin&action=editVoucher&id=<?= $voucher['id'] ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium mr-3">Sửa</a>
                                <a href="index.php?controller=admin&action=deleteVoucher&id=<?= $voucher['id'] ?>" 
                                   onclick="return confirm('Bạn có chắc muốn xóa voucher này không?')" 
                                   class="text-red-600 hover:text-red-800 font-medium">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
