<!-- Tổng giỏ hàng -->

<div class="w-full sm:w-[450px] bg-white p-6 rounded shadow">
    <p class="text-lg">Tổng số lượng: <b><?= $totalQuantity ?></b></p>
    <p class="text-lg">Tổng tiền: <b>$<?= number_format($totalPrice, 2) ?></b></p>
    <div class="w-full text-end">
        <a href="index.php?controller=Order&action=placeOrder" class="bg-black text-white my-8 px-8 py-3 inline-block">
            ĐẶT HÀNG
        </a>
    </div>
</div>