<?php
if (!isset($orders)) {
    $orders = [];
}
?>
<div class="border-t pt-16">
    <div class="text-2xl mb-4">
        <p class="font-bold">MY <span class="text-orange-500">ORDERS</span></p>
    </div>

    <div>
        <?php foreach ($orders as $order): ?>
            <div class="py-4 border-t text-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-sm">
                    <p class="sm:text-base font-medium">Order #<?= htmlspecialchars($order['id']) ?></p>
                    <div class="flex items-center gap-3 mt-1 text-base text-gray-700">
                        <p>Tổng tiền: <?= (int)$order['amount'] ?> $</p>

                    </div>
                    <p class="mt-1">
                        Date:
                        <span class="text-gray-400"><?= htmlspecialchars($order['date']) ?></span>
                    </p>
                    <p class="mt-1">
                        Payment:
                        <span class="text-gray-400"><?= htmlspecialchars($order['paymentMethod']) ?></span>
                    </p>
                </div>
                <div class="md:w-1/2 flex justify-between">
                    <div class="flex items-center gap-2">
                        <p class="min-w-2 h-2 rounded-full bg-green-500"></p>
                        <p class="text-sm md:text-base"><?= htmlspecialchars($order['status']) ?></p>
                    </div>
                    <form method="GET" action="index.php">
                        <input type="hidden" name="controllers" value="orders" />
                        <input type="hidden" name="action" value="index" />
                        <button class="border px-4 py-2 text-sm font-medium rounded-sm">
                            Track Order
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>