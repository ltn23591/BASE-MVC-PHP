<div id="loadTotalCart" class=" max-w-5xl mx-auto">
    <!-- Tiêu đề -->
    <div class="text-2xl mb-6 font-bold">
        <span class="text-gray-800">GIỎ HÀNG </span><span class="text-black">CỦA BẠN</span>
    </div>

    <!-- Danh sách sản phẩm -->
    <div>
        <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $item): ?>

        <div class="py-4 border-t border-b text-gray-700 grid grid-cols-[4fr_0.5fr_0.5fr] 
                            sm:grid-cols-[4fr_2fr_0.5fr] items-center gap-4">
            <!-- Thông tin sản phẩm -->
            <div class="flex items-start gap-6">
                <img class="w-16 sm:w-20" src="<?= BASE_URL . $item['image'] ?>"
                    alt="<?= htmlspecialchars($item['name']) ?>">
                <div>
                    <p class="text-xs sm:text-lg font-medium"><?= htmlspecialchars($item['name']) ?></p>
                    <div class="flex items-center gap-5 mt-2">
                        <p><?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                        <p class="px-2 sm:px-3 sm:py-1 border bg-slate-50"><?= htmlspecialchars($item['size']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Input số lượng -->
            <input class="border max-w-10 sm:max-w-20 px-1 sm:px-2 py-1 text-center" type="number" min="0"
                value="<?= $item['quantity'] ?>"
                onchange="updateQuantity(<?= $item['id'] ?>, '<?= $item['size'] ?>', this.value)">

            <!-- Xóa sản phẩm -->
            <p onclick="removeFromCart(<?= $item['id'] ?>, '<?= $item['size'] ?>', 0)" class="w-4 mr-4 cursor-pointer">X
            </p>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-gray-500">Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>
    </div>

    <!-- Tổng giỏ hàng -->
    <div class="flex justify-end my-20">
        <div class="w-full sm:w-[450px] bg-white p-6 rounded shadow">
            <p class="text-lg m-5">Tổng số lượng: <b><?= $totalQuantity ?></b></p>

            <p class="text-lg m-5">Tổng tiền: <b><?= number_format($totalPrice, 0, ',', '.') ?> VND</b></p>
            <div class="w-full text-end">
                <a href="index.php?controllers=checkout&action=index" class="bg-black text-white px-16 py-3"
                    type=" button">
                    ĐẶT HÀNG
                </a>
            </div>
        </div>
    </div>

</div>