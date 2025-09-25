let totalProducts = document.getElementById('totalProducts');
let selectedSize = null;
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
    let formData = new FormData();
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
            try {
                let data = JSON.parse(response);

                if (data.status === 'error' && data.redirect) {
                    Toastify({
                        text: data.message || 'Bạn cần đăng nhập',
                        duration: 2000,
                        gravity: 'top',
                        position: 'right',
                        close: true,
                        style: {
                            background:
                                'linear-gradient(to right, #ff416c, #ff4b2b)', // đỏ
                        },
                    }).showToast();
                    window.location.href = data.redirect;
                } else if (data.status === 'success') {
                    totalProducts.innerText = data.totalQuantity;
                    Toastify({
                        text: 'Đã thêm vào giỏ hàng!',
                        duration: 3000,
                        gravity: 'top',
                        position: 'right',
                        close: true,
                        style: {
                            background:
                                'linear-gradient(to right, #00b09b, #96c93d)',
                        },
                    }).showToast();
                } else {
                    alert(data.message || 'Có lỗi xảy ra!');
                }
            } catch (e) {
                console.error('Lỗi parse JSON:', e, response);
            }
        },
        error: function (error) {
            alert('Có lỗi xảy ra. Vui lòng thử lại.' + error);
        },
    });
}
function buyNow(id, name, image, price) {
    if (!selectedSize) {
        Toastify({
            text: 'Vui lòng chọn size trước khi mua!',
            duration: 3000,
            gravity: 'top',
            position: 'right',
            style: {
                background: 'linear-gradient(to right, #ff416c, #ff4b2b)',
            },
        }).showToast();
        return;
    }

    // ✅ Tạo form ẩn gửi sang trang checkout
    const form = document.createElement('form');
    form.method = 'POST';
    form.action =
        'http://localhost/BASE_MVC/index.php?controllers=checkout&action=index';

    const fields = [
        { name: 'product_id', value: id },
        { name: 'name', value: name },
        { name: 'image', value: image },
        { name: 'price', value: price },
        { name: 'size', value: selectedSize },
        { name: 'quantity', value: 1 },
        { name: 'buy_now', value: 1 },
    ];

    fields.forEach((f) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = f.name;
        input.value = f.value;
        form.appendChild(input);
    });

    document.body.appendChild(form);

    // ✅ Gửi form → trình duyệt sẽ CHUYỂN TRANG đến checkout
    form.submit();
}
