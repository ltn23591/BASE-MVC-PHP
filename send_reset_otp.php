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
    echo json_encode(["status" => "error", "msg" => " Email không hợp lệ"]);
    exit;
}

// ✅ Tạo OTP
$otp = rand(100000, 999999);
$_SESSION['reset_otp'] = $otp;
$_SESSION['reset_email'] = $email;
$_SESSION['reset_expire'] = time() + 300;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ltn23591@gmail.com';
    $mail->Password   = 'gmpikbphawtpxyfn';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    $mail->Encoding   = 'base64';

    $mail->setFrom('ltn23591@gmail.com', 'Quên mật khẩu');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Mã OTP đặt lại mật khẩu';
    $mail->Body    = "
        <h2>🔐 Yêu cầu đặt lại mật khẩu</h2>
        <p>Mã OTP của bạn là: <b style='font-size:20px;'>$otp</b></p>
        <p>OTP có hiệu lực trong <b>5 phút</b>.</p>
    ";

    $mail->send();
    echo json_encode(["status" => "success", "msg" => "✅ OTP đặt lại mật khẩu đã gửi tới $email"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => "❌ Gửi OTP thất bại: {$mail->ErrorInfo}"]);
}