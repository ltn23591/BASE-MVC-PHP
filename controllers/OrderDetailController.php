<?php
class OrderDetailController extends BaseController
{
    private $orderModel;
    private $orderDetailModel;
    private $ratingModel;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->loadModel('OrderDetailModel');
 

        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();

    }

    public function detail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }
        $userId = $_SESSION['user_id'];

        $orderId = $_GET['id']; // Lấy id đơn hàng từ URL

        $order = $this->orderModel->findById($orderId);


        if (!$order || $order['user_id'] != $userId) {

            die('You do not have permission to view this order.');
        }

        $items = $this->orderDetailModel->getByOrderId($orderId);




        return $this->view('frontend.order_detail.index', [
            'order' => $order,
            'items' => $items
        ]);
    }
}