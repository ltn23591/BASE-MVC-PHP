<?php

class AuthController extends BaseController
{
    private $userModel;

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

                // ✅ Đăng nhập thành công
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
                    'toast' => "❌ Email đã tồn tại!"
                ]);
            }

            // ✅ Kiểm tra OTP
            if (!isset($_SESSION['otp']) || time() > $_SESSION['otp_expire']) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => "❌ OTP đã hết hạn. Vui lòng gửi lại."
                ]);
            }

            if (strtolower($email) != strtolower($_SESSION['otp_email'])) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => "❌ Email không trùng với email đã gửi OTP."
                ]);
            }

            if ($otpInput != $_SESSION['otp']) {
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => "❌ Mã OTP không đúng."
                ]);
            }

            // ✅ OTP đúng ➝ Lưu tài khoản
            unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_expire']);

            $this->userModel->store([
                'name' => $name,
                'email' => $email,
                'password' => $password
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

            // ✅ Kiểm tra OTP
            if (!isset($_SESSION['reset_otp']) || time() > $_SESSION['reset_expire']) {
                $toast = "❌ OTP đã hết hạn. Vui lòng gửi lại.";
            } elseif (strtolower($email) !== strtolower($_SESSION['reset_email'])) {
                $toast = "❌ Email không trùng khớp với email đã gửi OTP.";
            } elseif ($otpInput != $_SESSION['reset_otp']) {
                $toast = "❌ Mã OTP không chính xác.";
            } else {
                // ✅ OTP đúng ➝ đổi mật khẩu
                $user = $this->userModel->findByEmail($email);
                if (!$user) {
                    $toast = "❌ Email không tồn tại.";
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
}
