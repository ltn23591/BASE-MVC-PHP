<?php


// Nếu chưa đăng nhập thì quay về login
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../public/assets/css/styles.css">
    <link rel="stylesheet" href="./public/assets/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../public/assets/css/admin.css">
</head>

<body class="bg-gray-50 min-h-screen text-gray-600">

    <?php include 'navbar.php'; ?>
    <hr>

    <div class="flex w-full">
        <!-- <?php include 'sidebar.php'; ?> -->

        <div class="w-[70%] mx-auto ml-[max(5vw,25px)] my-8 text-base">
            <!-- <?php
                    // Router đơn giản
                    $page = $_GET['page'] ?? 'add';

                    switch ($page) {
                        case 'list':
                            include 'list.php';
                            break;
                        case 'orders':
                            include 'orders.php';
                            break;
                        case 'add':
                        default:
                            include 'add.php';
                            break;
                    }
                    ?> -->
        </div>
    </div>

</body>

</html>