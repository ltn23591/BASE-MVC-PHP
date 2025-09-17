<?php
// Lấy từ khóa từ URL nếu có
$search = $_GET['search'] ?? '';

// Kiểm tra có đang ở trang collection không
$isCollectionPage = strpos($_SERVER['REQUEST_URI'], 'collection') !== false;
?>

<?php if ($isCollectionPage): ?>
    <div class="border-t border-b bg-gray-50 text-center">
        <form method="GET" action="index.php" class="inline-flex items-center justify-center 
            border border-gray-400 px-5 py-2 my-5 mx-3 rounded-full w-3/4 sm:w-1/2">

            <!-- bắt buộc nếu bạn dùng router MVC -->
            <input type="hidden" name="controllers" value="products">

            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search"
                class="flex-1 outline-none bg-inherit text-sm">
            <button type="submit">
                <img src="<?= $assets['search_icon'] ?>" class="w-4" alt="search">
            </button>
        </form>

        <!-- Nút đóng thanh tìm kiếm -->
        <img src="<?= $assets['cross_icon'] ?>" class="inline w-3 cursor-pointer" alt="close"
            onclick="document.querySelector('form').style.display='none'">
    </div>
<?php endif; ?>