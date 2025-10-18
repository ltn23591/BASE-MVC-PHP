<?php
require_once './models/VoucherModel.php';

class ApplyvoucherController extends BaseController
{
    private $voucherModel;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel;
    }

    public function applyVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        $status = true;
        $discountPercent = 0;
        $discountValue = 0;
        $newTotal = 0;

        if (empty($code)) {
            $status = false;
            $message = "Vui lòng nhập mã giảm giá.";
        }

        $voucherModel = new VoucherModel();

        $voucher = $voucherModel->findByCode($code);

        // Kiểm tra giỏ hàng trống
        if (empty($_SESSION['cart'])) {
            $status = false;
            $message = "Giỏ hàng trống.";
        }
        
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Kiểm tra voucher tồn tại
        if (!$voucher) {
            $status = false;
            $message = "Mã giảm giá không tồn tại.";
        }
        else{
            // Kiểm tra ngày hiệu lực của voucher
            $today = date('Y-m-d');
            if ($today < $voucher['start_date'] || $today > $voucher['end_date']) {
                $status = false;
                $message = "Mã giảm giá không còn hiệu lực.";
            }
            // Tính toán giá trị giảm giá
            $discountPercent = ($voucher['discount']);
            $discountValue = $total * ($discountPercent / 100);

            $newTotal = max(0, $total - $discountValue);

            if ($status) {
                $message = "Áp dụng mã giảm giá thành công, giảm {$discountPercent}%!";
            }

        }
        // Lưu thông tin giảm giá vào session
        $_SESSION['discount'] = $discountValue;
        $_SESSION['total_after_discount'] = $newTotal;

        // Trả về phản hồi dưới dạng JSON
        echo json_encode([
            'success' => $status,
            'total' => $total,
            'discount_value' => $discountValue,
            'discount' => $discountPercent,
            'new_total' => $newTotal,
            'message' => $message,
        ]);
    }
}