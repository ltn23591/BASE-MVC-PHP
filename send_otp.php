<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

$email = $_POST['email'] ?? null;
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "msg" => "📩 Email không hợp lệ"]);
    exit;
}

// ✅ Giới hạn gửi OTP mỗi 60 giây
if (isset($_SESSION['last_otp_time']) && time() - $_SESSION['last_otp_time'] < 60) {
    echo json_encode(["status" => "error", "msg" => "⚠️ Vui lòng đợi 1 phút trước khi gửi lại OTP"]);
    exit;
}
$_SESSION['last_otp_time'] = time();

// ✅ Tạo OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_expire'] = time() + 300;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ltn23591@gmail.com';
    $mail->Password   = 'gmpikbphawtpxyfn'; // thay bằng app password thật
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    $mail->Encoding   = 'base64';

    $mail->setFrom('ltn23591@gmail.com', 'Fashion Store OTP');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Mã OTP xác thực đăng ký';
    $mail->Body    = "
        <h2>📧 Xác thực OTP</h2>
        <p>Mã OTP của bạn là: <b style='font-size:20px;'>$otp</b></p>
        <p>OTP có hiệu lực trong <b>5 phút</b>.</p>
    ";

    $mail->send();

    echo json_encode([
        "status" => "success",
        "msg" => "✅ OTP đã gửi tới $email. Hãy kiểm tra hộp thư!"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Gửi OTP thất bại: {$mail->ErrorInfo}"
    ]);
}
