<?php

use Cloudinary\Api\Upload\UploadApi;

require_once __DIR__ . '/../config/cloudinary_config.php';

class AdminController extends BaseController
{
    private $adminModel;
    private $userModel;
    private $voucherModel;
    private $orderModel;
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

  
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

            if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
                foreach ($_POST['sizes'] as $size => $quantity) {
                    if ((int)$quantity > 0) {
                        $this->productSizeModel->store([
                            'product_id' => $productId,
                            'size' => $size,
                            'quantity' => (int)$quantity
                        ]);
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
            $id = $_POST['id'];
            $uploadedImages = [];

            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        try {
                            $uploadResult = (new UploadApi())->upload($tmpName);
                            $uploadedImages[] = $uploadResult['secure_url'];
                        } catch (Exception $e) {
                        }
                    }
                }
            } else {
                $product = $this->adminModel->findById($id);
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

        $productSizes = [];
        foreach ($sizesData as $row) {
            if (is_array($row) && isset($row['size'], $row['quantity'])) {
                $productSizes[$row['size']] = $row['quantity'];
            }
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

        // Tổng doanh thu
        $totalRevenue = $this->orderModel->getTotalRevenue('amount', "status = 'Đã giao'");

        // Doanh thu hôm nay
        $today = date('Y-m-d');
        $todayRevenue = $this->orderModel->getDayRevenue($today);

        // Doanh thu theo trạng thái
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

        // Lấy 10 đơn hàng gần nhất để hiển thị
        $recentOrders = $this->orderModel->getRecentOrdersWithUserDetails(10);

        return $this->viewAdmin('admin.components.revenue', compact(
            'totalRevenue',
            'todayRevenue',
            'statusRevenues',
            'recentOrders'
        ));
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
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

            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.user.adduser');
    }


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
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $discount = (int)($_POST['discount'] ?? 0);
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            if ($code === '' || $discount <= 0 || $start_date === '' || $end_date === '') {
                $_SESSION['toast_message'] = [
                    'type' => 'error',
                    'message' => 'Vui lòng điền đầy đủ thông tin'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }

            if (strtotime($end_date) <= strtotime($start_date)) {
                $_SESSION['toast_message'] = [
                    'type' => 'error',
                    'message' => 'Ngày kết thúc phải sau ngày bắt đầu'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }

            $this->voucherModel->createVoucher([
                'code'       => $code,
                'discount'   => $discount,
                'start_date' => $start_date,
                'end_date'   => $end_date
            ]);

            $_SESSION['toast_message'] = [
                'type' => 'success',
                'message' => 'Thêm khuyến mãi thành công'
            ];
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }
    }

    public function updateVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['toast_message'] = ['type' => 'error', 'message' => 'Không tìm thấy ID voucher'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $voucher = $this->voucherModel->findById($id);
        if (!$voucher) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'message' => 'Voucher không tồn tại'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $discount = (int)($_POST['discount'] ?? 0);
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            if (empty($code) || $discount <= 0 || empty($start_date) || empty($end_date)) {
                $_SESSION['toast_message'] = [
                    'type' => 'error',
                    'message' => 'Vui lòng điền đầy đủ thông tin'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }

            if (strtotime($end_date) <= strtotime($start_date)) {
                $_SESSION['toast_message'] = [
                    'type' => 'error',
                    'message' => 'Ngày kết thúc phải sau ngày bắt đầu'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }

            $this->voucherModel->updateVoucher($id, [
                'code'       => $code,
                'discount'   => $discount,
                'start_date' => $start_date,
                'end_date'   => $end_date
            ]);

            $_SESSION['toast_message'] = [
                'type' => 'success',
                'message' => 'Cập nhật khuyến mãi thành công'
            ];
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.voucher.updatevoucher', compact('voucher'));
    }

    public function deleteVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->voucherModel->deleteVoucher($id);
            $_SESSION['toast_message'] = ['type' => 'success', 'message' => 'Xóa thành công'];
            header('Location: index.php?controllers=auth&action=admin');
        } else {
            $_SESSION['toast_message'] = ['type' => 'error', 'message' => 'Không tìm thấy voucher'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        exit();
    }
}