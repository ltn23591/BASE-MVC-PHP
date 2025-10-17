<div class="container ">
    <?php
    require_once __DIR__ . '../../../../config/config_url.php';
    require_once './views/frontend/components/Hero.php';
    require_once './views/frontend/layouts/title.php';
    ?>
    <div class="flex flex-col gap-10">
        <?php
        // hiển thị danh sách sản phẩm mới
        require_once './views/frontend/components/LastedCollection.php';
        // sản phẩm bán chạy
        require_once './views/frontend/components/BestSeller.php';
     

        require_once './views/frontend/featuredcollection/index.php';
        // Chính sách
        require_once './views/frontend/components/OurPolicy.php';
        require_once './views/frontend/components/NewsLetterBox.php';
        ?>
    </div>
</div>