<a href="index.php?controllers=cart&action=listCart" class="relative">
    <img src="<?= $assets['cart_icon'] ?>" class="w-5 min-w-5">
    <p id="totalProducts"
        class="absolute right-[-5px] bottom-[-5px] w-4 text-center leading-4 bg-black text-white aspect-square rounded-full text-[8px]">
        <?= !empty($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
    </p>
</a>