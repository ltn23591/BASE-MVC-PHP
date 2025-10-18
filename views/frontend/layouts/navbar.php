<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="sticky top-0 z-50 bg-white mb-2 flex items-center justify-between py-5 font-medium">
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
        <img src="<?= $assets['search_icon'] ?>" alt="search" class="w-5 cursor-pointer"
            onclick="window.location.href='index.php?controllers=product&searchFocus=1';" />
        <!-- Cart -->
        <?php include __DIR__ . '/cart.php'; ?>

        <!-- Profile -->
        <div class="group relative">
            <?php if (!isset($_SESSION['user_id'])): ?>
            <img src="<?= $assets['profile_icon'] ?>" alt="profile" class="w-5 cursor-pointer">
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?controllers=profile" class="flex gap-2 items-center ml-5">

                <img src="https://ui-avatars.com/api/?name=<?= htmlspecialchars($_SESSION['user_name']) ?>" alt="Avatar"
                    class="w-8 h-8 rounded-full mx-auto border-4 object-cover" />
                <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>

            </a>
            <?php endif; ?>
            <?php if (!empty($_SESSION['user_id'])): ?>
            <!-- Nếu đã đăng nhập -->
            <div class="z-50 group-hover:block hidden absolute right-0 bg-white shadow-lg rounded-lg pt-4">
                <div class="flex flex-col gap-2 w-36 py-3 px-5">
<<<<<<< Updated upstream
                    <p onclick="window.location.href='index.php?controllers=profile&action=index'" 
                    class="cursor-pointer hover:text-black">Xin chào, <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </p>
=======
                    <a href="index.php?controllers=profile" class="cursor-pointer hover:text-black">Xin chào,
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </a>
>>>>>>> Stashed changes
                    <p onclick="window.location.href='index.php?controllers=order&action=index'"
                        class="cursor-pointer hover:text-black">Đơn Hàng</p>
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





        <!-- Menu icon (mobile) -->
        <img onclick=" toggleMenu(true)" src="<?= $assets['menu_icon'] ?>" alt="menu"
            class="w-5 cursor-pointer sm:hidden">
    </div>

    <!-- Sidebar menu for small screen -->
    <div id="sidebar"
        class="fixed top-0 right-[-100%] bottom-0 z-50 w-full max-w-xs bg-white shadow-xl transition-all duration-300 ease-in-out">
        <div class="p-4">
            <!-- Sidebar Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <h2 class="font-bold text-lg">MENU</h2>
                <button onclick="toggleMenu(false)" class="p-2">
                    <img class="h-5 w-5" src="<?= $assets['cross_icon'] ?>" alt="Close">
                </button>
            </div>

            <!-- Sidebar Links -->
            <nav class="mt-6 flex flex-col gap-1 text-gray-700">
                <a href="index.php" class="block py-3 px-4 rounded-md hover:bg-gray-100 transition">TRANG CHỦ</a>
                <a href="index.php?controllers=product"
                    class="block py-3 px-4 rounded-md hover:bg-gray-100 transition">SẢN PHẨM</a>
                <a href="index.php?controllers=aboutus"
                    class="block py-3 px-4 rounded-md hover:bg-gray-100 transition">VỀ CHÚNG TÔI</a>
                <a href="index.php?controllers=contactus"
                    class="block py-3 px-4 rounded-md hover:bg-gray-100 transition">LIÊN HỆ</a>
            </nav>
        </div>
    </div>
</div>

<script>
function toggleMenu(show) {
    console.log("ok");
    const sidebar = document.getElementById('sidebar');
    if (show) {
        sidebar.style.right = '0';
    } else {
        sidebar.style.right = '-100%';
    }
}

function toggleSearch() {
    // Gọi PHP để bật search bar
    fetch("toggleSearch.php?action=show")
        .then(() => location.reload());
}

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("searchFocus") === "1") {
        const searchInput = document.getElementById("searchInput");
        if (searchInput) {
            searchInput.focus();
        }
    }
});
</script>