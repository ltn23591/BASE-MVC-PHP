<div class="flex flex-col gap-3">
    <!-- Header -->
    <div
        class="hidden md:grid grid-cols-[1fr_3fr_1fr_1fr_1fr] items-center 
                py-3 px-4 bg-gradient-to-r from-gray-100 to-gray-200 border rounded-lg text-sm font-semibold text-gray-700 shadow-sm">
        <b>Ảnh</b>
        <b>Tên</b>
        <b>Danh mục</b>
        <b>Giá</b>
        <b class="text-center">Hành Động</b>
    </div>

    <!-- Items -->
    <?php foreach ($products as $item): ?>
    <?php
        $images = json_decode($item['image'], true) ?? [];
        $firstImage = $images[0] ?? '';
        ?>
    <div class="grid grid-cols-[1fr_3fr_1fr_1fr_1fr] items-center gap-3 py-3 px-4 
                    bg-white border rounded-lg shadow-sm hover:shadow-md transition cursor-pointer">
        <!-- Image -->
        <img class="w-14 h-14 rounded-md object-cover border" src="<?= htmlspecialchars($firstImage) ?>" alt="">

        <!-- Name -->
        <p class="font-medium text-gray-800 truncate"><?= htmlspecialchars($item['name']) ?></p>

        <!-- Category -->
        <p class="text-gray-600"><?= htmlspecialchars($item['category']) ?></p>

        <!-- Price -->
        <p class="font-semibold text-green-600"><?= number_format($item['price'], 0, ',', '.') ?> VND</p>
        <!-- Action -->
        <div class="flex flex-col gap-2">
            <button data-id="<?= $item['id'] ?>" class="btn-delete text-center py-1 px-3 text-sm font-medium rounded-md 
                               bg-red-100 text-red-600 hover:bg-red-500 hover:text-white transition">
                Xóa
            </button>
            <a class="btn-update text-center py-1 px-3 text-sm font-medium rounded-md bg-green-500 text-white hover:bg-green-600 transition"
                href="
                index.php?controllers=admin&action=update&id=<?= $item['id'] ?>">
                <button>
                    Sửa
                </button>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('btn-delete')) {
        const id = e.target.dataset.id;

        if (!confirm(" Bạn có chắc muốn xóa sản phẩm này không?")) return;
        try { // Gửi yêu cầu xóa const res=await
            fetch(`index.php?controllers=admin&action=delete&id=${id}`);
            const data = await res.json();
            if (data.success) { // Sau khi xóa, load lại danh sách sản phẩm const listRes=await
                fetch('index.php?controllers=admin&action=list');
                const html = await listRes.text();
                document.getElementById('main-content').innerHTML = html;
            } else {
                alert("Xóa thất bại!");
            }
        } catch (err) {
            console.error('Lỗi khi xóa:', err);
        }
    }
});
document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('btn-update')) {
        const id = e.target.dataset.id;
    }
    try {
        // const res = await fetch(`index.php?controllers=admin&action=update&id=${id}`);
        const data = await res.json();
    } catch (error) {
        console.log("lỗi update:", error);
    }
})
</script>