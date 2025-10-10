<h2 class="text-2xl font-bold mb-6 text-gray-800">
    <i class="fa-solid fa-plus"></i> Thêm sản phẩm mới
</h2>

<form action="index.php?controllers=admin&action=add" method="POST" enctype="multipart/form-data"
    class="flex flex-col w-full items-start gap-6 bg-white p-6 rounded-lg shadow-md">

    <!-- Upload -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700"><i class="fa-solid fa-camera"></i> Ảnh</p>
        <input type="file" name="images[]" multiple class="block w-full max-w-[500px] border rounded-lg px-3 py-2 text-sm file:mr-3 file:py-2 file:px-4 
      file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        <small class="text-gray-500">Chọn tối đa 4 ảnh</small>
    </div>

    <!-- Name -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700"><i class="fa-solid fa-notes-medical"></i> Tên Sản Phẩm</p>
        <input name="name" class="w-full max-w-[500px] py-3 px-3 border rounded-lg focus:ring-2 focus:ring-blue-400"
            type="text" required>
    </div>

    <!-- Description -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700">📝 Mô Tả Sản Phẩm</p>
        <textarea name="description" rows="4"
            class="w-full max-w-[500px] py-3 px-3 border rounded-lg focus:ring-2 focus:ring-blue-400"
            required></textarea>
    </div>

    <!-- Category -->
    <div class="flex flex-col sm:flex-row gap-4 w-full">
        <div>
            <p class="mb-2 font-medium text-gray-700">📂 Danh mục</p>
            <select name="category" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Trẻ Em">Trẻ em</option>
            </select>
        </div>

        <div>
            <p class="mb-2 font-medium text-gray-700">📑 Danh mục phụ</p>
            <select name="subCategory" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="Topwear">Áo</option>
                <option value="Bottomwear">Quần</option>
                <option value="Winterwear">Đồ mùa đông</option>
            </select>
        </div>

        <div>
            <p class="mb-2 font-medium text-gray-700"><i class="fa-solid fa-money-bill-1"></i> Giá</p>
            <input name="price" class="w-full px-3 py-2 border rounded-lg sm:w-[150px] focus:ring-2 focus:ring-blue-400"
                type="number" required>
        </div>
    </div>

    <!-- Sizes -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700"><i class="fa-solid fa-ruler"></i> Kích Thước & Số Lượng</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
                <div class="flex flex-col items-start border rounded-lg p-3 shadow-sm">
                    <label class="font-medium text-gray-700 mb-1"><?= $size ?></label>
                    <input type="number" name="sizes[<?= $size ?>]" value="0" min="0"
                        class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-400"
                        placeholder="Số lượng <?= $size ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bestseller -->
    <div class="flex gap-2 items-center">
        <input type="checkbox" name="bestseller" id="bestseller"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
        <label for="bestseller" class="text-gray-700"><i class="fa-solid fa-chart-simple"></i> Bán Chạy</label>
    </div>

    <!-- Submit -->
    <button type="submit"
        class="w-32 py-3 mt-4 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
        ➕ Thêm
    </button>
</form>