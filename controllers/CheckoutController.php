<?php

class CheckoutController extends BaseController
{
    private $orderModel;
    private $cartModel;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->loadModel('CartModel');
        $this->orderModel = new OrderModel();
        $this->cartModel  = new CartModel();
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

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            $rows = $this->cartModel->getByUser((int)$_SESSION['user_id']);
            $_SESSION['cart'] = $this->cartModel->rowsToSessionCart($rows);
        }

        $errors = [];
        $cart = $_SESSION['cart'];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ((float)$item['price']) * ((int)$item['quantity']);
        }
        $delivery_fee = 0;
        $amount = $subtotal + $delivery_fee;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName  = trim($_POST['lastName'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $street    = trim($_POST['street'] ?? '');
            $city      = trim($_POST['city'] ?? '');
            $country   = trim($_POST['country'] ?? '');
            $phone     = trim($_POST['phone'] ?? '');
            $paymentMethod = $_POST['paymentMethod'] ?? 'cod';

            if ($firstName === '' || $lastName === '' || $email === '' || $street === '' || $city === '' || $country === '' || $phone === '') {
                $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            if ($amount <= 0) {
                $errors[] = 'Giỏ hàng trống.';
            }

            if (empty($errors)) {
                $this->orderModel->store([
                    'amount'        => $amount,
                    'firstName'     => $firstName,
                    'lastName'      => $lastName,
                    'email'         => $email,
                    'street'        => $street,
                    'city'          => $city,
                    'country'       => $country,
                    'phone'         => $phone,
                    'status'        => 'pending',
                    'paymentMethod' => $paymentMethod,
                    'date'          => date('Y-m-d H:i:s'),
                    'user_id'       => (int)$_SESSION['user_id'],
                ]);

                // Xóa sạch giỏ hàng
                $_SESSION['cart'] = [];
                // xóa sạch trên đb
                if (method_exists($this->cartModel, 'clearByUser')) {
                    $this->cartModel->clearByUser((int)$_SESSION['user_id']);
                }

                header('Location: index.php');
                exit();
            }
        }

        return $this->view('frontend.checkout.index', [
            'errors'       => $errors,
            'subtotal'     => $subtotal,
            'delivery_fee' => $delivery_fee,
            'amount'       => $amount,
        ]);
    }
}
