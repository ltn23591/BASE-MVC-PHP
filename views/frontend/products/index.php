<?php require_once __DIR__ . '/../components/ProductItem.php'; ?>

<!-- THANH TÌM KIẾM -->
<div class="container">
    <div class="border-t border-b bg-gray-50 text-center">
        <div
            class="inline-flex items-center justify-center border border-gray-400 px-5 py-2 my-5 mx-3 rounded-full w-3/4 sm:w-1/2">
            <input id="searchInput" class="flex-1 border-none outline-none bg-inherit text-sm" type="text"
                placeholder="Tìm sản phẩm..." />
            <img src="public/assets/img/frontend_assets/search_icon.png" class="w-4 ml-2" alt="search">
        </div>
    </div>

    <form id="filterForm" class="flex flex-col sm:flex-row gap-1 sm:gap-10 pt-10 border-t">
        <div class="min-w-60">
            <p class="my-2 text-xl flex items-center cursor-pointer gap-2">BỘ LỌC</p>

            <!-- Category Filter -->
            <div class="border border-gray-300 pl-5 py-3 mt-6 sm:block">
                <p class="mb-3 text-sm font-medium">DANH MỤC</p>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="category[]" value="Nam"> Nam
                </label>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="category[]" value="Nữ"> Nữ
                </label>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="category[]" value="Trẻ Em"> Trẻ em
                </label>
            </div>

            <!-- SubCategory Filter -->
            <div class="border border-gray-300 pl-5 py-3 mt-6 sm:block">
                <p class="mb-3 text-sm font-medium">LOẠI</p>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="subCategory[]" value="Áo"> Áo
                </label>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="subCategory[]" value="Quần"> Quần
                </label>
                <label class="flex gap-2">
                    <input type="checkbox" class="w-3" name="subCategory[]" value="Đồ mùa đông"> Đồ mùa đông
                </label>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="flex-1">
            <div class="flex justify-between text-base sm:text-2xl mb-4">
                <h2 class="font-bold text-xl">TẤT CẢ <span class="text-gray-600">SẢN PHẨM</span></h2>
                <select name="sort" class="border-2 border-gray-300 text-sm pl-2 pr-8 cursor-pointer">
                    <option value="relavent">Sắp xếp: Mặc định</option>
                    <option value="low-high">Giá tăng dần</option>
                    <option value="high-low">Giá giảm dần</option>
                </select>
            </div>
            <!-- Danh sách sản phẩm -->
            <div id="post_list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 gap-y-6 mt-6">
                <?php foreach ($products as $item): ?>
                    <div class="text-center border p-2 product-item"
                        data-category="<?= htmlspecialchars($item['category']) ?>"
                        data-subcategory="<?= htmlspecialchars($item['subCategory']) ?>"
                        data-price="<?= htmlspecialchars($item['price']) ?>"
                        data-name="<?= htmlspecialchars($item['name']) ?>">
                        <?php ProductItem($item['id'], $item['image'], $item['name'], $item['price']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Phân trang -->
            <div class="flex justify-center mt-8 mb-10">
                <div class="flex justify-center mt-8 mb-10 pagination"></div>
            </div>
        </div>
    </form>
</div>

<script src="public/assets/js/product_filter.js"></script>