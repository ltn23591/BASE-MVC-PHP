<?php
$currentState = $_GET['state'] ?? 'Login';


$action = $currentState === 'Sign up' ? 'register' : 'login';
?>

<div class="flex flex-col items-center w-[90%] sm:max-w-96 m-auto mt-14 gap-4 text-gray-800">
    <div class="inline-flex items-center gap-2 mb-2 mt-10">
        <p class="text-3xl font-bold"><?= $currentState==="Login"?"Đăng Nhập":"Đăng Ký" ?></p>
        <hr class="border-none h-[1.5px] w-8 bg-gray-800" />
    </div>

    <form method="POST" action="index.php?controllers=auth&action=<?= $action ?>" class="w-full flex flex-col gap-4">

        <?php if ($currentState === "Sign up"): ?>
        <input name="name" class="w-full px-3 py-2 border border-gray-800" type="text" placeholder="Tên" required />
        <?php endif; ?>

        <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email" required />
        <input name="password" class="w-full px-3 py-2 border border-gray-800" type="password" placeholder="Mật khẩu"
            required />

        <div class="w-full flex justify-between text-sm -mt-2">
            <p class="cursor-pointer">Quên Mật Khẩu?</p>

            <?php if ($currentState === "Login"): ?>
            <a href="?controllers=auth&action=login&state=Sign up" class="cursor-pointer">Tạo tài khoản</a>
            <?php else: ?>
            <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer">Đăng Nhập</a>
            <?php endif; ?>
        </div>

        <button class="bg-black text-white font-light px-8 py-2 mt-4">
            <?= $currentState === "Login" ? "Đăng Nhập":"Đăng Ký" ?>
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