<div class="flex flex-col gap-2">
    <div class="hidden md:grid grid-cols-[1fr_3fr_1fr_1fr_1fr] items-center 
              py-1 px-2 border bg-gray-100 text-sm">
        <b>Image</b>
        <b>Name</b>
        <b>Category</b>
        <b>Price</b>
        <b class="text-center">Action</b>
    </div>

    <?php foreach ($products as $item): ?>
    <?php
        $images = json_decode($item['image'], true) ?? [];
        $firstImage = $images[0] ?? '';
        ?>
    <div class="grid grid-cols-[1fr_3fr_1fr_1fr_1fr] items-center gap-2 py-1 px-2 border text-sm">
        <img class="w-12 h-12 object-cover" src="<?= htmlspecialchars($firstImage) ?>" alt="">
        <p><?= htmlspecialchars($item['name']) ?></p>
        <p><?= htmlspecialchars($item['category']) ?></p>
        <p>$<?= number_format($item['price']) ?></p>
        <p data-id="<?= $item['id'] ?>" class="btn-delete text-center cursor-pointer text-red-500 hover:font-bold">
            X
        </p>
    </div>
    <?php endforeach; ?>
</div>
<script>
document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('btn-delete')) {
        const id = e.target.dataset.id;

        if (!confirm("Bạn có chắc muốn xóa sản phẩm này không?")) return;

        try {
            // 📌 Gửi yêu cầu xóa
            const res = await fetch(`index.php?controllers=admin&action=delete&id=${id}`);
            const data = await res.json();

            if (data.success) {
                // 📌 Sau khi xóa, load lại danh sách sản phẩm
                const listRes = await fetch('index.php?controllers=admin&action=list');
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
</script>