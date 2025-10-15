function addToFavorites(productId) {

    // if (!userId) {
    //     Toastify({
    //         text: 'Vui lòng chọn đang nhập để sử dụng tính năng này.',
    //         duration: 3000,
    //         gravity: 'top',
    //         position: 'right',
    //         style: {
    //             background: 'linear-gradient(to right, #ff416c, #ff4b2b)',
    //         },
    //     }).showToast();
    //     return;
    // }
    fetch('index.php?controllers=favorite&action=toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'added') {
            alert('✅ Đã thêm vào danh sách yêu thích!');
        } else if (data.status === 'removed') {
            alert('❌ Đã xóa khỏi danh sách yêu thích!');
        } else if (data.status === 'error') {
            alert(data.message);
            window.location.href = 'index.php?controllers=auth&action=login';
        }
    })
    .catch(err => console.error('Lỗi yêu thích:', err));
}
