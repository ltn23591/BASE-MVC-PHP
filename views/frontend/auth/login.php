<?php
$currentState = $_GET['state'] ?? 'Login'; // Login / Sign up / reset

// Xác định action cho form
$action = $currentState === 'Sign up' ? 'register' : ($currentState === 'reset' ? 'resetPassword' : 'login');
?>

<div class="flex flex-col items-center w-[90%] sm:max-w-96 m-auto mt-14 gap-4 text-gray-800">
    <div class="inline-flex items-center gap-2 mb-2 mt-10">
        <p class="text-3xl font-bold">
            <?= $currentState==="Login"?"Đăng Nhập":($currentState==="Sign up"?"Đăng Ký":"Đổi Mật Khẩu") ?>
        </p>
        <hr class="border-none h-[1.5px] w-8 bg-gray-800" />
    </div>

    <form method="POST" action="index.php?controllers=auth&action=<?= $action ?>" class="w-full flex flex-col gap-4">

        <?php if ($currentState === "Sign up"): ?>
            <input name="name" class="w-full px-3 py-2 border border-gray-800" type="text" placeholder="Tên" required />
        <?php endif; ?>

        <!-- Email luôn hiện -->
        <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email" value="<?= $email ?? '' ?>" required />

        <?php if ($currentState === "Login"|| $currentState ==="Sign up"): ?>
            <input name="password" class="w-full px-3 py-2 border border-gray-800" type="password" placeholder="Mật khẩu" required />
        <?php elseif ($currentState === "reset"): ?>
            <!-- Luôn hiện input mật khẩu mới -->
            <input name="new_password" class="w-full px-3 py-2 border border-gray-800 mt-2" type="password" placeholder="Nhập mật khẩu mới" required />
        <?php endif; ?>

        <div class="w-full flex justify-between text-sm -mt-2">
            <?php if ($currentState === "Login"): ?>
                <a href="?controllers=auth&action=login&state=reset" class="cursor-pointer">Quên Mật Khẩu?</a>
                <a href="?controllers=auth&action=login&state=Sign up" class="cursor-pointer">Tạo tài khoản</a>
            <?php elseif ($currentState === "Sign up"): ?>
                <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer">Đăng Nhập</a>
            <?php elseif ($currentState === "reset"): ?>
                <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer">Trở về Đăng Nhập</a>
            <?php endif; ?>
        </div>

        <button class="bg-black text-white font-light px-8 py-2 mt-4">
            <?= $currentState === "Login" ? "Đăng Nhập" : ($currentState === "Sign up" ? "Đăng Ký" : "Đổi Mật Khẩu") ?>
        </button>
    </form>
</div>

<?php if (!empty($toast)): ?>
<script>
Toastify({
    text: "<?= htmlspecialchars($toast) ?>",
    duration: 3000,
    gravity: "top",
    position: "right",
    close: true,
    style: {
        background: "linear-gradient(to right, #ff416c, #ff4b2b)"
    }
}).showToast();
</script>
<?php endif; ?>
