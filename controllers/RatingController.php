<?php

use Cloudinary\Api\Upload\UploadApi;

class RatingController extends BaseController
{
    private $ratingModel;
    private $orderModel;
    private $productModel;

    public function __construct()
    {
        $this->loadModel('RatingModel');
        $this->ratingModel = new RatingModel();

        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel();

        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    // Hiển thị trang đánh giá
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit;
        }

        $productId = $_GET['id'] ?? 0;
        $getProduct = $this->productModel->findById($productId);
        $reviews = $this->ratingModel->getByProductId($productId);
        if (!empty($getProduct['image'])) {
            $getProduct['image'] = json_decode($getProduct['image'], true);
        }
        return $this->view('frontend.feedback.index', compact('getProduct', 'reviews'));
    }

    // Lưu đánh giá
    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['toast_error'] = 'Vui lòng đăng nhập để đánh giá.';
            header('Location: index.php?controllers=auth&action=login');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        // Tạo URL để quay lại trang đánh giá
        $redirectUrl = "index.php?controllers=rating&action=index&id=" . $productId;

        if ($productId <= 0 || $rating <= 0 || $rating > 5) {
            $_SESSION['toast_error'] = 'Dữ liệu đánh giá không hợp lệ. Vui lòng chọn số sao.';
            header('Location: ' . $redirectUrl);
            exit;
        }

        // Kiểm tra user có đơn hàng "Đã giao" chứa sản phẩm này không
        $hasDelivered = $this->orderModel->hasDeliveredProduct($userId, $productId);

        if (!$hasDelivered) {
            $_SESSION['toast_error'] = 'Bạn chỉ có thể đánh giá sản phẩm sau khi đơn hàng đã giao thành công.';
            header('Location: ' . $redirectUrl);
            exit;
        }

        //  Kiểm tra user đã đánh giá sản phẩm này chưa
        if ($this->ratingModel->hasUserRated($userId, $productId)) {
            $_SESSION['toast_error'] = 'Bạn đã đánh giá sản phẩm này rồi!';
            header('Location: ' . $redirectUrl);
            exit;
        }

        //  3. Lưu đánh giá
        $this->ratingModel->store([
            'user_id'    => $userId,
            'product_id' => $productId,
            'rating'     => $rating,
            'comment'    => $comment,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $_SESSION['toast_success'] = 'Cảm ơn bạn đã đánh giá sản phẩm!';
        header('Location: index.php?controllers=order&action=index');
        exit;
    }
}