<?php include __DIR__ . '/../layouts/title.php'; ?>

<div class="container max-w-5xl mx-auto px-4 py-10 text-gray-700">

    <!-- Tiêu đề -->
    <div class="text-3xl font-bold text-center mb-12">
        <?= Title("CHI TIẾT", "ĐƠN HÀNG") ?>
    </div>

    <!-- Thông tin đơn hàng -->
    <div class="bg-white shadow rounded-lg p-6 mb-10 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            📦 <span>Thông tin đơn hàng #<?= htmlspecialchars($order['id']) ?></span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 text-sm sm:text-base">
            <p><b>Họ tên:</b> <?= htmlspecialchars($order['firstName'] . ' ' . $order['lastName']) ?></p>
            <p><b>Số điện thoại:</b> <?= htmlspecialchars($order['phone']) ?></p>
            <p><b>Địa chỉ:</b>
                <?= htmlspecialchars($order['street'] . ', ' . $order['city'] . ', ' . $order['country']) ?></p>

            <!-- Trạng thái màu động -->
            <?php
            $status = htmlspecialchars($order['status']);
            $statusColor = match ($status) {
                'Đã giao' => 'text-green-600 bg-green-100',
                'Đang xử lý' => 'text-yellow-600 bg-yellow-100',
                'Yêu cầu hủy' => 'text-red-600 bg-red-100',
                default => 'text-gray-600 bg-gray-100'
            };
            ?>
            <p><b>Trạng thái:</b>
                <span class="px-2 py-1 rounded-md <?= $statusColor ?>"><?= $status ?></span>
            </p>

            <p><b>Phương thức thanh toán:</b> <?= htmlspecialchars($order['paymentMethod']) ?></p>
            <p><b>Ngày đặt hàng:</b> <?= date('d/m/Y', strtotime($order['date'])) ?></p>
            <p><b>Tổng sản phẩm:</b> <?= htmlspecialchars($order['quantity']) ?></p>
            <p><b>Tổng tiền:</b>
                <span class="font-semibold text-green-600">
                    <?= number_format($order['amount'], 0, ',', '.') ?> VND
                </span>
            </p>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">🛒 <span>Sản phẩm trong đơn hàng</span></h2>

        <?php if (!empty($items)): ?>
        <div class="divide-y">
            <?php foreach ($items as $item): ?>
            <?php
                    $images = json_decode($item['image'], true);
                    $first_image = $images[0] ?? '';
                    ?>
            <div class="py-5 grid grid-cols-1 md:grid-cols-[3fr_1fr_1fr_1fr_auto] items-center gap-4 md:gap-6">
                <!-- Thông tin sản phẩm -->
                <div class="flex items-start gap-4 sm:gap-6">
                    <?php if ($first_image): ?>
                    <a href="index.php?controllers=product&action=detail&id=<?= $item['product_id'] ?>">
                        <img class="w-20 h-20 object-cover border rounded-md"
                            src="<?= htmlspecialchars($first_image) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    </a>
                    <?php endif; ?>

                    <div>
                        <a href="index.php?controllers=product&action=detail&id=<?= $item['product_id'] ?>" class="
                            font-medium text-gray-800 leading-snug">
                            <?= htmlspecialchars($item['name']) ?>
                        </a>
                        <p class="text-sm text-gray-500">Size: <?= htmlspecialchars($item['size']) ?></p>

                        <!-- Mobile hiển thị thêm -->
                        <div class="mt-1 space-y-1 md:hidden text-sm">
                            <p>Giá: <?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                            <p>Số lượng: <?= htmlspecialchars($item['quantity']) ?></p>
                            <p class="font-semibold text-green-700">
                                Tổng: <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Desktop: Giá -->
                <div class="hidden md:block text-center text-gray-700">
                    <?= number_format($item['price'], 0, ',', '.') ?> VND
                </div>

                <!-- Desktop: SL -->
                <div class="hidden md:block text-center">
                    <?= htmlspecialchars($item['quantity']) ?>
                </div>

                <!-- Desktop: Tổng -->
                <div class="hidden md:block text-right font-semibold text-green-700">
                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                </div>

                <!-- Nút đánh giá -->
                <?php if ($order['status'] === 'Đã giao'): ?>
                <div class="text-center md:text-right">
                    <a href="index.php?controllers=rating&action=index&id=<?= $item['product_id'] ?>">
                        <button
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-100 transition">
                            Đánh giá
                        </button>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tổng cộng -->
        <div class="text-right mt-8 text-lg font-semibold">
            Tổng cộng:
            <span class="text-orange-600">
                <?= number_format($order['amount'], 0, ',', '.') ?> VND
            </span>
        </div>

        <?php else: ?>
        <p class="text-gray-500 italic">Không có sản phẩm nào trong đơn hàng này.</p>
        <?php endif; ?>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-10 text-center">
        <a href="index.php?controllers=order&action=index"
            class="inline-block bg-black text-white px-8 py-3 rounded-md hover:bg-gray-800 transition">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>
</div>