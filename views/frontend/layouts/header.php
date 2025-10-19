<?php include './public/assets/img/frontend_assets/assets.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION</title>
    <!-- Style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/reset.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/css/style.css?v=<?= time() ?>">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- atropos -->
    <script src="https://cdn.jsdelivr.net/npm/atropos@2.0.2/atropos.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/atropos@2.0.2/atropos.min.css" rel="stylesheet">
    <!-- Toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MorphSVGPlugin.min.js"></script>


</head>

<body class=" min-h-screen w-full relative">
    <?php
    // Kiểm tra xem có thông báo trong session không
    if (isset($_SESSION['toast_message'])) {
        $toast = $_SESSION['toast_message'];
        $type = $toast['type']; // 'success', 'error', 'warning'
        $message = addslashes($toast['message']); // Dùng addslashes để tránh lỗi JS nếu message có dấu nháy

        // Chọn màu nền dựa trên loại thông báo
        $backgroundColor = '';
        switch ($type) {
            case 'success':
                $backgroundColor = "linear-gradient(to right, #00b09b, #96c93d)";
                break;
            case 'error':
                $backgroundColor = "linear-gradient(to right, #ff5f6d, #ffc371)";
                break;
            case 'warning':
                $backgroundColor = "linear-gradient(to right, #f7b733, #fc4a1a)";
                break;
            default:
                $backgroundColor = "#333";
                break;
        }

        // In ra mã JavaScript để hiển thị Toast
        echo "<script>
            Toastify({
                text: \"{$message}\",
                duration: 3000,
                close: true,
                gravity: \"top\", // `top` or `bottom`
                position: \"right\", // `left`, `center` or `right`
                stopOnFocus: true, // Giữ toast hiển thị khi di chuột vào
                style: {
                    background: \"{$backgroundColor}\",
                }
            }).showToast();
        </script>";

        // Xóa thông báo khỏi session sau khi đã lấy ra để hiển thị
        unset($_SESSION['toast_message']);
    }
    ?>
    <div class=" px-4 sm:px[5vw] md:px-[7vw] lg:px[9vw]">
        <div>