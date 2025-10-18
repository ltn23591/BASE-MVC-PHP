<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
class AuthController extends BaseController
{
    private $userModel;
    private $cartModel;
    public function __construct()
    {

        $this->loadModel('UserModel');
        $this->userModel = new UserModel();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Trang quản trị
    public function admin()
    {
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        return $this->viewAdmin('admin.home.index', [
            'pageTitle' => 'Trang quản trị'
        ]);
    }

    // Đăng nhập
    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Trường hợp admin
                if ($email === 'admin@gmail.com' && $password === '123') {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $email;

                    header('Location: index.php?controllers=auth&action=admin');
                    exit();
                }

                // Tìm user trong DB
                $user = $this->userModel->findByEmail($email);
                if (!$user) {
                    return $this->view('frontend.auth.login', [
                        'pageTitle' => 'Đăng nhập',
                        'toast' => "Tài khoản không tồn tại!"
                    ]);
                }

                // Kiểm tra mật khẩu
                if (!password_verify($password, $user['password'])) {
                    return $this->view('frontend.auth.login', [
                        'pageTitle' => 'Đăng nhập',
                        'toast' => "Sai mật khẩu!"
                    ]);
                }

                if ($user['status'] === 'locked') {
                    return $this->view('frontend.auth.login', [
                        'toast' => "Tài khoản đã bị khóa!"
                    ]);
                } else {
                    //  Đăng nhập thành công
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $this->loadModel('CartModel');
                    $cartModel = new CartModel();
                    $_SESSION['cart'] = $cartModel->rowsToSessionCart(
                        $cartModel->getByUser((int)$user['id'])
                    );

                    header('Location: index.php');
                    exit();
                }
            }
        } catch (Exception $e) {
            $toast = $e->getMessage();
        }

        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đăng nhập',
            'toast' => $toast ?? null
        ]);
    }

    // Đăng ký tài khoản
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $otpInput = $_POST['otp'] ?? null;

            if ($this->userModel->findByEmail($email)) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => " Email đã tồn tại!"
                ]);
            }

            // Kiểm tra OTP
            if (!isset($_SESSION['otp']) || time() > $_SESSION['otp_expire']) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => " OTP đã hết hạn. Vui lòng gửi lại."
                ]);
            }

            if (strtolower($email) != strtolower($_SESSION['otp_email'])) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => " Email không trùng với email đã gửi OTP."
                ]);
            }

            if ($otpInput != $_SESSION['otp']) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => " Mã OTP không đúng."
                ]);
            }

            //  OTP đúng ➝ Lưu tài khoản
            unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_expire']);

            $this->userModel->store([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'status' => 'active'
            ]);

            $_SESSION['toast_success'] = " Đăng ký thành công! Bạn có thể đăng nhập ngay.";
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đăng ký'
        ]);
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header('Location: index.php?controllers=auth&action=login');
        exit();
    }

    // Quên mật khẩu
    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $otpInput = $_POST['otp'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';

            //  Kiểm tra OTP
            if (!isset($_SESSION['reset_otp']) || time() > $_SESSION['reset_expire']) {
                $toast = "OTP đã hết hạn. Vui lòng gửi lại.";
            } elseif (strtolower($email) !== strtolower($_SESSION['reset_email'])) {
                $toast = "Email không trùng khớp với email đã gửi OTP.";
            } elseif ($otpInput != $_SESSION['reset_otp']) {
                $toast = "Mã OTP không chính xác.";
            } else {
                // OTP đúng ➝ đổi mật khẩu
                $user = $this->userModel->findByEmail($email);
                if (!$user) {
                    $toast = "Email không tồn tại.";
                } else {
                    // Hash mật khẩu mới trước khi lưu
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $this->userModel->updateData($user['id'], ['password' => $hashedPassword]);

                    // Xoá session OTP
                    unset($_SESSION['reset_otp'], $_SESSION['reset_email'], $_SESSION['reset_expire']);

                    $_SESSION['toast_success'] = "Mật khẩu đã đổi thành công! Bạn có thể đăng nhập.";
                    header("Location: index.php?controllers=auth&action=login");
                    exit();
                }
            }

            return $this->view('frontend.auth.login', [
                'pageTitle' => 'Đổi mật khẩu',
                'toast' => $toast,
                'state' => 'reset',
                'email' => $email
            ]);
        } else {
            return $this->view('frontend.auth.login', [
                'pageTitle' => 'Quên mật khẩu',
                'state' => 'reset'
            ]);
        }
    }

    // Gửi OTP
    public function sendOtp()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $email = $_POST['email'] ?? null;
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "msg" => "Email không hợp lệ"]);
            exit;
        }

        //  Giới hạn gửi OTP mỗi 60 giây
        if (isset($_SESSION['last_otp_time']) && time() - $_SESSION['last_otp_time'] < 60) {
            echo json_encode(["status" => "error", "msg" => " Vui lòng đợi 1 phút trước khi gửi lại OTP"]);
            exit;
        }
        $_SESSION['last_otp_time'] = time();

        //  Tạo OTP
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
        <h2> Xác thực OTP</h2>
        <p>Mã OTP của bạn là: <b style='font-size:20px;'>$otp</b></p>
        <p>OTP có hiệu lực trong <b>5 phút</b>.</p>
    ";

            $mail->send();

            echo json_encode([
                "status" => "success",
                "msg" => " OTP đã gửi tới $email. Hãy kiểm tra hộp thư!"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "msg" => " Gửi OTP thất bại: {$mail->ErrorInfo}"
            ]);
        }
    }

    // Gửi OTP đặt lại mật khẩu
    public function resetOtp()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? null;
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["status" => "error", "msg" => "Email không hợp lệ"]);
            exit;
        }

        //  Tạo OTP
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
            echo json_encode(["status" => "success", "msg" => " OTP đặt lại mật khẩu đã gửi tới $email"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "msg" => " Gửi OTP thất bại: {$mail->ErrorInfo}"]);
        }
    }
}