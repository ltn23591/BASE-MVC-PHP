<?php include './public/assets/img/admin_assets/assets.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>

<body class="bg-gray-50 min-h-screen text-gray-600">
    <div class="flex items-center py-2 px-[4%] justify-between">
        <img class="w-[max(10%,80px)]" src="<?= $assets['logo'] ?>" alt="" />
        <a href="index.php?controllers=auth&action=logout">
            <button
                class=" cursor-pointer bg-gray-600 text-white px-5 py-2 sm:px-7 sm:py-2 rounded-full text-xs sm:text-sm">
                Đăng Xuất
            </button>
        </a>
    </div>
    <hr>
    <div class="flex w-full">
        <div class="w-full mx-auto ml-[max(5vw,25px)] my-8 text-base">