<?php
// Hiển thị dữ liệu người dùng (nếu có)
if (isset($getInfor) && is_array($getInfor)) {
    $name = htmlspecialchars($getInfor['name'] ?? '');
    $email = htmlspecialchars($getInfor['email'] ?? '');
    $password = htmlspecialchars($getInfor['password'] ?? '');
    $createdAt = $getInfor['created_at'] ?? null;
} else {
    $name = $email = $password = '';
    $createdAt = null;
}
?>

<div class="flex bg-gray-50 min-h-screen font-sans">
    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-md border-r p-6">
        <div class="text-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($name ?: 'Người dùng') ?>" alt="Avatar"
                class="w-24 h-24 rounded-full mx-auto border-4 border-green-500 object-cover" />
            <h2 class="mt-3 text-lg font-semibold"><?= $name ?: 'Người dùng mới' ?></h2>
            <p class="text-gray-500 text-sm">
                Đăng ký: <?= $createdAt ? date('d/m/Y', strtotime($createdAt)) : 'Không rõ' ?>
            </p>
        </div>

        <nav class="mt-8 space-y-2 text-gray-700">
            <a href="#" class="block py-1 hover:text-yellow-500 font-medium">Thông tin cá nhân</a>
            <a href="index.php?controllers=order&action=index"
                class="mt-5 text-sm font-semibold text-gray-400 uppercase">
                Đơn hàng của tôi
            </a>
            <a href="#" class="block py-1 hover:text-yellow-500">Danh sách quà tặng</a>
            <a href="#" class="block py-1 hover:text-yellow-500">Điều khoản sử dụng</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <div class="max-w-3xl bg-white rounded-xl shadow-md p-8">
            <!-- Tiêu đề -->
            <div class="flex items-center gap-3 mb-8">
                <a href="index.php" class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-semibold">Thông tin cá nhân</h2>
            </div>

            <!-- Form cập nhật -->
            <form action="index.php?controllers=profile&action=updateInfo" method="POST"
                class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm text-gray-600">Họ và tên</label>
                    <input type="text" name="name" value="<?= $name ?>" placeholder="Nhập họ và tên" class="w-full mt-1 border border-gray-300 rounded-lg p-2 
                               focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <div>
                    <label class="text-sm text-gray-600">Địa chỉ email</label>
                    <input type="email" name="email" value="<?= $email ?>" placeholder="example@gmail.com" class="w-full mt-1 border border-gray-300 rounded-lg p-2 
                               focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <div>
                    <label class="text-sm text-gray-600">Mật khẩu</label>
                    <input type="password" name="password" placeholder="********" class="w-full mt-1 border border-gray-300 rounded-lg p-2 
                               focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <!-- Nút -->
                <div class="col-span-2 flex justify-end gap-3 mt-6">
                    <a href="index.php"
                        class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Hủy
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>