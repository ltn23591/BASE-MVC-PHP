<div class="w-full mx-auto my-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Thêm Người Dùng</h2>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg">
        <form id="addUserForm" action="index.php?controllers=admin&action=adduser" method="POST" class="space-y-5">
            <!-- Tên -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên người dùng</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Thêm User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Toast -->
<div id="toast"
     class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow hidden">
    ✅ Thêm thành công!
</div>

<script>
document.getElementById('addUserForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let res = await fetch(this.action, {
        method: 'POST',
        body: formData
    });
    let data = await res.json();

    if (data.success) {
        // hiện toast
        let toast = document.getElementById('toast');
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);

        // reset form
        this.reset();
    }
});
</script>
