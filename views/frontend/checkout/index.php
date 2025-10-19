<!-- <?php
        echo '<pre>';
        print_r($cart);
        ?> -->

<!-- Toastify CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<div class="flex flex-col sm:flex-row justify-between gap-4 pt-5 sm:pt-14 min-h-[80vh] border-t">
    <form method="POST" class="flex flex-col sm:flex-row justify-between gap-4 w-full" id="checkoutForm">

        <div class="flex flex-col gap-4 w-full sm:max-w-[480px]">
            <div class="text-xl sm:text-2xl my-3">
                <p class="font-bold">THÔNG TIN <span class="text-orange-500">ĐẶT HÀNG</span></p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="p-3 bg-red-50 text-red-600 border border-red-200 rounded">
                    <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
                </div>
            <?php endif; ?>

            <div class="flex gap-3">
                <input required name="firstName" value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Tên" />
                <input required name="lastName" value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Họ" />
            </div>

            <input required name="street" value="<?= htmlspecialchars($_POST['street'] ?? '') ?>"
                class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Địa Chỉ" />

            <div class="flex gap-3">
                <input required name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Thành Phố" />
                <input required name="country" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Quốc Gia" />
            </div>

            <input required name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Số điện thoại" />
        </div>

        <div class="mt-8">
            <div class="mt-8 min-w-80">
                <div class="border p-4 rounded">
                    <div class="flex justify-between py-1">
                        <span>Tổng Trị Giá</span>
                        <span><?= number_format($subtotal ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Phí Vận Chuyển</span>
                        <span><?= number_format($delivery_fee ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="flex justify-between py-1 text-green-600">
                        <span>Giảm giá</span>
                        <span id="discount_value">- <?= number_format($discount ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                    <hr class="my-2" />
                    <div class="flex justify-between py-2 font-semibold">
                        <span>Tổng Cộng</span>
                        <span id="total_value"><?= number_format($amount ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <label for="voucher_code" class="font-semibold">Bạn có mã giảm giá?</label>
                <div class="flex mt-2 gap-2">
                    <input type="text" id="voucher_code" name="voucher_code" placeholder="Nhập mã voucher tại đây"
                        class="border p-2 w-full rounded-md focus:ring-orange-500 focus:border-orange-500">
                    <button type="button" id="apply_voucher"
                        class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 whitespace-nowrap">
                        Áp dụng
                    </button>
                </div>
            </div>

            <div class="w-full text-end mt-8">
                <button type="submit" class="bg-black text-white px-16 py-3">Đặt Hàng</button>
            </div>
        </div>
    </form>
</div>

<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="public/assets/js/apply_voucher.js"></script>

<script>
    function isVietnamesePhoneNumber(number) {
        return /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(number);
    }


    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const phoneInput = document.querySelector('input[name="phone"]');
        const phone = phoneInput.value.trim();

        if (!isVietnamesePhoneNumber(phone)) {
            e.preventDefault();
            Toastify({
                text: "Số điện thoại không hợp lệ! Vui lòng nhập đúng định dạng.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }
            }).showToast();
            phoneInput.focus();
            phoneInput.style.borderColor = "red";
            return false;
        }
    });
</script>