<?php include_once __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/title.php';
?>

<div class="container">
    <div class="text-center text-2xl"><?= Title("VỀ", "CHÚNG TÔI") ?></div>
    <div class="about">

        <div class="about-img">
            <img src="<?= $assets['about_img'] ?>" alt="Về chúng tôi">
        </div>
        <div class="about-text">
            <p>
                Forever được thành lập với niềm đam mê đổi mới và mong muốn cách mạng hóa trải nghiệm mua sắm trực
                tuyến. Hành trình của chúng tôi bắt đầu với ý tưởng đơn giản: tạo ra một nền tảng nơi khách hàng có thể
                dễ dàng khám phá, tìm hiểu và mua sắm đa dạng sản phẩm ngay tại nhà.
            </p>
            <p>
                Từ khi thành lập, chúng tôi luôn nỗ lực tuyển chọn các sản phẩm chất lượng cao, đáp ứng mọi sở thích và
                nhu cầu. Từ thời trang, làm đẹp đến điện tử và đồ dùng gia đình, Forever mang đến bộ sưu tập phong phú
                từ các thương hiệu và nhà cung cấp uy tín.
            </p>
            <h3>Sứ mệnh của chúng tôi</h3>
            <p>
                Sứ mệnh của Forever là trao quyền lựa chọn, sự tiện lợi và sự tự tin cho khách hàng. Chúng tôi cam kết
                mang đến trải nghiệm mua sắm liền mạch, vượt trên mong đợi từ khâu tham khảo, đặt hàng đến giao nhận và
                hậu mãi.
            </p>
        </div>
    </div>
    <div class="why">
        <h2>TẠI SAO CHỌN CHÚNG TÔI</h2>
        <div class="features">
            <div class="feature">
                <h4>Đảm bảo chất lượng</h4>
                <p>Chúng tôi tuyển chọn và kiểm duyệt từng sản phẩm để đảm bảo đáp ứng tiêu chuẩn chất lượng nghiêm
                    ngặt.</p>
            </div>
            <div class="feature">
                <h4>Tiện lợi</h4>
                <p>Giao diện thân thiện, quy trình đặt hàng nhanh chóng giúp việc mua sắm trở nên dễ dàng hơn bao giờ
                    hết.</p>
            </div>
            <div class="feature">
                <h4>Dịch vụ khách hàng tận tâm</h4>
                <p>Đội ngũ chuyên nghiệp luôn sẵn sàng hỗ trợ, đảm bảo sự hài lòng của bạn là ưu tiên hàng đầu.</p>
            </div>
        </div>
    </div>

    <div class="subscribe">
        <h2>Đăng ký nhận tin &amp; nhận ngay ưu đãi 20%</h2>
        <p>Đăng ký email để nhận thông tin khuyến mãi và xu hướng mới nhất từ Forever.</p>
        <form>
            <input type="email" placeholder="Nhập email của bạn..." required>
            <button type="submit">ĐĂNG KÝ</button>
        </form>
    </div>
</div>