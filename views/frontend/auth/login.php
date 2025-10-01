<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$toastMsg = $_SESSION['toast_success'] ?? null;
unset($_SESSION['toast_success']);

$currentState = $_GET['state'] ?? 'Login';
$action = $currentState === 'Sign up' ? 'register' : ($currentState === 'reset' ? 'resetPassword' : 'login');
?>

<div class="flex flex-col items-center w-[90%] sm:max-w-96 m-auto mt-14 gap-4 text-gray-800">
    <div class="inline-flex items-center gap-2 mb-2 mt-10">
        <p class="text-3xl font-bold">
            <?= $currentState === "Login" ? "Đăng Nhập" : ($currentState === "Sign up" ? "Đăng Ký" : "Đổi Mật Khẩu") ?>
        </p>
        <hr class="border-none h-[1.5px] w-8 bg-gray-800" />
    </div>

    <form method="POST" action="index.php?controllers=auth&action=<?= $action ?>" class="w-full flex flex-col gap-4">
        <!-- Sign up -->
        <?php if ($currentState === "Sign up"): ?>
            <input name="name" class="w-full px-3 py-2 border border-gray-800" type="text" placeholder="Tên" required />
        <?php endif; ?>

        <!-- Email & OTP -->
        <?php if ($currentState === "Sign up"): ?>
            <div class="flex gap-2">
                <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email"
                    required />
                <button type="button" onclick="sendOtp()" class="bg-blue-600 text-white px-4 hover:bg-blue-700 transition">
                    Gửi OTP
                </button>
            </div>
            <input name="otp" class="w-full px-3 py-2 border border-gray-800" type="text"
                placeholder="Nhập mã OTP nhận được" required />
        <?php elseif ($currentState === "reset"): ?>
            <div class="flex gap-2">
                <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email"
                    required />
                <button type="button" onclick="sendResetOtp()"
                    class="bg-blue-600 text-white px-4 hover:bg-blue-700 transition">
                    Gửi OTP
                </button>
            </div>
            <input name="otp" class="w-full px-3 py-2 border border-gray-800 mt-2" type="text" placeholder="Nhập OTP"
                required />
            <input name="new_password" class="w-full px-3 py-2 border border-gray-800 mt-2" type="password"
                placeholder="Nhập mật khẩu mới" required />
        <?php else: ?>
            <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email"
                value="<?= $email ?? '' ?>" required />
        <?php endif; ?>

        <!-- Mật khẩu -->
        <?php if ($currentState === "Login" || $currentState === "Sign up"): ?>
            <input name="password" class="w-full px-3 py-2 border border-gray-800" type="password" placeholder="Mật khẩu"
                required />
        <?php endif; ?>

        <!-- Liên kết điều hướng -->
        <div class="w-full flex justify-between text-sm -mt-2">
            <?php if ($currentState === "Login"): ?>
                <a href="?controllers=auth&action=login&state=reset" class="cursor-pointer hover:underline">Quên Mật
                    Khẩu?</a>
                <a href="?controllers=auth&action=login&state=Sign up" class="cursor-pointer hover:underline">Tạo tài
                    khoản</a>
            <?php elseif ($currentState === "Sign up"): ?>
                <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer hover:underline">Đăng Nhập</a>
            <?php elseif ($currentState === "reset"): ?>
                <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer hover:underline">Trở về Đăng
                    Nhập</a>
            <?php endif; ?>
        </div>

        <!-- Nút xác nhận -->
        <button class="bg-black text-white font-light px-8 py-2 mt-4 hover:bg-gray-900 transition">
            <?= $currentState === "Login" ? "Đăng Nhập" : ($currentState === "Sign up" ? "Đăng Ký" : "Đổi Mật Khẩu") ?>
        </button>
    </form>
</div>

<?php
$toastShow = $toastMsg ?? $toast ?? null;
$toastColor = isset($toastMsg)
    ? "linear-gradient(to right, #00b09b, #96c93d)"
    : "linear-gradient(to right, #ff416c, #ff4b2b)";
?>
<?php if (!empty($toastShow)): ?>
    <script>
        Toastify({
            text: "<?= htmlspecialchars($toastShow) ?>",
            duration: 4000,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "<?= $toastColor ?>"
            }
        }).showToast();
    </script>
<?php endif; ?>

<!-- SCRIPT DÙNG CHUNG -->
<script>
    function startCountdown(button, seconds) {
        let remaining = seconds;
        button.disabled = true;
        button.style.opacity = "0.7";
        button.style.cursor = "not-allowed";
        button.innerText = `Gửi lại sau ${remaining}s`;

        const interval = setInterval(() => {
            remaining--;
            button.innerText = `Gửi lại sau ${remaining}s`;
            if (remaining <= 0) {
                clearInterval(interval);
                resetButton(button);
            }
        }, 1000);
    }

    function resetButton(button) {
        button.disabled = false;
        button.style.opacity = "1";
        button.style.cursor = "pointer";
        button.innerText = "Gửi OTP";
    }

    function sendOtp() {
        const email = document.querySelector('input[name="email"]').value.trim();
        const button = document.querySelector('button[onclick="sendOtp()"]');

        if (!email) {
            alert(" Vui lòng nhập email trước khi gửi OTP!");
            return;
        }

        startCountdown(button, 60);

        fetch("index.php?controllers=auth&action=sendOtp", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "email=" + encodeURIComponent(email)
            })
            .then(res => res.text())
            .then(txt => {
                try {
                    const data = JSON.parse(txt);
                    alert(data.msg);
                } catch (e) {
                    alert("Không đọc được phản hồi từ server:\n\n" + txt);
                }
            })
            .catch(err => {
                alert("Gửi OTP thất bại. Kiểm tra kết nối hoặc cấu hình email.\n" + err);
                resetButton(button);
            });
    }

    function sendResetOtp() {
        const email = document.querySelector('input[name="email"]').value.trim();
        const btn = document.querySelector('button[onclick="sendResetOtp()"]');

        if (!email) {
            alert("⚠️ Vui lòng nhập email trước khi gửi OTP!");
            return;
        }

        startCountdown(btn, 60);

        fetch("index.php?controllers=auth&action=resetOtp", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "email=" + encodeURIComponent(email)
            })
            .then(res => res.json())
            .then(data => alert(data.msg))
            .catch(err => {
                alert(" Gửi OTP thất bại.");
                resetButton(btn);
            });
    }
</script>