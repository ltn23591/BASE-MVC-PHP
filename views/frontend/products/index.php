<?php require_once __DIR__ . '/../components/ProductItem.php'; ?>

<form id="filterForm" class="flex flex-col sm:flex-row gap-1 sm:gap-10 pt-10 border-t">
    <div class="min-w-60">
        <p class="my-2 text-xl flex items-center cursor-pointer gap-2">BỘ LỌC</p>

        <!-- Category Filter -->
        <div class="border border-gray-300 pl-5 py-3 mt-6 sm:block">
            <p class="mb-3 text-sm font-medium">DANH MỤC</p>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="category[]" value="Men"> Nam
            </label>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="category[]" value="Women"> Nữ
            </label>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="category[]" value="Kids"> Trẻ em
            </label>
        </div>

        <!-- SubCategory Filter -->
        <div class="border border-gray-300 pl-5 py-3 mt-6 sm:block">
            <p class="mb-3 text-sm font-medium">LOẠI</p>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="subCategory[]" value="Topwear"> Áo
            </label>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="subCategory[]" value="Bottomwear"> Quần
            </label>
            <label class="flex gap-2">
                <input type="checkbox" class="w-3" name="subCategory[]" value="Winterwear"> Đồ mùa đông
            </label>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="flex-1">
        <div class="flex justify-between text-base sm:text-2xl mb-4">
            <h2 class="font-bold text-xl">TẤT CẢ <span class="text-gray-600">SẢN PHẨM</span></h2>
            <select name="sort" class="border-2 border-gray-300 text-sm px-2 cursor-pointer">
                <option value="relavent">Sắp xếp: Mặc định</option>
                <option value="low-high">Giá tăng dần</option>
                <option value="high-low">Giá giảm dần</option>
            </select>
        </div>

        <div id="post_list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 gap-y-6">
            <?php foreach ($products as $item): ?>
                <div class="text-center border p-2 product-item" data-category="<?= htmlspecialchars($item['category']) ?>"
                    data-subcategory="<?= htmlspecialchars($item['subCategory']) ?>"
                    data-price="<?= htmlspecialchars($item['price']) ?>">
                    <?php ProductItem($item['id'], $item['image'], $item['name'], $item['price']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</form>

<script>
    function filterProducts() {
        const selectedCategories = [...document.querySelectorAll('input[name="category[]"]:checked')].map(el => el.value);
        const selectedSubCategories = [...document.querySelectorAll('input[name="subCategory[]"]:checked')].map(el => el
            .value);
        const sortType = document.querySelector('select[name="sort"]').value;

        const products = [...document.querySelectorAll('.product-item')];

        // Ẩn/hiện sản phẩm
        products.forEach(p => {
            const cat = p.dataset.category;
            const sub = p.dataset.subcategory;

            const matchCat = selectedCategories.length === 0 || selectedCategories.includes(cat);
            const matchSub = selectedSubCategories.length === 0 || selectedSubCategories.includes(sub);

            if (matchCat && matchSub) {
                p.classList.remove('hidden');
            } else {
                p.classList.add('hidden');
            }
        });

        // Sắp xếp nếu cần
        if (sortType !== 'relavent') {
            const sorted = products
                .filter(p => !p.classList.contains('hidden'))
                .sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price);
                    const priceB = parseFloat(b.dataset.price);
                    return sortType === 'low-high' ? priceA - priceB : priceB - priceA;
                });

            const list = document.getElementById('post_list');
            sorted.forEach(item => list.appendChild(item));
        }
    }

    // Gán sự kiện
    document.querySelectorAll('input[name="category[]"], input[name="subCategory[]"], select[name="sort"]').forEach(el => {
        el.addEventListener('change', filterProducts);
    });
</script>