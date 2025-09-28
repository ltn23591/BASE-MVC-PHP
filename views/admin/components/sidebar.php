<aside class="w-[18%] min-h-screen border-r bg-white shadow-sm">
    <nav class="flex flex-col gap-2 pt-6 px-4 text-[15px] font-medium text-gray-700">

        <!-- Add Items -->
        <a data-url="index.php?controllers=admin&action=add"
            class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
            <img class="w-5 h-5" src="<?= $assets['add_icon'] ?>" alt="">
            <span class="hidden md:block">Thêm sản phẩm mới</span>
        </a>

        <!-- List Items -->
        <a data-url="index.php?controllers=admin&action=list"
            class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
            <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
            <span class="hidden md:block">Danh sách sản phẩm</span>
        </a>

        <!-- Orders -->
        <a data-url="index.php?controllers=admin&action=orders"
            class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
            <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
            <span class="hidden md:block">Đơn hàng</span>
        </a>
    </nav>
</aside>