<div class="flex flex-col sm:flex-row justify-between gap-4 pt-5 sm:pt-14 min-h-[80vh] border-t">
    <form method="POST" class="flex flex-col sm:flex-row justify-between gap-4 w-full">
        <div class="flex flex-col gap-4 w-full sm:max-w-[480px]">
            <div class="text-xl sm:text-2xl my-3">
                <p class="font-bold">DELIVERY <span class="text-orange-500">INFORMATION</span></p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="p-3 bg-red-50 text-red-600 border border-red-200 rounded">
                    <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
                </div>
            <?php endif; ?>

            <div class="flex gap-3">
                <input required name="firstName" value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="First Name" />
                <input required name="lastName" value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Last Name" />
            </div>

            <input required name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="email" placeholder="Email" />

            <input required name="street" value="<?= htmlspecialchars($_POST['street'] ?? '') ?>"
                class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Street Address" />

            <div class="flex gap-3">
                <input required name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="City" />
                <input required name="country" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>"
                    class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Country" />
            </div>

            <input required name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                class="border border-gray-300 rounded py-1.5 px-3.5 w-full" type="text" placeholder="Phone Number" />
        </div>

        <div class="mt-8">
            <div class="mt-8 min-w-80">
                <div class="border p-4 rounded">
                    <div class="flex justify-between py-1">
                        <span>Subtotal</span>
                        <span><?= number_format($subtotal ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Delivery Fee</span>
                        <span><?= number_format($delivery_fee ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                    <hr />
                    <div class="flex justify-between py-2 font-semibold">
                        <span>Total</span>
                        <span><?= number_format($amount ?? 0, 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>

            <div class="mt-12">
                <p class="text-xl font-semibold mb-3">PAYMENT <span class="text-orange-500">METHOD</span></p>

                <div class="flex gap-3 flex-col lg:flex-row">
                    <label class="flex items-center gap-3 border p-2 px-3 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="momo" />
                        <span class="text-gray-600 text-sm">Momo</span>
                    </label>
                    <label class="flex items-center gap-3 border p-2 px-3 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="cod" checked />
                        <span class="text-gray-600 text-sm">Cash on Delivery</span>
                    </label>
                </div>
                <div class=" w-full text-end mt-8">
                    <button type="submit" class="bg-black text-white px-16 py-3">PLACE ORDER</button>
                </div>

            </div>
        </div>
    </form>
</div>