<aside class="w-[18%] min-h-screen border-r-2">
    <nav class="flex flex-col gap-4 pt-6 pl-[20%] text-[15px]">
        <a data-url="index.php?controllers=admin&action=add"
            class="nav-link flex items-center gap-3 px-3 py-2 rounded-l hover:bg-gray-100">
            <img class="w-5 h-5" src="<?= $assets['add_icon'] ?>" alt="">
            <p class="cursor-pointer hidden md:block">Add Items</p>
        </a>

        <a data-url="index.php?controllers=admin&action=list"
            class="nav-link flex items-center gap-3 px-3 py-2 rounded-l hover:bg-gray-100">
            <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
            <p class="cursor-pointer hidden md:block">List Items</p>
        </a>

        <a data-url="index.php?controllers=admin&action=orders"
            class="nav-link flex items-center gap-3 px-3 py-2 rounded-l hover:bg-gray-100">
            <img class="w-5 h-5" src="<?= $assets['order_icon'] ?>" alt="">
            <p class="cursor-pointer hidden md:block">Orders</p>
        </a>
    </nav>
</aside>