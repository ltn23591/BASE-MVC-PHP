<h2 class="text-2xl font-bold mb-6 text-gray-800">➕ Thêm sản phẩm mới</h2>

<form action="index.php?controllers=admin&action=add" method="POST" enctype="multipart/form-data"
    class="flex flex-col w-full items-start gap-6 bg-white p-6 rounded-lg shadow-md">

    <!-- Upload -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700">📷 Upload Images</p>
        <input type="file" name="images[]" multiple
            class="block w-full max-w-[500px] border rounded-lg px-3 py-2 text-sm file:mr-3 file:py-2 file:px-4 
                      file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        <small class="text-gray-500">Chọn tối đa 4 ảnh</small>
    </div>

    <!-- Name -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700">🛍 Product name</p>
        <input name="name" class="w-full max-w-[500px] py-3 px-3 border rounded-lg focus:ring-2 focus:ring-blue-400" type="text" required>
    </div>

    <!-- Description -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700">📝 Product description</p>
        <textarea name="description" rows="4"
            class="w-full max-w-[500px] py-3 px-3 border rounded-lg focus:ring-2 focus:ring-blue-400" required></textarea>
    </div>

    <!-- Category -->
    <div class="flex flex-col sm:flex-row gap-4 w-full">
        <div>
            <p class="mb-2 font-medium text-gray-700">📂 Category</p>
            <select name="category" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Kid">Kid</option>
            </select>
        </div>

        <div>
            <p class="mb-2 font-medium text-gray-700">📑 Sub category</p>
            <select name="subCategory" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="Topwear">Topwear</option>
                <option value="Bottomwear">Bottomwear</option>
                <option value="Winterwear">Winterwear</option>
            </select>
        </div>

        <div>
            <p class="mb-2 font-medium text-gray-700">💲 Price</p>
            <input name="price" class="w-full px-3 py-2 border rounded-lg sm:w-[150px] focus:ring-2 focus:ring-blue-400" type="number" required>
        </div>
    </div>

    <!-- Sizes -->
    <div class="w-full">
        <p class="mb-2 font-medium text-gray-700">📏 Sizes</p>
        <div class="flex flex-wrap gap-3">
            <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
                <label class="cursor-pointer">
                    <input type="checkbox" name="sizes[]" value="<?= $size ?>" class="hidden peer">
                    <p class="peer-checked:bg-blue-600 peer-checked:text-white bg-slate-200 px-4 py-2 rounded-lg transition">
                        <?= $size ?>
                    </p>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bestseller -->
    <div class="flex gap-2 items-center">
        <input type="checkbox" name="bestseller" id="bestseller" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
        <label for="bestseller" class="text-gray-700">🌟 Add to bestseller</label>
    </div>

    <!-- Submit -->
    <button type="submit"
        class="w-32 py-3 mt-4 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
        ➕ ADD
    </button>
</form>