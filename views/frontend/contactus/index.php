<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/title.php'; ?>
<div class="container contactus">
    <div class="text-3xl text-center my-5"> <?= Title("LIÊN HỆ", "VỚI CHÚNG TÔI") ?></div>
    <div class="contactus-main">
        <div class="contactus-img">
            <img src="<?= $assets['contact_img'] ?>" alt="Liên hệ">
        </div>
        <div class="contactus-info">
            <div class="contactus-store">
                <b>CỬA HÀNG CỦA CHÚNG TÔI</b>
                <p>29 Đường Âu Cơ<br>
                    Phường 14, Quận 11, Hồ Chí Minh 744003, Việt Nam</p>
                <p>Điện thoại: 0937293828<br>
                    Email: minhsangnguyen@gmail.com</p>
            </div>
            <div class="contactus-career">
                <b>CƠ HỘI NGHỀ NGHIỆP TẠI FOREVER</b>
                <p>Tìm hiểu thêm về đội ngũ và các vị trí tuyển dụng tại FASHION.</p>
                <button class="contactus-btn">Xem việc làm</button>
            </div>
        </div>
    </div>
    <div class="subscribe">
        <h2>Đăng ký nhận tin &amp; nhận ngay ưu đãi 20%</h2>
        <p>Nhập email để nhận thông tin khuyến mãi và xu hướng mới nhất từ Forever.</p>
        <form>
            <input type="email" placeholder="Nhập email của bạn..." required>
            <button type="submit">ĐĂNG KÝ</button>
        </form>
    </div>
</div>