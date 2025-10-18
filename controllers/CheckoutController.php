<?php

use LDAP\Result;

class CheckoutController extends BaseController
{
    private $orderModel;
    private $cartModel;
    private $orderDetailModel;
    private $productModel;
    private $productSizeModel;
    private $userModel;

    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->loadModel('CartModel');
        $this->loadModel('OrderDetailModel');
        $this->loadModel('ProductModel');
        $this->loadModel('ProductSizeModel');
        $this->loadModel('UserModel');


        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->cartModel  = new CartModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->productModel = new ProductModel();
        $this->productSizeModel = new ProductSizeModel();
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now'])) {
            $productId = (int)$_POST['product_id'];
            $name      = $_POST['name'];
            $image     = $_POST['image'];
            $price     = (float)$_POST['price'];
            $size      = $_POST['size'];
            $quantity  = (int)$_POST['quantity'];

            $_SESSION['cart'] = [[
                'id'       => $productId,
                'name'     => $name,
                'image'    => $image,
                'price'    => $price,
                'size'     => $size,
                'quantity' => $quantity
            ]];

            $cart = $_SESSION['cart'];
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ((float)$item['price']) * ((int)$item['quantity']);
        }
        $delivery_fee = 0;
        $amount = $subtotal + $delivery_fee;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstName'])) {
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName  = trim($_POST['lastName'] ?? '');
            $street    = trim($_POST['street'] ?? '');
            $city      = trim($_POST['city'] ?? '');
            $country   = trim($_POST['country'] ?? '');
            $phone     = trim($_POST['phone'] ?? '');
            // $paymentMethod = $_POST['paymentMethod'] ?? 'cod';
            $discount = $_SESSION['discount'] ?? 0;

            if ($firstName === '' || $lastName === '' || $street === '' || $city === '' || $country === '' || $phone === '') {
                $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            if ($amount <= 0) {
                $errors[] = 'Giỏ hàng trống.';
            }
            if ($discount > 0) {
                $amount -= $discount;
            }

            if (empty($errors)) {
                //  Lưu đơn hàng và lấy ID đơn hàng
                $orderId = $this->orderModel->store([
                    'amount'        => $amount,
                    'quantity'      => array_sum(array_column($cart, 'quantity')),
                    'firstName'     => $firstName,
                    'lastName'      => $lastName,
                    'street'        => $street,
                    'city'          => $city,
                    'country'       => $country,
                    'phone'         => $phone,
                    'status'        => 'Chờ xác nhận',
                    // 'paymentMethod' => $paymentMethod,
                    'date'          => date('Y-m-d H:i:s'),
                    'user_id'       => (int)$_SESSION['user_id'],
                ]);

                //  Lưu từng sản phẩm vào bảng order_items
                foreach ($cart as $item) {
                    $this->orderDetailModel->store([
                        'order_id'   => $orderId,
                        'product_id' => (int)$item['id'],
                        'quantity'   => (int)$item['quantity'],
                        'price'      => (float)$item['price'],
                        'size'       => $item['size'],
                    ]);

                    // Trừ số lượng tồn kho
                    $this->productSizeModel->decreaseStock(
                        (int)$item['id'],
                        $item['size'],
                        (int)$item['quantity']
                    );
                }

                $this->userModel->totalSpent((int)$_SESSION['user_id'], $amount);
                //  Xóa giỏ hàng
                if (isset($_POST['buy_now'])) {
                    unset($_SESSION['cart']);
                } else {
                    $_SESSION['cart'] = [];
                    if (method_exists($this->cartModel, 'clearByUser')) {
                        $this->cartModel->clearByUser((int)$_SESSION['user_id']);
                    }
                }

                header('Location: index.php?controllers=order&action=index');
                exit();
            }
        }

        return $this->view('frontend.checkout.index', [
            'errors'       => $errors,
            'subtotal'     => $subtotal,
            'delivery_fee' => $delivery_fee,
            'amount'       => $amount,
            'cart' => $cart
        ]);
    }
}
