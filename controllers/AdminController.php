<?php
require 'cloudinary_config.php';
class AdminController extends BaseController
{
    private $adminModel;
    private $userModel;

    public function __construct()
    {
        $this->loadModel('AdminModel');
        $this->adminModel = new AdminModel;

        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    /** ---------------- SẢN PHẨM ---------------- */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadedImages = [];
            $uploadDir = 'public/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Upload ảnh
            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = $targetPath;
                    }
                }
            }

            // Dữ liệu sản phẩm
            $data = [
                'name'        => $_POST['name'],
                'description' => $_POST['description'],
                'price'       => $_POST['price'],
                'image'       => json_encode($uploadedImages),
                'category'    => $_POST['category'],
                'subCategory' => $_POST['subCategory'],
                'sizes'       => json_encode($_POST['sizes'] ?? []),
                'bestseller'  => isset($_POST['bestseller']) ? 1 : 0,
                'date'        => time()
            ];

            $this->adminModel->store($data);
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.add');
    }

    public function list()
    {
        $products = $this->adminModel->getAll(['*'], ['column' => 'id', 'order' => 'desc']);
        return $this->viewAdmin('admin.components.list', compact('products'));
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id'];
            $uploadedImages = [];
            $uploadDir   = 'public/uploads/';

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

<<<<<<< HEAD

        $this->loadModel('UserModel');
        $user = new UserModel();
        $getEmailUser = $user->getAll(['*']);


        // Gắn email vào từng đơn hàng
        foreach ($orders as &$order) {
            foreach ($getEmailUser as $u) {
                if ($order['user_id'] == $u['id']) {
                    $order['email'] = $u['email'];
                    break;
=======
            // Có upload ảnh mới không
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName   = time() . '_' . basename($_FILES['images']['name'][$key]);
                        $targetPath = $uploadDir . $fileName;
                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $uploadedImages[] = $targetPath;
                        }
                    }
>>>>>>> 004d9bde9d56f5586174913d9737aeed393c6cce
                }
            } else {
                $product       = $this->adminModel->findById($id);
                $uploadedImages = json_decode($product['image'], true);
            }

            $data = [
                'name'        => $_POST['name'],
                'description' => $_POST['description'],
                'price'       => $_POST['price'],
                'image'       => json_encode($uploadedImages),
                'category'    => $_POST['category'],
                'subCategory' => $_POST['subCategory'],
                'sizes'       => json_encode($_POST['sizes'] ?? []),
                'bestseller'  => isset($_POST['bestseller']) ? 1 : 0,
            ];

            $this->adminModel->updateData($id, $data);
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controllers=auth&action=list');
            exit();
        }

        $product = $this->adminModel->findById($id);
        return $this->viewAdmin('admin.components.update', compact('product'));
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->adminModel->destroy($id);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    /** ---------------- ĐƠN HÀNG ---------------- */
    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $this->loadModel('OrderModel');
        $orderModel = new OrderModel();
        $orders     = $orderModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);

        $users      = $this->userModel->getAll(['*']);

        // Gắn email user vào order
        foreach ($orders as &$order) {
            foreach ($users as $u) {
                if ($order['user_id'] == $u['id']) {
                    $order['email'] = $u['email'];
                    break;
                }
            }
        }

        return $this->viewAdmin('admin.components.orders', compact('orders', 'users'));
    }

    public function updateOrderStatus()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int)($_POST['order_id'] ?? 0);
            $status  = $_POST['status'] ?? '';
            if ($orderId > 0 && $status !== '') {
                $this->loadModel('OrderModel');
                $orderModel = new OrderModel();
                $orderModel->updateData($orderId, ['status' => $status]);
            }
        }
        header('Location: index.php?controllers=auth&action=admin');
        exit();
    }

    /** ---------------- NGƯỜI DÙNG ---------------- */
    public function users()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $users = $this->userModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);
        return $this->viewAdmin('admin.components.user.list', compact('users'));
    }

    public function adduser()
    {
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Email không hợp lệ']);
            exit;
        }

            $this->userModel->store([
                'name'       => $name,
                'email'      => $email,
                'password'   => $password,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Đặt flag báo thành công
            $success = true;
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.user.adduser');
    }
<<<<<<< HEAD
=======


>>>>>>> 004d9bde9d56f5586174913d9737aeed393c6cce
}
