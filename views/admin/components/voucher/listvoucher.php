<div class="p-6 bg-gray-50 min-h-screen">
    <div class="w-fit max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Danh Sách Khuyến Mãi</h1>
        </div>

        <div class="">
            <table class="w-fit border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 5%;">STT</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 20%;">Mã Khuyến Mãi</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 15%;">Giá trị (%)</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 20%;">Ngày bắt đầu</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 20%;">Ngày kết thúc</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 10%;">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase whitespace-nowrap" style="width: 25%;">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $i = 1; foreach($vouchers as $voucher): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700 text-center whitespace-nowrap"><?= $i++ ?></td>
                            <td class="px-6 py-4 font-medium text-gray-800 text-center whitespace-nowrap"><?= $voucher['code'] ?></td>
                            <td class="px-6 py-4 text-gray-700 text-center whitespace-nowrap"><?= $voucher['discount'] ?>%</td>
                            <td class="px-6 py-4 text-gray-600 text-center whitespace-nowrap"><?= $voucher['start_date'] ?></td>
                            <td class="px-6 py-4 text-gray-600 text-center whitespace-nowrap"><?= $voucher['end_date'] ?></td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <?php if (strtotime($voucher['end_date']) < time()): ?>
                                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full inline-block">Hết hạn</span>
                                <?php else: ?>
                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full inline-block">Còn hiệu lực</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="index.php?controllers=admin&action=updateVoucher&id=<?= $voucher['id'] ?>"
                                   class="text-blue-600 hover:text-blue-800 font-medium mr-4 inline-block">Sửa</a>
                                <a href="index.php?controllers=admin&action=deleteVoucher&id=<?= $voucher['id'] ?>" 
                                   onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này không?')" 
                                   class="text-red-600 hover:text-red-800 font-medium inline-block">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>