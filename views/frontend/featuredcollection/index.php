<?php require_once __DIR__ . '/../layouts/title.php'; ?>
<section class="bg-white mt-5">
    <div class="mx-auto flex flex-col items-center gap-10">
        <!-- Heading -->
        <div class="max-w-[768px] text-center flex flex-col items-center">
            <div class="text-3xl text-center"> <?= Title("BỘ SƯU TẬP", "ĐẶC BIỆT") ?></div>

            <p class="text-gray-600 text-lg">Tinh tế – Tối giản – Đậm dấu ấn riêng.</p>
        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 gap-8 w-full">
            <!-- Left Column -->
            <div class="flex flex-col gap-8">
                <!-- Card 1 -->
                <div data-aos="fade-right" data-aos-duration="1000"
                    class=" border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1603692833615-81dd11ebd2e6?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1173"
                        alt="Men collection" class="w-full h-[300px] md:h-[360px] object-cover">
                    <div class="p-8 flex flex-col gap-6">
                        <div>
                            <p class="text-sm uppercase text-gray-500 font-semibold">Bộ sưu tập</p>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Nam hiện đại</h3>
                            <p class="text-gray-600 mt-3">Phong cách thanh lịch, tối giản dành cho quý ông hiện đại.</p>
                        </div>
                        <div class="flex gap-4">
                            <a href="index.php?controllers=product&action=filter&category=men"
                                class="px-5 py-2 border border-gray-800 rounded-md hover:bg-gray-900 hover:text-white transition">Xem
                                ngay</a>
                            <a href="#"
                                class="inline-flex items-center gap-2 text-orange-500 font-medium hover:underline">Chi
                                tiết
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div data-aos="fade-right" data-aos-duration="1000" class=" grid sm:grid-cols-2 gap-6">
                    <div
                        class="border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <img src="https://cdn-icons-png.flaticon.com/512/994/994928.png" class="w-10 h-10 mb-4"
                                alt="Kids">
                            <h4 class="text-xl font-semibold text-gray-900">Trẻ em năng động</h4>
                            <p class="text-gray-600 mt-2">Sắc màu tuổi thơ – thoải mái và đáng yêu trong từng chi tiết.
                            </p>
                        </div>
                        <a href="index.php?controllers=product&action=filter&category=kids"
                            class="text-orange-500 font-medium hover:underline mt-4 inline-flex items-center gap-2">Khám
                            phá
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div
                        class="border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <img src="https://cdn-icons-png.flaticon.com/512/994/994946.png" class="w-10 h-10 mb-4"
                                alt="Limited">
                            <h4 class="text-xl font-semibold text-gray-900">Bộ sưu tập Limited</h4>
                            <p class="text-gray-600 mt-2">Thiết kế giới hạn – dành riêng cho những ai yêu sự khác biệt.
                            </p>
                        </div>
                        <a href="index.php?controllers=product&action=filter&category=limited"
                            class="text-orange-500 font-medium hover:underline mt-4 inline-flex items-center gap-2">Xem
                            thêm
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-8">
                <!-- Card 3 -->
                <div data-aos="fade-left" data-aos-duration="1000"
                    class="flex flex-col md:flex-row border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1541519481457-763224276691?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=687"
                        alt="Women collection" class="md:w-1/2 w-full h-[300px] object-cover object-top">
                    <div class="p-8 flex flex-col justify-center gap-4">
                        <p class="text-sm uppercase text-gray-500 font-semibold">Bộ sưu tập</p>
                        <h3 class="text-2xl font-bold text-gray-900 leading-snug">Nữ thanh lịch</h3>
                        <p class="text-gray-600">Phong cách hiện đại, nữ tính, phù hợp cho mọi dịp.</p>
                        <a href="index.php?controllers=product&action=filter&category=women"
                            class="text-orange-500 font-medium hover:underline mt-2 inline-flex items-center gap-2">Mua
                            ngay
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div data-aos="fade-left" data-aos-duration="1000"
                    class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=687"
                        alt="New arrivals" class="w-full h-[300px] md:h-[360px] object-cover">
                    <div class="p-8 flex flex-col gap-4">
                        <p class="text-sm uppercase text-gray-500 font-semibold">Bộ sưu tập</p>
                        <h3 class="text-3xl font-bold text-gray-900">Mùa mới – New Arrivals</h3>
                        <p class="text-gray-600">Cập nhật phong cách mới nhất – bắt đầu hành trình thời trang của bạn.
                        </p>
                        <div class="flex gap-4 mt-2">
                            <a href="index.php?controllers=product&action=filter&category=new"
                                class="px-6 py-2 border border-gray-800 rounded-md hover:bg-gray-900 hover:text-white transition">Khám
                                phá</a>
                            <a href="index.php?controllers=product&action=list"
                                class="inline-flex items-center gap-2 text-orange-500 font-medium hover:underline">Tất
                                cả sản phẩm
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>