<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
class ProfileController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $id = $_SESSION['user_id'];

        $getInfor = $this->userModel->findById($id);
      
        return $this->view('frontend.profile.index', ['getInfor' =>  $getInfor]);
    }

    public function sendUpdateOtp()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Email không hợp lệ.']);
            exit;
        }

        // Kiểm tra xem email mới có bị người khác sử dụng không
        $currentUser = $this->userModel->findById($id);
        if ($currentUser['email'] !== $email) {
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                echo json_encode(['status' => 'error', 'message' => 'Email này đã được sử dụng bởi tài khoản khác.']);
                exit;
            }
        }

        $otp = rand(100000, 999999);

        // Lưu OTP và dữ liệu cần cập nhật vào session
        $_SESSION['profile_update_otp'] = $otp;
        $_SESSION['profile_update_data'] = [
            'name' => $name,
            'email' => $email,
            'password' => $password, // Lưu mật khẩu chưa hash
        ];
        $_SESSION['profile_update_expire'] = time() + 300; // OTP hết hạn sau 5 phút

        // Gửi email qua PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP tương tự như trong AuthController
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ltn23591@gmail.com'; // Thay bằng email của bạn
            $mail->Password   = 'gmpikbphawtpxyfn'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('ltn23591@gmail.com', 'Fashion Store');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Xác nhận thay đổi thông tin cá nhân';
            $mail->Body    = "Mã OTP của bạn là: <b>$otp</b>. Mã có hiệu lực trong 5 phút.";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Đã gửi OTP tới email của bạn!']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Gửi OTP thất bại: {$mail->ErrorInfo}"]);
        }
        exit;
    }

    public function verifyAndUpdate()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $submittedOtp = $_POST['otp'] ?? '';

        // Kiểm tra OTP
        if (empty($submittedOtp) || !isset($_SESSION['profile_update_otp']) || $submittedOtp != $_SESSION['profile_update_otp']) {
            echo json_encode(['status' => 'error', 'message' => 'Mã OTP không chính xác.']);
            exit;
        }

        if (time() > ($_SESSION['profile_update_expire'] ?? 0)) {
            echo json_encode(['status' => 'error', 'message' => 'Mã OTP đã hết hạn.']);
            exit;
        }

        // Lấy dữ liệu từ session và tiến hành cập nhật
        $id = $_SESSION['user_id'];
        $dataToUpdate = $_SESSION['profile_update_data'];

        $updatePayload = [
            'name' => $dataToUpdate['name'],
            'email' => $dataToUpdate['email'],
        ];

        // Chỉ cập nhật mật khẩu nếu người dùng đã nhập mật khẩu mới
        if (!empty($dataToUpdate['password'])) {
            $updatePayload['password'] = password_hash($dataToUpdate['password'], PASSWORD_DEFAULT);
        }

        $this->userModel->updateData($id, $updatePayload);

        // Cập nhật session user_name nếu tên thay đổi
        if ($_SESSION['user_name'] !== $dataToUpdate['name']) {
            $_SESSION['user_name'] = $dataToUpdate['name'];
        }

        // Xóa session OTP sau khi hoàn tất
        unset($_SESSION['profile_update_otp'], $_SESSION['profile_update_data'], $_SESSION['profile_update_expire']);

        echo json_encode(['status' => 'success', 'message' => 'Cập nhật thông tin thành công!']);
        exit;
    }
}