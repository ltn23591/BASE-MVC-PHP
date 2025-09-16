<?php
session_start();

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }
    public function admin()
    {
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        return $this->view('admin.index', [
            'pageTitle' => 'Trang quản trị'
        ], false);
    }
    // Trang đăng nhập
    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];
                if ($email === 'admin@gmail.com' && $password === '123') {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $email;

                    header('Location: index.php?controllers=auth&action=admin');
                    exit();
                }
                $user = $this->userModel->findByEmail($email);

                if (!$user) {
                    throw new Exception("Tài khoản không tồn tại!");
                }

                if (!password_verify($password, $user['password'])) {
                    throw new Exception("Sai mật khẩu!");
                }

                // Đăng nhập thành công
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: index.php');
                exit();
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đăng nhập',
            'error' => $error ?? null
        ]);
    }
    // Trang đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->findByEmail($email)) {
                $error = "Email đã tồn tại!";
            } else {
                $this->userModel->store([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]);
                header('Location: index.php?controllers=auth&action=login');
                exit();
            }
        }

        return $this->view('frontend.auth.login', [
            'pageTitle' => 'Đăng ký',
            'error' => $error ?? null
        ]);
    }


    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header('Location: index.php?controllers=auth&action=login');
        exit();
    }
}
