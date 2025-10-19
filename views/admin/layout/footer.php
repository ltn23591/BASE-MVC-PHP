</div>
</div>
<div id="toastContainer" class="fixed top-4 right-4 space-y-3 z-50"></div>

</body>


<script>
document.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', async (e) => {
        e.preventDefault();
        const url = link.getAttribute('data-url');

        try {
            const res = await fetch(url);
            const html = await res.text();
            document.getElementById('main-content').innerHTML = html;
        } catch (err) {
            console.error('Lỗi tải nội dung:', err);
        }
    });
});

document.addEventListener('click', function(e) {
    // Nếu click vào nút xóa
    if (e.target.classList.contains('btn-delete')) {
        const id = e.target.getAttribute('data-id');
        if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')) {
            fetch(`index.php?controllers=admin&action=delete&id=${id}`)
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        loadList(); // gọi lại load danh sách
                    } else {
                        alert('Xóa thất bại!');
                    }
                })
                .catch((err) => console.error(err));
        }
    }
});
// Hàm tải lại danh sách
function loadList() {
    fetch('index.php?controllers=admin&action=list')
        .then((res) => res.text())
        .then((html) => {
            document.getElementById('main-content').innerHTML = html;
        });
}

/////////////////////
function showToast(type, message) {
    const colors = {
        success: 'bg-green-500 shadow-green-100',
        warning: 'bg-yellow-500 shadow-yellow-100',
        error: 'bg-red-500 shadow-red-100',
        info: 'bg-blue-500 shadow-blue-100'
    };

    const container = document.getElementById('toastContainer');

    const toast = document.createElement('div');
    toast.className =
        `${colors[type]} text-white font-semibold tracking-wide flex items-center w-full min-w-xs max-w-sm p-4 rounded-md shadow-md animate-fade`;
    toast.innerHTML = `
      <span class="text-[15px] mr-3">${message}</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-3 cursor-pointer shrink-0 fill-white ml-auto" viewBox="0 0 320.591 320.591">
        <path d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"/>
        <path d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"/>
      </svg>
  `;

    // Gắn nút đóng
    toast.querySelector('svg').addEventListener('click', () => toast.remove());

    container.appendChild(toast);

    // Tự ẩn sau 3 giây
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

</html>