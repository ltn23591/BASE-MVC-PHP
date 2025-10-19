<?php

class OrderController extends BaseController
{
    private $orderModel;
    private $orderDetailModel;
    private $productSizeModel;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->loadModel('OrderDetailModel');
        $this->loadModel('ProductSizeModel');

        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->productSizeModel = new ProductSizeModel();
    }

    // Trang danh sách đơn hàng của user
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $orders = $this->orderModel->getByUser((int)$_SESSION['user_id']);
        return $this->view('frontend.orders.index', compact('orders'));
    }

    // Hủy đơn hàng
    public function cancel()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int)($_POST['order_id'] ?? 0);
            $userId = (int)$_SESSION['user_id'];

            $order = $this->orderModel->findById($orderId);

            // Kiểm tra quyền
            if (!$order || $order['user_id'] != $userId) {
                $_SESSION['toast_message'] = [
                    'type' => 'error',
                    'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy!'
                ];
                header('Location: index.php?controllers=order&action=index');
                exit();
            }

            // Không cho hủy nếu đơn đang giao hoặc đã giao
            if (in_array($order['status'], ['Đang giao', 'Đã giao'])) {
                $_SESSION['toast_message'] = [
                    'type' => 'warning',
                    'message' => 'Không thể hủy đơn hàng này vì đang giao hoặc đã giao!'
                ];
                header('Location: index.php?controllers=order&action=index');
                exit();
            }

            // Lấy danh sách sản phẩm trong đơn
            $items = $this->orderDetailModel->getByOrderId($orderId);

            // Cộng lại tồn kho
            foreach ($items as $item) {
                $this->productSizeModel->increaseStock(
                    (int)$item['product_id'],
                    $item['size'],
                    (int)$item['quantity']
                );
            }

            // Cập nhật trạng thái đơn hàng
            $this->orderModel->updateData($orderId, ['status' => 'Đã hủy']);

            $_SESSION['toast_message'] = [
                'type' => 'success',
                'message' => 'Hủy đơn hàng thành công!'
            ];
            header('Location: index.php?controllers=order&action=index');
            exit();
        }

        header('Location: index.php?controllers=order&action=index');
        exit();
    }
}