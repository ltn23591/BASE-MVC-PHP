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

        // ✅ Bắt buộc đăng nhập mới được checkout
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        // ✅ Nếu chưa có giỏ hàng thì load từ DB
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            $rows = $this->cartModel->getByUser((int)$_SESSION['user_id']);
            $_SESSION['cart'] = $this->cartModel->rowsToSessionCart($rows);
        }

        $errors = [];
        $cart = $_SESSION['cart'];

        // ✅ Nếu người dùng bấm "MUA NGAY" → tạo giỏ hàng tạm từ dữ liệu POST
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

            // ✅ Cập nhật lại $cart để tính tổng chính xác
            $cart = $_SESSION['cart'];
        }

        // ✅ Tính tổng tiền
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ((float)$item['price']) * ((int)$item['quantity']);
        }
        $delivery_fee = 0;
        $amount = $subtotal + $delivery_fee;

        // ✅ Xử lý khi người dùng submit form đặt hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstName'])) {
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName  = trim($_POST['lastName'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $street    = trim($_POST['street'] ?? '');
            $city      = trim($_POST['city'] ?? '');
            $country   = trim($_POST['country'] ?? '');
            $phone     = trim($_POST['phone'] ?? '');
            $paymentMethod = $_POST['paymentMethod'] ?? 'cod';

            // ✅ Validate form
            if ($firstName === '' || $lastName === '' || $email === '' || $street === '' || $city === '' || $country === '' || $phone === '') {
                $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
            }
            if ($amount <= 0) {
                $errors[] = 'Giỏ hàng trống.';
            }

            if (empty($errors)) {
                // ✅ Lưu đơn hàng vào DB
                $this->orderModel->store([
                    'amount'        => $amount,
                    'quantity'      => array_sum(array_column($cart, 'quantity')),
                    'firstName'     => $firstName,
                    'lastName'      => $lastName,
                    'email'         => $email,
                    'street'        => $street,
                    'city'          => $city,
                    'country'       => $country,
                    'phone'         => $phone,
                    'status'        => 'Chờ xác nhận',
                    'paymentMethod' => $paymentMethod,
                    'date'          => date('Y-m-d H:i:s'),
                    'user_id'       => (int)$_SESSION['user_id'],
                ]);

                // ✅ Xóa giỏ hàng sau khi đặt hàng
                if (isset($_POST['buy_now'])) {
                    // Nếu là "MUA NGAY" thì chỉ xóa giỏ hàng tạm
                    unset($_SESSION['cart']);
                } else {
                    // Nếu đặt hàng từ giỏ hàng → xóa toàn bộ và DB
                    $_SESSION['cart'] = [];
                    if (method_exists($this->cartModel, 'clearByUser')) {
                        $this->cartModel->clearByUser((int)$_SESSION['user_id']);
                    }
                }

                // ✅ Quay về trang chủ sau khi đặt hàng thành công
                header('Location: index.php?controllers=order&action=index');

                exit();
            }
        }

        // ✅ Render view checkout
        return $this->view('frontend.checkout.index', [
            'errors'       => $errors,
            'subtotal'     => $subtotal,
            'delivery_fee' => $delivery_fee,
            'amount'       => $amount,
        ]);
    }
}
