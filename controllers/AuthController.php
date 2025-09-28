<?php

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
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
                    $toast = "Tài khoản không tồn tại!";
                    return $this->view('frontend.auth.login', [
                        'pageTitle' => 'Đăng nhập',
                        'toast' => $toast
                    ]);
                }

                // Kiểm tra mật khẩu
                if (!password_verify($password, $user['password'])) {
                    $toast = "Sai mật khẩu!";
                    return $this->view('frontend.auth.login', [
                        'pageTitle' => 'Đăng nhập',
                        'toast' => $toast
                    ]);
                }

                // ✅ Đăng nhập thành công
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Đồng bộ giỏ hàng từ DB -> session
                $this->loadModel('CartModel');
                $cartModel = new CartModel();
                $rows = $cartModel->getByUser((int)$user['id']);
                $_SESSION['cart'] = $cartModel->rowsToSessionCart($rows);

                $toast = "Đăng nhập thành công! Chào mừng " . $user['name'];
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

    // Đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->findByEmail($email)) {
                $toast = "Email đã tồn tại!";
                return $this->view('frontend.auth.login', [
                    'pageTitle' => 'Đăng ký',
                    'toast' => $toast
                ]);
            } else {
                $this->userModel->store([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]);
                $toast = 'Đăng ký thành công! Vui lòng đăng nhập.';
                header('Location: index.php?controllers=auth&action=login');
                exit();
            }
        }

        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đăng ký',
            'toast' => $toast ?? null
        ]);
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header('Location: index.php?controllers=auth&action=login');
        exit();
    }
    // đổi mật khẩu
    // Quên mật khẩu / đổi mật khẩu
public function resetPassword()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        // Kiểm tra email có trong database không
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $toast = "Email không tồn tại!";
        } else {
            if (!empty($newPassword)) {
                // Nếu có mật khẩu mới, update luôn
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userModel->update($user['id'], ['password' => $hashedPassword],'id');
                $toast = "Đổi mật khẩu thành công! Vui lòng đăng nhập.";
            } else {
                // Chỉ nhập email, hiển thị form nhập mật khẩu mới
                $toast = "Email hợp lệ. Vui lòng nhập mật khẩu mới.";
            }
        }

        // Hiển thị view với state reset và truyền thông tin user
        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đổi mật khẩu',
            'toast' => $toast,
            'state' => 'reset',
            'email' => $email,
            'showNewPassword' => !empty($user) && empty($newPassword) ? true : false
        ]);
    } else {
        // GET → chỉ hiển thị form email
        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Quên Mật Khẩu',
            'state' => 'reset'
        ]);
    }
}
}
