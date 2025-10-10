<div class="container mx-auto mt-8 max-w-xl bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">🎟️ Thêm Voucher Mới</h2>

    <form action="index.php?controllers=admin&action=saveVoucher" method="POST" class="space-y-5">
        <!-- Mã Voucher -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Mã Voucher</label>
            <input type="text" name="code"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Nhập mã giảm giá (VD: SALE20)" required>
        </div>

        <!-- Phần trăm giảm -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Giảm giá (%)</label>
            <input type="number" name="discount" min="0" max="100"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Nhập số phần trăm giảm (VD: 20)" required>
        </div>

        <!-- Ngày bắt đầu -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Ngày bắt đầu</label>
            <input type="date" name="start_date"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   required>
        </div>

        <!-- Ngày kết thúc -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Ngày kết thúc</label>
            <input type="date" name="end_date"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   required>
        </div>

        <!-- Nút gửi -->
        <div class="text-center mt-6">
            <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-all">
                💾 Lưu Voucher
            </button>
        </div>
    </form>
</div>