<aside class="min-w-[30%] min-h-screen border-r bg-white shadow-sm">
    <nav class="flex flex-col pt-6 px-4 text-[15px] font-medium text-gray-700">


        <!-- Quản lý sản phẩm -->
        <div class="cursor-pointer flex items-center justify-between whitespace-nowrap gap-2 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
            data-toggle="productMenu">
            <div class="flex items-center gap-3">
                <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
                <span class="hidden md:block">Quản lý sản phẩm</span>
            </div>
            <svg class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>


        <!-- Submenu sản phẩm -->
        <div id="productMenu" class="hidden flex-col gap-2 ml-6 mt-2">
            <a data-url="index.php?controllers=admin&action=add"
                class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['add_icon'] ?>" alt="">
                <span class="hidden md:block">Thêm sản phẩm</span>
            </a>

            <!-- List Items -->
            <a data-url="index.php?controllers=admin&action=list"
                class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
                <span class="hidden md:block">Danh sách sản phẩm</span>
            </a>
        </div>

        <!-- Quản lý user -->
        <div class="cursor-pointer flex items-center justify-between px-3 py-2 mt-4 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
            data-toggle="userMenu">
            <div class="flex items-center gap-3">
                <img class="w-5 h-5" src="<?= $assets['user_icon'] ?>" alt="">
                <span class="hidden md:block">Quản lý Người Dùng</span>
            </div>
            <svg class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <!-- Submenu user -->
        <div id="userMenu" class="hidden flex-col gap-2 ml-6 mt-2">
            <a data-url="index.php?controllers=admin&action=adduser"
            class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['add_user'] ?>" alt="">
                <span class="hidden md:block">Thêm Người Dùng</span>
            </a>
            <a data-url="index.php?controllers=admin&action=users"
            class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['user_list'] ?>" alt="">
                <span class="hidden md:block">Danh sách Người Dùng</span>
            </a>
        </div>


        <!-- Quản lý đơn hàng -->
        <div class="cursor-pointer flex items-center justify-between px-3 py-2 mt-4 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
            data-toggle="orderMenu">
            <div class="flex items-center gap-3">
                <img class="w-5 h-5" src="<?= $assets['parcel_icon'] ?>" alt="">
                <span class="hidden md:block">Quản lý đơn hàng</span>
            </div>
            <svg class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <!-- Submenu đơn hàng -->
        <div id="orderMenu" class="hidden flex-col gap-2 ml-6 mt-2">
            <a data-url="index.php?controllers=admin&action=orders"
                class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
                <span class="hidden md:block text-nowrap">Danh sách đơn hàng</span>
            </a>
        </div>


        <!-- Quản lý khuyến mãi -->
        <div class="cursor-pointer flex items-center justify-between px-3 py-2 mt-4 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
            data-toggle="promoMenu">
            <div class="flex items-center gap-3">
                <img class="w-5 h-5" src="<?= $assets['promo_icon'] ?>" alt="">
                <span class="hidden md:block">Quản lý khuyến mãi</span>
            </div>
            <svg class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <!-- Submenu khuyến mãi -->
        <div id="promoMenu" class="hidden flex-col gap-2 ml-6 mt-2">
            <a data-url="index.php?controllers=admin&action=addVoucher"
                class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['add_icon'] ?>" alt="">
                <span class="hidden md:block">Thêm khuyến mãi</span>
            </a>

            <a data-url="index.php?controllers=admin&action=listVoucher"
                class="cursor-pointer nav-link flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
                <span class="hidden md:block">Danh sách khuyến mãi</span>
            </a>
        </div>


    </nav>
</aside>

<!-- Gọi file JS -->
<script src="public/assets/js/sidebar.js"></script>