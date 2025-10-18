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

<div class="flex flex-col sm:flex-row  bg-gray-50 min-h-screen font-sans">
    <!-- Sidebar -->
    <aside class="mx-auto sm:mx-0 w-100 bg-white shadow-md border-r p-6">
        <div class="flex flex-col items-center justify-center text-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($name ?: 'Người dùng') ?>" alt="Avatar"
                class="w-24 h-24 rounded-full mx-auto border-4 border-green-500 object-cover" />
            <h2 class="mt-3 text-lg font-semibold"><?= htmlspecialchars($name ?: 'Người dùng mới') ?></h2>
            <p class="text-gray-500 text-sm">
                Đăng ký: <?= $createdAt ? date('d/m/Y', strtotime($createdAt)) : 'Không rõ' ?>
            </p>
            <p class="flex items-center">
                Mức hạng: <?php if ($getInfor['rank'] == 'Bạc') : ?>Bạc
                <img class="w-8 h-8" src="<?= htmlspecialchars($assets['silver']) ?>" alt="Silver Rank">
                <?php elseif ($getInfor['rank'] == 'Vàng') : ?>Vàng
                <img class="w-8 h-8" src="<?= htmlspecialchars($assets['gold']) ?>" alt="Gold Rank">
                <?php elseif ($getInfor['rank'] == 'Kim Cương') : ?>Kim Cương
                <img class="w-8 h-8" src="<?= htmlspecialchars($assets['diamond']) ?>" alt="Diamond Rank">
                <?php elseif ($getInfor['rank'] == 'Đồng') : ?>Đồng
                <img class="w-8 h-8" src="<?= htmlspecialchars($assets['bronze']) ?>" alt="bronze Rank">
                <?php endif; ?>

            </p>
        </div>
        <div class="mt-6 bg-white rounded-xl shadow p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-800 mb-3"> Tiến độ thăng hạng</h3>

            <?php
            $rank = $getInfor['rank'] ?? 'Đồng';
            $total = $getInfor['total_spent'] ?? 0;

            // Xác định rank kế tiếp & mốc cần đạt
            if ($rank === 'Đồng') {
                $nextRank = 'Bạc';
                $nextThreshold = 1000000;
            } elseif ($rank === 'Bạc') {
                $nextRank = 'Vàng';
                $nextThreshold = 2000000;
            } elseif ($rank === 'Vàng') {
                $nextRank = 'Kim Cương';
                $nextThreshold = 3000000;
            } else {
                $nextRank = null;
                $nextThreshold = $total;
            }

            // Tính phần trăm tiến độ
            $progress = $nextRank ? min(100, ($total / $nextThreshold) * 100) : 100;

            // Màu thanh tiến độ tùy theo rank
            $color = match ($rank) {
                'Bạc' => 'bg-gray-400',
                'Vàng' => 'bg-yellow-400',
                'Kim Cương' => 'bg-blue-400',
                default => 'bg-amber-700',
            };
            ?>

            <div class="flex flex-col justify-between mb-2 text-sm text-gray-700">
                <span>
                    Hạng hiện tại:
                    <strong><?= htmlspecialchars($rank) ?></strong>
                </span>

                <span>
                    <?= number_format($total, 0, ',', '.') ?>đ /
                    <?= number_format($nextThreshold, 0, ',', '.') ?>đ
                </span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden mb-2">
                <div class="<?= $color ?> h-3 rounded-full transition-all duration-500"
                    style="width: <?= $progress ?>%">
                </div>
            </div>

            <p class="text-sm text-gray-600">
                <?php if ($nextRank): ?>
                Cần tích lũy thêm
                <strong><?= number_format($nextThreshold - $total, 0, ',', '.') ?>đ</strong>
                để lên hạng <strong><?= $nextRank ?></strong>
                <?php else: ?>
                Bạn đã đạt hạng cao nhất! 🌟
                <?php endif; ?>
            </p>
        </div>

        <nav class="mt-8 flex flex-col gap-3 text-[15px] font-medium text-gray-700">
            <!-- Thông tin cá nhân -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <i class="fa-solid fa-user text-500"></i>
                <span>Thông tin cá nhân</span>
            </a>

            <!-- Đơn hàng của tôi -->
            <a href="index.php?controllers=order&action=index"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <i class="fa-solid fa-box text-500"></i>
                <span>Đơn hàng của tôi</span>
            </a>

            <!-- Danh sách quà tặng -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <i class="fa-solid fa-gift text-500"></i>
                <span>Danh sách quà tặng</span>
            </a>

            <!-- Điều khoản sử dụng -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">
                <i class="fa-solid fa-file-contract text-500"></i>
                <span>Điều khoản sử dụng</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 p-10">
        <div class="w-full bg-white rounded-xl shadow-md p-8">
            <!-- Tiêu đề -->
            <div class="flex items-center gap-3 mb-8">
                <a href="index.php" class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-semibold">Thông tin cá nhân</h2>
            </div>

            <!-- Form cập nhật -->
            <form id="updateProfileForm" action="index.php?controllers=profile&action=verifyAndUpdate" method="POST"
                class="flex flex-col gap-6">
                <!-- Họ và tên -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <label class="text-sm text-gray-600 sm:w-40 whitespace-nowrap">Họ và tên</label>
                    <input type="text" name="name" value="<?= $name ?>" placeholder="Nhập họ và tên"
                        class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <!-- Email -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <label class="text-sm text-gray-600 sm:w-40 whitespace-nowrap">Địa chỉ email</label>
                    <input type="email" name="email" value="<?= $email ?>" placeholder="example@gmail.com"
                        class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <!-- Mật khẩu -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <label class="text-sm text-gray-600 sm:w-40 whitespace-nowrap">Mật khẩu</label>
                    <input type="password" name="password" placeholder="********"
                        class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 outline-none" />
                </div>

                <!-- Nút -->
                <div class="flex justify-end gap-3 mt-6">
                    <a href="index.php" class="px-5 py-2 sm:px-4 sm:py-1 border border-gray-300 rounded-lg text-gray-700 
              hover:bg-gray-100 transition duration-200">
                        Hủy
                    </a>

                    <button type="button" onclick="sendUpdateOtp()" class="px-6 py-2 sm:px-5 sm:py-1 bg-black text-white font-medium rounded-lg 
                   hover:bg-black-500 transition duration-200">
                        Lưu thay đổi
                    </button>
                </div>

            </form>
        </div>
        <!-- Vùng chứa form OTP -->
        <div id="otp-container" class="w-full max-w-lg mt-6"></div>
    </div>



    </main>
</div>



<script>
Toastify({
    text: "<?= htmlspecialchars($toast) ?>",
    duration: 4000,
    gravity: "top",
    position: "right",
    close: true,
    style: {
        background: "<?= $toastColor ?>"
    }
}).showToast();
</script>
<script>
// Hàm tiện ích để tạo thông báo Toastify
function createToast(message, isSuccess = true) {
    const background = isSuccess ?
        'linear-gradient(to right, #00b09b, #96c93d)' :
        'linear-gradient(to right, #ff416c, #ff4b2b)';

    Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "right",
        close: true,
        style: {
            background: background,
            minWidth: '300px',
            maxWidth: '350px',
            padding: '12px 16px',
            fontSize: '14px',
            borderRadius: '8px',
        },
    }).showToast();
}

function sendUpdateOtp() {
    const form = document.getElementById('updateProfileForm');
    const formData = new FormData(form);
    const button = document.querySelector('button[onclick="sendUpdateOtp()"]');
    const originalButtonText = button.innerHTML;

    button.disabled = true;
    button.innerHTML = 'Đang gửi...';

    fetch("index.php?controllers=profile&action=sendUpdateOtp", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                createToast(data.message, true);
                // Hiển thị form nhập OTP
                fetch("views/frontend/profile/otp.php")
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById("otp-container").innerHTML = html;
                    });
            } else {
                createToast(data.message || "Gửi OTP thất bại", false);
            }
        })
        .catch(err => {
            createToast("Lỗi khi gửi OTP: " + err, false);
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalButtonText;
        });
}

function verifyOtp() {
    const otpInput = document.querySelector('input[name="otp"]');
    if (!otpInput) {
        createToast("Lỗi: Không tìm thấy ô nhập OTP.", false);
        return;
    }
    const otp = otpInput.value.trim();

    if (!otp) {
        createToast("Vui lòng nhập mã OTP.", false);
        return;
    }

    const formData = new FormData();
    formData.append('otp', otp);

    fetch("index.php?controllers=profile&action=verifyAndUpdate", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            createToast(data.message, data.status === "success");
            if (data.status === "success") {
                // Tải lại trang sau 2 giây để người dùng đọc thông báo
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(err => {
            createToast("Lỗi khi xác thực OTP: " + err, false);
        });
}
</script>