<h2 class="text-xl font-bold mb-4">Thêm sản phẩm mới</h2>

<form action="index.php?controllers=admin&action=add" method="POST" enctype="multipart/form-data"
    class="flex flex-col w-full items-start gap-3">

    <div>
        <p class="mb-2">Upload Images</p>
        <input type="file" name="images[]" multiple class="block mb-2 border p-2">
        <small>Chọn tối đa 4 ảnh</small>
    </div>

    <div class="w-full">
        <p class="mb-2">Product name</p>
        <input name="name" class="w-full max-w-[500px] py-3 px-2 border" type="text" required>
    </div>

    <div class="w-full">
        <p class="mb-2">Product description</p>
        <textarea name="description" class="w-full max-w-[500px] py-3 px-2 border" required></textarea>
    </div>

    <div class="flex flex-col sm:flex-row gap-2 w-full sm:gap-8">
        <div>
            <p class="mb-2">Category</p>
            <select name="category" class="w-full px-3 py-2 border">
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Kid">Kid</option>
            </select>
        </div>

        <div>
            <p class="mb-2">Sub category</p>
            <select name="subCategory" class="w-full px-3 py-2 border">
                <option value="Topwear">Topwear</option>
                <option value="Bottomwear">Bottomwear</option>
                <option value="Winterwear">Winterwear</option>
            </select>
        </div>

        <div>
            <p class="mb-2">Price</p>
            <input name="price" class="w-full px-3 py-2 border sm:w-[120px]" type="number" required>
        </div>
    </div>

    <div>
        <p>Sizes</p>
        <div class="flex gap-3">
            <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
            <label class="cursor-pointer">
                <input type="checkbox" name="sizes[]" value="<?= $size ?>" class="hidden peer">
                <p class="peer-checked:bg-pink-100 bg-slate-200 px-3 py-1"><?= $size ?></p>
            </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex gap-2 mt-2 items-center">
        <input type="checkbox" name="bestseller" id="bestseller">
        <label for="bestseller">Add to bestseller</label>
    </div>

    <button type="submit" class="w-28 py-3 mt-4 bg-black text-white">ADD</button>
</form>