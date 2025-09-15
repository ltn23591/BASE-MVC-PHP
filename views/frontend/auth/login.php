<?php
$currentState = $_GET['state'] ?? 'Login';


$action = $currentState === 'Sign up' ? 'register' : 'login';
?>

<div class="flex flex-col items-center w-[90%] sm:max-w-96 m-auto mt-14 gap-4 text-gray-800">
    <div class="inline-flex items-center gap-2 mb-2 mt-10">
        <p class="text-3xl font-bold"><?= $currentState ?></p>
        <hr class="border-none h-[1.5px] w-8 bg-gray-800" />
    </div>

    <form method="POST" action="index.php?controllers=auth&action=<?= $action ?>" class="w-full flex flex-col gap-4">

        <?php if ($currentState === "Sign up"): ?>
        <input name="name" class="w-full px-3 py-2 border border-gray-800" type="text" placeholder="Name" required />
        <?php endif; ?>

        <input name="email" class="w-full px-3 py-2 border border-gray-800" type="email" placeholder="Email" required />
        <input name="password" class="w-full px-3 py-2 border border-gray-800" type="password" placeholder="Password"
            required />

        <div class="w-full flex justify-between text-sm -mt-2">
            <p class="cursor-pointer">Forgot your password?</p>

            <?php if ($currentState === "Login"): ?>
            <a href="?controllers=auth&action=login&state=Sign up" class="cursor-pointer">Create account</a>
            <?php else: ?>
            <a href="?controllers=auth&action=login&state=Login" class="cursor-pointer">Login here</a>
            <?php endif; ?>
        </div>

        <button class="bg-black text-white font-light px-8 py-2 mt-4">
            <?= $currentState === "Login" ? "Sign In" : "Sign Up" ?>
        </button>
    </form>
</div>