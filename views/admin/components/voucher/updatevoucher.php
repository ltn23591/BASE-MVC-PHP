<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-100 py-20 px-4">
    <form action="index.php?controllers=admin&action=updateVoucher&id=<?= $voucher['id'] ?>" method="POST"
        class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg">
        
        <input type="hidden" name="id" value="<?= $voucher['id'] ?>">

        <!-- Single Vertical Column -->
        <div class="space-y-6">
            <!-- Voucher Code -->
            <div class="w-full">
                <label class="block mb-2 font-semibold text-gray-700">🎟 Mã Voucher</label>
                <input name="code" value="<?= htmlspecialchars($voucher['code']) ?>"
                    class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="Nhập mã voucher (VD: SUMMER2025)" required>
            </div>

            <!-- Discount -->
            <div class="w-full">
                <label class="block mb-2 font-semibold text-gray-700">💸 Giá trị giảm giá (%)</label>
                <input name="discount" type="number" min="0" max="100" value="<?= $voucher['discount'] ?>"
                    class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="Nhập % giảm giá (0-100)" required>
                <p class="mt-2 text-sm text-gray-500">Giá trị giảm giá tính theo phần trăm</p>
            </div>

            <!-- Start Date -->
            <div class="w-full">
                <label class="block mb-2 font-semibold text-gray-700">📅 Ngày bắt đầu</label>
                <input name="start_date" type="date" value="<?= $voucher['start_date'] ?>"
                    class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
            </div>

            <!-- End Date -->
            <div class="w-full">
                <label class="block mb-2 font-semibold text-gray-700">📅 Ngày hết hạn</label>
                <input name="end_date" type="date" value="<?= $voucher['end_date'] ?>"
                    class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
            </div>
        </div>

        <!-- Submit Button (Centered at Bottom) -->
        <div class="mt-8 flex justify-center">
            <button type="submit"
                class="w-full max-w-xs py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                💾 Cập nhật
            </button>
        </div>
    </form>
</div>