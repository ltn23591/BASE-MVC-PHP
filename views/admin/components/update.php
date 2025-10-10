  <script src="https://cdn.tailwindcss.com"></script>
  <form action="index.php?controllers=admin&action=update" method="POST" enctype="multipart/form-data"
      class="flex flex-col w-full items-start gap-6 bg-white p-6 rounded-lg shadow-md">

      <input type="hidden" name="id" value="<?= $product['id'] ?>">

      <!-- Upload -->
      <div class="w-full">
          <p class="mb-2 font-medium text-gray-700">📷 Ảnh (tải mới nếu muốn)</p>
          <input type="file" name="images[]" multiple>
          <img src="<?= json_decode($product['image'])[0] ?>" class="w-20 mt-2 rounded">
      </div>

      <!-- Name -->
      <div class="w-full">
          <p class="mb-2 font-medium text-gray-700">🛍 Tên Sản Phẩm</p>
          <input name="name" value="<?= htmlspecialchars($product['name']) ?>"
              class="w-full py-3 px-3 border rounded-lg">
      </div>

      <!-- Description -->
      <div class="w-full">
          <p class="mb-2 font-medium text-gray-700">📝 Mô Tả</p>
          <textarea name="description" rows="4"
              class="w-full py-3 px-3 border rounded-lg"><?= htmlspecialchars($product['description']) ?></textarea>
      </div>

      <!-- Category -->
      <div class="flex gap-4 w-full">
          <select name="category" class="px-3 py-2 border rounded-lg">
              <option value="Nam" <?= $product['category'] == 'Men' ? 'selected' : '' ?>>Nam</option>
              <option value="Nữ" <?= $product['category'] == 'Women' ? 'selected' : '' ?>>Nữ</option>
              <option value="Trẻ Em" <?= $product['category'] == 'Kid' ? 'selected' : '' ?>>Trẻ em</option>
          </select>
          <input name="price" value="<?= $product['price'] ?>" type="number" class="px-3 py-2 border rounded-lg">
      </div>
      <!-- Sizes -->
      <div class="w-full">
          <p class="mb-2 font-medium text-gray-700"><i class="fa-solid fa-ruler"></i> Kích Thước & Số Lượng</p>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
              <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
                  <div class="flex flex-col items-start border rounded-lg p-3 shadow-sm">
                      <label class="font-medium text-gray-700 mb-1"><?= $size ?></label>
                      <input type="number" name="sizes[<?= $size ?>]" value="<?= $productSizes[$size] ?? 0 ?>" min="0"
                          class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-400"
                          placeholder="Số lượng <?= $size ?>">
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
      <!-- Submit -->
      <button type="submit"
          class="w-32 py-3 mt-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
          💾 Cập nhật
      </button>
  </form>