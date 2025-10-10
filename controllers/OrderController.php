<?php

class OrderController extends BaseController
{
    private $orderModel;
    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
    }
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $orders = $this->orderModel->getByUser((int)$_SESSION['user_id']);

        return $this->view('frontend.orders.index', [
            'orders' => $orders,
        ]);
    }
}