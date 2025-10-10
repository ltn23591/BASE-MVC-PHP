<?php

use Cloudinary\Api\Upload\UploadApi;
use LDAP\Result;

require_once __DIR__ . '/../config/cloudinary_config.php';
class AdminController extends BaseController
{
    private $adminModel;
    private $userModel;
    private $voucherModel;
    private $orderModel; // Thêm orderModel vào đây
    private $productSizeModel;

    public function __construct()
    {
        $this->loadModel('AdminModel');
        $this->adminModel = new AdminModel;

        $this->loadModel('UserModel');
        $this->userModel = new UserModel;

        $this->loadModel('VoucherModel');
        $this->voucherModel = new VoucherModel;

        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;

        $this->loadModel('ProductSizeModel');
        $this->productSizeModel = new ProductSizeModel;
    }

    /** ---------------- SẢN PHẨM ---------------- */
    #region Product
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Upload ảnh lên Cloudinary
            require_once __DIR__ . '/../config/cloudinary_config.php';
            $uploadedImages = [];
            if (isset($_FILES['images'])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        try {
                            $uploadResult = (new UploadApi())->upload($tmpName);
                            $uploadedImages[] = $uploadResult['secure_url'];
                        } catch (Exception $e) {
                            die("Error uploading image: " . $e->getMessage());
                        }
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
                'bestseller'  => isset($_POST['bestseller']) ? 1 : 0,
                'date'        => time()
            ];
            $productId = $this->adminModel->store($data);

            // Lưu số lượng cho từng size
            if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
                foreach ($_POST['sizes'] as $size => $quantity) {
                    if ((int)$quantity > 0) {
                        $dataSize = [
                            'product_id' => $productId,
                            'size' => $size,
                            'quantity' => (int)$quantity
                        ];
                        $this->productSizeModel->store($dataSize);
                    }
                }
            }



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
            $id             = $_POST['id'];
            $uploadedImages = [];
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        try {
                            $uploadResult = (new UploadApi())->upload($tmpName);
                            $uploadedImages[] = $uploadResult['secure_url'];
                        } catch (Exception $e) {
                            // 
                        }
                    }
                }
            } else {

                $product        = $this->adminModel->findById($id);
                $uploadedImages = json_decode($product['image'], true);
            }

            $data = [
                'name'        => $_POST['name'],
                'description' => $_POST['description'],
                'price'       => $_POST['price'],
                'image'       => json_encode($uploadedImages),
                'category'    => $_POST['category'],
                'subCategory' => $_POST['subCategory'],
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
        $sizesData = $this->productSizeModel->getByProductId($id);

        // Chuyển đổi dữ liệu size để dễ dùng trong view
        $productSizes = [];
        foreach ($sizesData as $row) {
            $productSizes[$row['size']] = $row['quantity'];
        }

        return $this->viewAdmin('admin.components.update', compact('product', 'productSizes'));
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

    /** ---------------- DOANH THU ---------------- */
    #region Revenue
    public function revenue()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        // Lấy tổng doanh thu từ các đơn hàng đã giao
        $totalRevenue = $this->orderModel->getTotalRevenue('amount', "status = 'Đã giao'");

        // Lấy doanh thu theo từng trạng thái và chuẩn bị dữ liệu
        $revenueByStatusRaw = $this->orderModel->getRevenueByStatus();
        $statusRevenues = [
            'Chờ xác nhận' => 0,
            'Đang giao' => 0,
            'Đã hủy' => 0,
        ];
        foreach ($revenueByStatusRaw as $row) {
            if (array_key_exists($row['status'], $statusRevenues)) {
                $statusRevenues[$row['status']] = (float)$row['total_revenue'];
            }
        }

        $monthlyData = $this->orderModel->getMonthlyRevenue();

        // Chuẩn bị dữ liệu cho biểu đồ
        $chartData = [
            'categories' => [],
            'series' => []
        ];
        foreach ($monthlyData as $data) {
            $chartData['categories'][] = "Tháng {$data['month']}/{$data['year']}";
            $chartData['series'][] = (float)$data['total_revenue'];
        }
        return $this->viewAdmin('admin.components.revenue', compact('chartData', 'totalRevenue', 'statusRevenues'));
    }

    /** ---------------- ĐƠN HÀNG ---------------- */
    #region Order
    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $orders = $this->orderModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);

        $users = $this->userModel->getAll(['*']);

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
                $this->orderModel->updateData($orderId, ['status' => $status]);
            }
        }
        header('Location: index.php?controllers=auth&action=admin');
        exit();
    }

    /** ---------------- NGƯỜI DÙNG ---------------- */
    #region User
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

            $success = true;
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.user.adduser');
    }

    /** ---------------- VOUCHER ---------------- */
    #region Voucher
    public function listVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $vouchers = $this->voucherModel->getAll(['*'], ['column' => 'id', 'order' => 'desc'], 100);

        return $this->viewAdmin('admin.components.voucher.listvoucher', compact('vouchers'));
    }

    public function addVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        return $this->viewAdmin('admin.components.voucher.addvoucher');
    }
    public function saveVoucher()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $code = $_POST['code'] ?? '';
            $discount = $_POST['discount'] ?? 0;
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';


            // Kiểm tra dữ liệu cơ bản
            if (empty($code) || empty($discount) || empty($start_date) || empty($end_date)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin voucher!";
                header("Location: index.php?controller=admin&action=addVoucher");
                exit();
            }

            // Chuẩn bị dữ liệu để lưu
            $data = [
                'code' => $code,
                'discount' => $discount,
                'start_date' => $start_date,
                'end_date' => $end_date,

            ];


            $this->voucherModel->createVoucher($data);

            // Kiểm tra kết quả
            $_SESSION['success'] = "Thêm voucher thành công!";
            header("Location: index.php?controllers=admin&action=listVoucher");
            exit();
        } else {
            // Nếu không phải POST thì quay lại form
            header("Location: index.php?controllers=admin&action=addVoucher");
            exit();
        }
    }
}