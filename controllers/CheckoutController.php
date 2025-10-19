<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

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

                // Gửi email xác nhận đơn hàng
                $user = $this->userModel->findById((int)$_SESSION['user_id']);
                if ($user) {
                    $orderDataForEmail = [
                        'id' => $orderId,
                        'amount' => $amount,
                        'date' => date('Y-m-d H:i:s')
                    ];
                    // Gọi phương thức gửi email ngay trong class này
                    $this->sendOrderConfirmationEmail($user['email'], $user['name'], $orderDataForEmail, $cart);
                }
                // Kết thúc phần gửi email


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


    private function sendOrderConfirmationEmail($customerEmail, $customerName, $order, $orderItems)
    {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình Server SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ltn23591@gmail.com';
            $mail->Password   = 'gmpikbphawtpxyfn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            // Người gửi và người nhận
            $mail->setFrom('your_email@gmail.com', 'Fashion Store');
            $mail->addAddress($customerEmail, $customerName);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Xac nhan don hang #' . $order['id'];

            // Tạo nội dung HTML cho email
            $body = "<h1>Cam on ban da dat hang tai Cua Hang!</h1>";
            $body .= "<p>Xin chao {$customerName},</p>";
            $body .= "<p>Chung toi da nhan duoc don hang cua ban va dang xu ly. Duoi day la chi tiet don hang:</p>";
            $body .= "<h3>Thong tin don hang</h3>";
            $body .= "<ul>";
            $body .= "<li><strong>Ma don hang:</strong> #{$order['id']}</li>";
            $body .= "<li><strong>Ngay dat:</strong> " . date('d/m/Y H:i:s', strtotime($order['date'])) . "</li>";
            $body .= "<li><strong>Tong tien:</strong> " . number_format($order['amount'], 0, ',', '.') . " VND</li>";
            $body .= "</ul>";
            $body .= "<h3>Chi tiet san pham</h3>";
            $body .= "<table border='1' cellpadding='10' cellspacing='0' style='width:100%; border-collapse: collapse;'>
                        <thead>
                            <tr style='background-color: #f2f2f2;'>
                                <th>San pham</th>
                                <th>Size</th>
                                <th>So luong</th>
                                <th>Don gia</th>
                                <th>Thanh tien</th>
                            </tr>
                        </thead>
                        <tbody>";

            foreach ($orderItems as $item) {
                $body .= "<tr>
                            <td>" . htmlspecialchars($item['name']) . "</td>
                            <td style='text-align:center;'>" . htmlspecialchars($item['size']) . "</td>
                            <td style='text-align:center;'>{$item['quantity']}</td>
                            <td style='text-align:right;'>" . number_format($item['price'], 0, ',', '.') . " VND</td>
                            <td style='text-align:right;'>" . number_format($item['price'] * $item['quantity'], 0, ',', '.') . " VND</td>
                          </tr>";
            }

            $body .= "</tbody></table>";
            $body .= "<p>Chung toi se thong bao cho ban khi don hang duoc van chuyen.</p>";
            $body .= "<p>Tran trong,<br>Doi ngu Cua Hang</p>";

            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Ghi lại lỗi để debug, không hiển thị cho người dùng
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}