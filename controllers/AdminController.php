<?php
require 'cloudinary_config.php';
class AdminController extends BaseController
{
    private $adminModel;
    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('AdminModel');
        $this->adminModel = new AdminModel;
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadedImages = [];
            $uploadDir = 'public/uploads/';

            // Nếu chưa có thư mục thì tạo
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = $targetPath;
                    }
                }
            }

            // Lấy dữ liệu còn lại từ form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $subCategory = $_POST['subCategory'];
            $sizes = json_encode($_POST['sizes'] ?? []);
            $bestseller = isset($_POST['bestseller']) ? 1 : 0;

            // Gọi model để lưu DB
            $this->adminModel->store([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => json_encode($uploadedImages),
                'category' => $category,
                'subCategory' => $subCategory,
                'sizes' => $sizes,
                'bestseller' => $bestseller,
                'date' => time()
            ]);
            // Quay về danh sách
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.add');
    }

    public function list()
    {
        $products = $this->adminModel->getAll(['*'], ['column' => 'id', 'order' => 'desc']);
        return $this->viewAdmin('admin.components.list', [
            'products' => $products
        ]);
    }

    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $this->loadModel('OrderModel');
        $orderModel = new OrderModel();
        $orders = $orderModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);


        $this->loadModel('UserModel');
        $user = new UserModel();
        $getEmailUser = $user->getAll(['*']);


        // Gắn email vào từng đơn hàng
        foreach ($orders as &$order) {
            foreach ($getEmailUser as $u) {
                if ($order['user_id'] == $u['id']) {
                    $order['email'] = $u['email'];
                    break;
                }
            }
        }
        return $this->viewAdmin('admin.components.orders', [
            'orders' => $orders,
            'getEmailUser' => $getEmailUser
        ]);
    }
    public function updateOrderStatus()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status  = $_POST['status'] ?? '';
        if ($orderId > 0 && $status !== '') {
            $this->loadModel('OrderModel');
            $orderModel = new OrderModel();
            $orderModel->updateData($orderId, ['status' => $status]);
        }
        header('Location: index.php?controllers=auth&action=admin');
        exit();
    }
    public function delete()
    {
        $id = $_GET['id'];

        if ($id) {
            $this->adminModel->destroy($id);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
    public function users()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $this->loadModel('UserModel');
        $userModel = new UserModel();
        $users = $userModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);


        return $this->viewAdmin('admin.components.user.list', [
            'users' => $users
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $subCategory = $_POST['subCategory'];
            $sizes = json_encode($_POST['sizes'] ?? []);
            $bestseller = isset($_POST['bestseller']) ? 1 : 0;

            // Xử lý upload ảnh mới (nếu có)
            $uploadedImages = [];
            $uploadDir = 'public/uploads/';


            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                        $targetPath = $uploadDir . $fileName;
                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $uploadedImages[] = $targetPath;
                        }
                    }
                }
            } else {
                // Nếu không upload ảnh mới, giữ ảnh cũ
                $product = $this->adminModel->findById($id);
                $uploadedImages = json_decode($product['image'], true);
            }

            //  Cập nhật dữ liệu
            $this->adminModel->updateData($id, [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => json_encode($uploadedImages),
                'category' => $category,
                'subCategory' => $subCategory,
                'sizes' => $sizes,
                'bestseller' => $bestseller,
            ]);

            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        // ✅ Lấy sản phẩm để hiển thị vào form sửa
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controllers=admin&action=list');
            exit();
        }

        $product = $this->adminModel->findById($id);
        return $this->viewAdmin('admin.components.update', [
            'product' => $product
        ]);
    }
}
