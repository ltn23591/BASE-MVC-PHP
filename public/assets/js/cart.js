let selectedSize = null;
let totalProducts = document.getElementById('totalProducts');

function selectSize(size, el) {
    selectedSize = size;
    console.log('Đã chọn size:', selectedSize);

    // Xóa border của các nút khác
    document.querySelectorAll('.size-btn').forEach((btn) => {
        btn.classList.remove('border-orange-500');
    });

    // Thêm border cho nút đang chọn
    el.classList.add('border-orange-500');
}

function addToCartt(id, name, image, price) {
    if (!selectedSize) {
        console.log('Chưa chọn size!');
        return;
    }
    console.log(id, name, image, price, selectedSize);

    $.ajax({
        type: 'POST',
        url: 'index.php?controllers=Cart&action=addToCart',
        data: {
            product_id: id,
            name: name,
            image: image,
            price: price,
            size: selectedSize,
            quantity: 1,
        },
        success: function (response) {
            totalProducts.innerText = response;
            alert('Thêm vào giỏ hàng thành công!');
        },
        error: function (error) {
            alert('Có lỗi xảy ra. Vui lòng thử lại.' + error);
        },
    });
}

