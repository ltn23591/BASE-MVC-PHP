<?php
class OrderDetailController extends BaseController
{
    private $orderModel;
    private $orderDetailModel;

    public function __construct()
    {
        // Gọi model đơn hàng
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel();

        // Gọi model chi tiết sản phẩm của đơn hàng
        $this->loadModel('OrderDetailModel');
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function detail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $orderId = $_GET['id']; // Lấy id đơn hàng từ URL

        $order = $this->orderModel->findById($orderId);

        $items = $this->orderDetailModel->getByOrderId($orderId);

        return $this->view('frontend.order_detail.index', [
            'order' => $order,
            'items' => $items
        ]);
    }
}