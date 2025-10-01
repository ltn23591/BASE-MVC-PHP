<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="mb-2 flex items-center justify-between py-5 font-medium">
    <!-- Logo -->
    <?php include __DIR__ . '/logo.php'; ?>

    <!-- Navbar -->
    <ul class="hidden sm:flex gap-5 text-sm text-gray-700">
        <li><a href="index.php" class="hover:text-gray-900 transition">TRANG CHỦ</a></li>
        <li><a href="index.php?controllers=product" class="hover:text-gray-900 transition">SẢN
                PHẨM</a></li>
        <li><a href="index.php?controllers=aboutus" class="hover:text-gray-900 transition">VỀ CHÚNG TÔI</a></li>
        <li><a href="index.php?controllers=contactus" class="hover:text-gray-900 transition">LIÊN HỆ</a></li>
    </ul>

    <!-- Icons -->
    <div class="flex items-center gap-5">
        <!-- Search -->
        <img src="<?= $assets['search_icon'] ?>" alt="search" class="w-5 cursor-pointer" onclick="toggleSearch()">

        <!-- Profile -->
        <div class="group relative">
            <img src="<?= $assets['profile_icon'] ?>" alt="profile" class="w-5 cursor-pointer">

            <?php if (!empty($_SESSION['user_id'])): ?>
            <!-- Nếu đã đăng nhập -->
            <div class="z-50 group-hover:block hidden absolute right-0 bg-white shadow-lg rounded-lg pt-4">
                <div class="flex flex-col gap-2 w-36 py-3 px-5">
                    <p class="cursor-pointer hover:text-black">Xin chào, <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </p>
                    <p onclick="window.location.href='index.php?controllers=order&action=index'"
                        class="cursor-pointer hover:text-black">Orders</p>
                    <p onclick="window.location.href='index.php?controllers=auth&action=logout'"
                        class="cursor-pointer hover:text-black">Đăng xuất</p>
                </div>
            </div>
            <?php else: ?>
            <!-- Nếu chưa đăng nhập -->
            <div class="z-50 group-hover:block hidden absolute right-0 bg-white shadow-lg rounded-lg pt-4">
                <div class="flex flex-col gap-2 w-36 py-3 px-5">
                    <p onclick="window.location.href='index.php?controllers=auth&action=login'"
                        class="cursor-pointer hover:text-black">
                        Đăng nhập
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Cart -->
        <?php include __DIR__ . '/cart.php'; ?>

        <!-- Menu icon (mobile) -->
        <img onclick="toggleMenu(true)" src="<?= $assets['menu_icon'] ?>" alt="menu"
            class="w-5 cursor-pointer sm:hidden">
    </div>

    <!-- Sidebar menu for small screen -->
    <div id="sidebar" class="absolute top-0 right-0 bottom-0 overflow-hidden bg-white transition-all w-0">
        <div class="flex flex-col text-gray-600">
            <div onclick="toggleMenu(false)" class="flex items-center gap-4 p-3 cursor-pointer">
                <img class="h-4 rotate-180" src="<?= $assets['dropdown_icon'] ?>" alt="">
                <p>Back</p>
            </div>
            <a href="index.php" class="py-2 pl-6 border">TRANG CHỦ</a>
            <a href="views/frontend/aboutus/index.php" class="py-2 pl-6 border">VỀ CHÚNG TÔI</a>
            <a href="index.php?controllers=contactus" class="py-2 pl-6 border">LIÊN HỆ</a>
            <a href="collection.php" class="py-2 pl-6 border">SẢN PHẨM</a>
        </div>
    </div>
</div>

<script>
function toggleMenu(show) {
    console.log("ok");
    const sidebar = document.getElementById("sidebar");
    sidebar.style.width = show ? "100%" : "0";
}

function toggleSearch() {
    // Gọi PHP để bật search bar
    fetch("toggleSearch.php?action=show")
        .then(() => location.reload());
}
</script>