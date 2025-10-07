<?php
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<?php require_once './views/admin/layout/header.php'; ?>
<div class="flex w-full">
    <?php include './views/admin/components/sidebar.php'; ?>

    <!-- Nội dung động -->
    <div id="main-content" class="w-[65%] mx-auto ml-[max(5vw,25px)] my-8 text-gray-600 text-base">
        <!-- Nội dung sẽ load ở đây -->
    </div>
</div>
<?php require_once './views/admin/layout/footer.php'; ?>