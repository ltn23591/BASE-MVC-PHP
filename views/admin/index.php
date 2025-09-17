<?php include __DIR__ . '/layouts/header.php'; ?>
<!-- Toast Container: góc trên bên phải -->

<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2">

    <!-- SUCCESS -->
    <div id="toast-success"
        class="hidden flex items-center w-full max-w-xs p-4 text-gray-700 bg-white rounded-lg shadow">
        <div class="inline-flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-lg">
            <!-- icon -->
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5...Z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium">Thao tác thành công.</div>
        <button type="button" onclick="closeToast('toast-success')"
            class="ms-3 text-gray-400 hover:text-gray-900">✕</button>
    </div>

    <!-- ERROR -->
    <div id="toast-danger"
        class="hidden flex items-center w-full max-w-xs p-4 text-gray-700 bg-white rounded-lg shadow">
        <div class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-100 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5...Z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium">Có lỗi xảy ra.</div>
        <button type="button" onclick="closeToast('toast-danger')"
            class="ms-3 text-gray-400 hover:text-gray-900">✕</button>
    </div>

    <!-- WARNING -->
    <div id="toast-warning"
        class="hidden flex items-center w-full max-w-xs p-4 text-gray-700 bg-white rounded-lg shadow">
        <div class="inline-flex items-center justify-center w-8 h-8 text-orange-600 bg-orange-100 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5...Z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium">Cảnh báo.</div>
        <button type="button" onclick="closeToast('toast-warning')"
            class="ms-3 text-gray-400 hover:text-gray-900">✕</button>
    </div>

</div>

<div class="flex">
    <?php include __DIR__ . '/layouts/sidebar.php'; ?>

    <div id="main-content" class="w-[70%] mx-auto ml-[max(5vw,25px)] my-8 text-gray-600 text-base">
        <p>Chọn chức năng bên trái để bắt đầu</p>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<script src="public/js/admin.js"></script>