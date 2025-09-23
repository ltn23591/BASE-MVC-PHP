<?php

class CartController extends BaseController
{
    private $CartModel;
    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('CartModel');
        $this->CartModel = new CartModel;
    }
    public function index()
    {

        return __METHOD__;
    }
    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng',
                'redirect' => 'index.php?controllers=auth&action=login'
            ]);
            return;
        }


        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];
            $name      = $_POST['name'];
            $image     = $_POST['image'];
            $price     = (float)$_POST['price'];
            $size      = $_POST['size'];
            $userId    = (int)$_SESSION['user_id'];

            // Kiểm tra có sản phẩm có id hay không, nếu không thì trả về false
            $index = array_search($productId, array_column($_SESSION['cart'], 'id'));

            if ($index !== false) {
                $_SESSION['cart'][$index]['quantity'] += 1;
                $this->CartModel->setQuantityByComposite($userId, $productId, $size, (int)$_SESSION['cart'][$index]['quantity']);
            } else {
                $product = [
                    'id'       => $productId,
                    'name'     => $name,
                    'image'    => $image,
                    'price'    => $price,
                    'size'     => $size,
                    'quantity' => 1
                ];
                $_SESSION['cart'][] = $product;

                $this->CartModel->addOrIncrement($userId, $productId, $name, $image, $price, $size, 1);
            }

            echo json_encode([
                'status'        => 'success',
                'totalQuantity' => array_sum(array_column($_SESSION['cart'], 'quantity'))
            ]);
        } else {
            echo json_encode([
                'status'        => 'success',
                'totalQuantity' => array_sum(array_column($_SESSION['cart'], 'quantity'))
            ]);
        }
    }
    public function listCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            if (isset($_SESSION['user_id'])) {
                $rows = $this->CartModel->getByUser((int)$_SESSION['user_id']);
                $_SESSION['cart'] = $this->CartModel->rowsToSessionCart($rows);
            } else {
                $_SESSION['cart'] = [];
            }
        }

        $cart = $_SESSION['cart'];

        // Tính tổng số lượng
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;

        // Tính tổng tiền
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Trả dữ liệu sang view
        return $this->view('frontend.cart.index', [
            'cart'          => $cart,
            'totalQuantity' => $totalQuantity,
            'totalPrice'    => $totalPrice,
        ]);
    }

    public function updateQuantity()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = (int)$_POST['id'];
            $newQuantity = (int)$_POST['quantity'];
            $size        = isset($_POST['size']) ? $_POST['size'] : null;

            $matchedSize = null; // giữ size tìm được để đồng bộ DB
            $foundIndex = null;
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['id'] == $id && ($size === null || $item['size'] === $size)) {
                    $matchedSize = $item['size'];
                    $foundIndex = $index;
                    if ($newQuantity > 0) {
                        $_SESSION['cart'][$index]['quantity'] = $newQuantity;
                    } else {
                        unset($_SESSION['cart'][$index]);
                        $_SESSION['cart'] = array_values($_SESSION['cart']); // Cập nhật lại chỉ số mảng
                    }
                    break;
                }
            }

            if (isset($_SESSION['user_id']) && $matchedSize !== null) {
                $userId = (int)$_SESSION['user_id'];
                $this->CartModel->setQuantityByComposite($userId, $id, $matchedSize, $newQuantity);
            }

            // Tính lại tổng
            $totalQuantity = array_sum(array_column($_SESSION['cart'], 'quantity'));
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            echo json_encode([
                'status'        => 'success',
                'totalQuantity' => $totalQuantity,
                'totalPrice'    => $totalPrice
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Yêu cầu không hợp lệ'
            ]);
        }
        return $this->view('frontend.cart.loadTotal', [
            'totalQuantity' => $totalQuantity,
            'totalPrice'    => $totalPrice,
        ]);
    }

    public function loadTotal()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            if (isset($_SESSION['user_id'])) {
                $rows = $this->CartModel->getByUser((int)$_SESSION['user_id']);
                $_SESSION['cart'] = $this->CartModel->rowsToSessionCart($rows);
            } else {
                $_SESSION['cart'] = [];
            }
        }

        $cart = $_SESSION['cart'];

        // Tính tổng số lượng
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Render view loadTotal.php
        return $this->view('frontend.cart.loadTotal', [
            'cart'          => $cart,
            'totalQuantity' => $totalQuantity,
            'totalPrice'    => $totalPrice,
        ], false);
    }
}
