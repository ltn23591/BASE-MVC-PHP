<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide flex flex-col sm:flex-row border border-gray-400">
            <div class="w-full sm:w-1/2 flex items-center justify-center py-10 sm:py-0">
                <div class="text-[#414141]">
                    <div class="flex items-center gap-2">
                        <p class="w-8 md:w-11 h-[2px] bg-[#414141]"></p>
                        <p class="font-medium text-sm md:text-base">Sản phẩm bán chạy nhất</p>
                    </div>
                    <h1 class="prata-regular text-3xl sm:py-3 lg:text-5xl leading-relaxed">Hàng mới về</h1>
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-sm md:text-base">Khám phá ngay</p>
                        <p class="w-8 md:w-11 h-[1px] bg-[#414141]"></p>
                    </div>
                </div>
            </div>
            <img class="h-[671px] sm:w-1/2 object-cover object-top bg-top" src="<?= $assets['hero_img'] ?>" alt="Hero">
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide flex flex-col sm:flex-row-reverse border border-gray-400">
            <!-- Nội dung bên phải -->
            <div class="w-full sm:w-1/2 flex items-center justify-center py-10 sm:py-0 px-6 sm:px-12 bg-[#fdfdfd]">
                <div class="text-[#2b2b2b]">
                    <p class="text-xs font-medium tracking-wider uppercase mb-2 text-gray-500">
                        Bộ sưu tập 2025
                    </p>
                    <h1 class="prata-regular text-3xl lg:text-5xl font-semibold leading-snug mb-4">
                        Đơn Giản Là Tinh Tế
                    </h1>
                    <p class="text-sm md:text-base text-gray-600 mb-6">
                        Phong cách tối giản, hiện đại. Chất liệu cao cấp, thiết kế độc quyền.
                    </p>
                    <a href="#"
                        class="inline-block px-6 py-2 bg-black text-white text-sm uppercase tracking-wide hover:bg-gray-800 transition">
                        Khám phá ngay
                    </a>
                </div>
            </div>

            <!-- Ảnh bên trái -->
            <div class="w-full sm:w-1/2">
                <img src="<?= $assets['hero_img_2'] ?? $assets['hero_img'] ?>" alt="Slide 2"
                    class="h-[671px] w-full object-cover object-top object-center" />
            </div>
        </div>


        <!-- Slide 3 -->
        <div class="swiper-slide relative h-[671px]">
            <!-- Ảnh nền -->
            <img src="<?= $assets['hero_img_3'] ?? $assets['hero_img'] ?>" alt="Sale Banner"
                class="absolute inset-0 object-top-[40px] w-full h-full object-cover object-center" />

            <!-- Overlay đen mờ -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Nội dung overlay -->
            <div class="relative z-10 flex items-center justify-center h-full px-6">
                <div class="text-center text-white max-w-2xl">
                    <p class="text-sm uppercase tracking-wider text-gray-300 mb-2">Chỉ trong hôm nay</p>
                    <h1 class="text-4xl lg:text-6xl font-bold mb-4 tracking-tight">Sale lên đến 50%</h1>
                    <p class="text-base text-gray-200 mb-6">Nhanh tay đặt hàng để không bỏ lỡ cơ hội duy nhất trong năm
                    </p>
                    <a href="#"
                        class="inline-block bg-orange-400 hover:bg-red-700 px-8 py-3 text-sm uppercase tracking-widest rounded-sm transition">
                        Mua Ngay
                    </a>
                </div>
            </div>
        </div>


    </div>

    <!-- Optional Pagination -->
    <div class="swiper-pagination"></div>


</div>
<!-- 
Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Swiper Init -->
<script>
var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
</script>