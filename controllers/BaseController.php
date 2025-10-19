<?php
class BaseController
{
    const VIEW_FOLDER_NAME = 'views';
    const MODEL_FOLDER_NAME = 'models';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkRememberMe();
    }

    /**
     * Kiểm tra cookie "remember_me" để tự động đăng nhập cho người dùng.
     */
    private function checkRememberMe()
    {
        // Nếu người dùng đã đăng nhập qua session, không cần làm gì cả.
        if (isset($_SESSION['user_id'])) {
            return;
        }

        // Kiểm tra sự tồn tại của cookie 'remember_me'
        if (isset($_COOKIE['remember_me'])) {
            list($userId, $token) = explode(':', $_COOKIE['remember_me'], 2);

            if (!empty($userId) && !empty($token)) {
                $this->loadModel('UserModel');
                $userModel = new UserModel();
                $user = $userModel->findById((int)$userId);

                // Nếu tìm thấy user và token trong cookie khớp với token trong DB
                if ($user && hash_equals((string)$user['remember_token'], $token)) {
                    // Token hợp lệ, tiến hành đăng nhập cho người dùng
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                } else {
                    // Token không hợp lệ, xóa cookie để tránh kiểm tra lại
                    setcookie('remember_me', '', time() - 3600, '/');
                }
            }
        }
    }

    protected function view($viewPath, array $data = [], bool $withLayout = true)
    {

        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath =  self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        if ($withLayout) {
            include __DIR__ . '/../views/frontend/layouts/header.php';
            include __DIR__ . '/../views/frontend/layouts/navbar.php';
            require($viewPath);
            include __DIR__ . '/../views/frontend/layouts/footer.php';
        } else {
            require($viewPath);
        }
    }

    // Hàm này dành cho admin nhằm để ẩn header và footer của client
    protected function viewAdmin($viewPath, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        require($viewPath);
    }

    protected function loadModel($modelPath)
    {
        $modelPath = self::MODEL_FOLDER_NAME . '/' . str_replace('.', '/', $modelPath) . '.php';
        require($modelPath);
    }
}
