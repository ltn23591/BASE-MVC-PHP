<?php
if (!isset($pageTitle)) {
    $pageTitle = "Trang chủ";
    echo '<link rel="stylesheet" href="/public/assets/css/style.css">';
}
?>
<?php include './public/assets/img/frontend_assets/assets.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="./public/assets/css/styles.css">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body>
    <div class="px-4 sm:px[5vw] md:px-[7vw] lg:px[9vw]">
        <div id="root">