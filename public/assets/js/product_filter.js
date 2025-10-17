// ======== product_filter.js ========

// Cấu hình số sản phẩm trên mỗi trang
const ITEMS_PER_PAGE = 8;
let currentPage = 1;

// ======== ÁP DỤNG LỌC, TÌM KIẾM, SẮP XẾP, PHÂN TRANG ========
function applyFilters() {
    const selectedCategories = [...document.querySelectorAll('input[name="category[]"]:checked')].map(el => el.value);
    const selectedSubCategories = [...document.querySelectorAll('input[name="subCategory[]"]:checked')].map(el => el.value);
    const sortType = document.querySelector('select[name="sort"]').value;
    const searchText = document.getElementById('searchInput').value.toLowerCase();

    const allProducts = [...document.querySelectorAll('.product-item')];

    //  LỌC & TÌM KIẾM
    const filtered = allProducts.filter(p => {
        const cat = p.dataset.category;
        const sub = p.dataset.subcategory;
        const name = p.dataset.name.toLowerCase();

        const matchCat = selectedCategories.length === 0 || selectedCategories.includes(cat);
        const matchSub = selectedSubCategories.length === 0 || selectedSubCategories.includes(sub);
        const matchSearch = name.includes(searchText);

        return matchCat && matchSub && matchSearch;
    });

    // SẮP XẾP
    let sorted = [...filtered];
    if (sortType !== 'relavent') {
        sorted.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price) || 0;
            const priceB = parseFloat(b.dataset.price) || 0;
            return sortType === 'low-high' ? priceA - priceB : priceB - priceA;
        });
    }
    // Ẩn tất cả sản phẩm
    allProducts.forEach(p => p.classList.add('hidden'));

    const container = document.getElementById('post_list');
    sorted.forEach(p => container.appendChild(p));

    // 3️⃣ PHÂN TRANG
    const totalPages = Math.ceil(sorted.length / ITEMS_PER_PAGE) || 1;
    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const currentProducts = sorted.slice(start, end);

    // Hiển thị sản phẩm của trang hiện tại
    currentProducts.forEach(p => p.classList.remove('hidden'));

    renderPagination(totalPages);
}

// ======== HIỂN THỊ PHÂN TRANG ========
function renderPagination(totalPages) {
    const paginationContainer = document.querySelector(".pagination");
    if (!paginationContainer) return;

    paginationContainer.innerHTML = '';

    // Nếu chỉ có 1 trang thì không hiển thị thanh phân trang
    if (totalPages <= 1) return;

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = `mx-1 px-3 py-1 border rounded ${
            i === currentPage ? 'bg-black text-white' : 'bg-white hover:bg-gray-100'
        }`;
        btn.addEventListener('click', () => {
            currentPage = i;
            applyFilters();
        });
        paginationContainer.appendChild(btn);
    }
}

// ======== GÁN SỰ KIỆN ========
document.addEventListener('DOMContentLoaded', () => {
    const filterInputs = document.querySelectorAll('input[name="category[]"], input[name="subCategory[]"], select[name="sort"]');
    const searchInput = document.getElementById('searchInput');

    // Khi thay đổi lọc, sắp xếp
    filterInputs.forEach(el => el.addEventListener('change', () => {
        currentPage = 1;
        applyFilters();
    }));

    // Khi nhập tìm kiếm
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            applyFilters();
        });
    }

    // Gọi ban đầu khi trang load
    applyFilters();
});
