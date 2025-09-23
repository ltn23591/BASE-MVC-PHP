<?php
include './public/assets/img/frontend_assets/assets.php';
include __DIR__ . '/../layouts/title.php';

require __DIR__ . '/ProductItem.php';
?>

<div class="border-t-2 pt-10 transition-opacity ease-in-out duration-500 opacity-100">

    <!-- Product Data -->
    <div class="flex gap-12 sm:gap-12 flex-col sm:flex-row">

        <!-- Product Images -->
        <div class="flex-1 flex flex-col-reverse gap-3 sm:flex-row">
            <!-- Thumbnail list -->
            <div
                class="flex sm:flex-col overflow-x-auto sm:overflow-y-scroll justify-between sm:justify-normal sm:w-[18.7%] w-full">

                <?php foreach ($product['image'] as $item): ?>
                <img src="<?= htmlspecialchars($item) ?>" alt="thumb"
                    class="w-[24%] sm:w-full sm:mb-3 flex shrink-0 cursor-pointer"
                    onclick="document.getElementById('mainImage').src='<?= htmlspecialchars($item) ?>'">
                <?php endforeach; ?>

            </div>

            <!-- Main image -->
            <div class="w-full sm:w-[80%]">
                <img id="mainImage" src="<?= htmlspecialchars($product['image'][0]) ?>" class="w-full h-auto" alt="">
            </div>
        </div>

        <!-- Product Info -->
        <div class="flex-1 text-left">
            <h1 class="font-medium text-2xl mt-2">
                <?= htmlspecialchars($product['name']) ?>
            </h1>

            <div class="flex items-center gap-1 mt-2">
                <img src="<?= $assets['star_icon'] ?>" alt="" class="w-3.5">
                <img src="<?= $assets['star_icon'] ?>" alt="" class="w-3.5">
                <img src="<?= $assets['star_icon'] ?>" alt="" class="w-3.5">
                <img src="<?= $assets['star_icon'] ?>" alt="" class="w-3.5">
                <img src="<?= $assets['star_dull_icon'] ?>" alt="" class="w-3.5">
                <p class="pl-2">(122)</p>
            </div>

            <p class="mt-5 text-3xl font-medium">
                $<?= htmlspecialchars($product['price']) ?>
            </p>

            <p class="mt-3 text-gray-500 md:w-4/5">
                <?= htmlspecialchars($product['description']) ?>
            </p>
            <?php $sizes = !empty($product['sizes']) ? json_decode($product['sizes'], true) : []; ?>
            <div class="flex flex-col gap-4 my-8">
                <p>Select Size</p>
                <div class="flex gap-2">
                    <?php foreach ($sizes as $size): ?>
                    <button class="size-btn border py-2 px-4 bg-gray-100" onclick="selectSize('<?= $size ?>', this)">
                        <?= htmlspecialchars($size) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <button
                onclick="addToCartt(<?= $product['id'] ?>,'<?= $product['name'] ?>','<?= $product['image'][0] ?>', <?= $product['price'] ?>)"
                class="bg-black text-white px-8 py-3 text-sm active:bg-gray-700">
                ADD TO CART
            </button>



            <hr class="mt-8 sm:w-4/5">

            <div class="text-sm text-gray-500 mt-5 flex flex-col gap-1">
                <p>100% Original product</p>
                <p>Cash on delivery is available on this product.</p>
                <p>Easy return and exchange policy within 7 days</p>
            </div>
        </div>
    </div>

    <!-- Description & Reviews -->
    <div class="mt-20">
        <div class="flex">
            <b class="border px-5 py-3 text-sm">Description</b>
            <p class="border px-5 py-3 text-sm">Reviews (122)</p>
        </div>
        <div class="flex flex-col gap-4 border px-6 py-6 text-sm text-gray-500 text-left">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Illum corrupti, facilis pariatur dolorem adipisci
                aspernatur sit dignissimos. Est fugiat ipsam ad
                necessitatibus quidem? Nostrum officia eum voluptas,
                ipsum ex nihil?
            </p>
            <p>
                Lorem ipsum, dolor sit amet consectetur adipisicing
                elit. In aut rerum quae accusamus aspernatur libero
                accusantium quisquam saepe mollitia animi, voluptas
                recusandae officiis? Id illum assumenda at consequatur
                possimus, obcaecati sequi nemo alias veniam. Officiis
                obcaecati corrupti vitae dolorem quisquam.
            </p>
        </div>
    </div>
    <!-- Sản phẩm liên quan -->
    <div class='my-24'>
        <div class="text-center text-3xl py-2">
            <?php if (!empty($related) && count($related) > 0): ?>
            <?= Title("SẢN PHẨM", "LIÊN QUAN"); ?>
            <?php else: ?>
            <?= $empty; ?>
            <?php endif; ?>

        </div>
        <div class='grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 mb-5'>
            <?php
            foreach ($related as $p) {
                ProductItem($p['id'], $p['image'], $p['name'], $p['price']);
            }
            ?>
        </div>
    </div>
</div>