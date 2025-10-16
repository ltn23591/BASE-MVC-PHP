<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <form action="index.php?controllers=admin&action=update" method="POST" enctype="multipart/form-data"
        class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Image, Category, Sizes -->
            <div class="space-y-6">
                <!-- Upload -->
                <div class="w-full">
                    <label class="block mb-2 font-semibold text-gray-700">📷 Ảnh sản phẩm</label>
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <img src="<?= json_decode($product['image'])[0] ?>" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-200">
                        <input type="file" name="images[]" multiple
                            class="file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Tải lên ảnh mới nếu muốn thay đổi (hỗ trợ nhiều ảnh)</p>
                </div>

                <!-- Category and Sizes (Side by Side) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Category -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">📚 Danh mục</label>
                        <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="Nam" <?= $product['category'] == 'Men' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?= $product['category'] == 'Women' ? 'selected' : '' ?>>Nữ</option>
                            <option value="Trẻ Em" <?= $product['category'] == 'Kid' ? 'selected' : '' ?>>Trẻ em</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Right Column: Name, Description -->
            <div class="space-y-6">
                <!-- Name -->
                <div class="w-full">
                    <label class="block mb-2 font-semibold text-gray-700">🛍 Tên sản phẩm</label>
                    <input name="name" value="<?= htmlspecialchars($product['name']) ?>"
                        class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <!-- Description -->
                <div class="w-full">
                    <label class="block mb-2 font-semibold text-gray-700">📝 Mô tả</label>
                    <textarea name="description" rows="8"
                        class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-y transition"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Price and Submit Button -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Price -->
            <div>
                <label class="block mb-2 font-semibold text-gray-700">💰 Giá</label>
                <input name="price" value="<?= $product['price'] ?>" type="number" min="0"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <!-- Submit Button -->
            <div class="flex items-end justify-center">
                <button type="submit"
                    class="w-full sm:w-48 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    💾 Cập nhật
                </button>
            </div>
        </div>
    </form>
</div>