<?php

use Cloudinary\Api\Upload\UploadApi;

class RatingController extends BaseController
{
    private $ratingModel;
    private $productModel;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;

        $this->loadModel('RatingModel');
        $this->ratingModel = new RatingModel;
    }

    public function index()
    {
        $id = $_GET['id'];
        $getProduct = $this->productModel->findById((int)$id);

        // Giải mã JSON ảnh
        if (!empty($getProduct['image'])) {
            $getProduct['image'] = json_decode($getProduct['image'], true);
        }
        if (!$getProduct) {
            echo "<h3>Sản phẩm không tồn tại!</h3>";
            exit;
        }
        // Lấy các đánh giá đã có
        $reviews = $this->ratingModel->getByProductId($id);

        return $this->view('frontend.feedback.index', [
            'getProduct' => $getProduct,
            'reviews' => $reviews
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?controllers=auth&action=login');
                exit();
            }

            $data = [
                'product_id' => $_POST['product_id'],
                'user_id'    => $_SESSION['user_id'],
                'rating'     => $_POST['rating'],
                'comment'    => $_POST['comment'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->ratingModel->store($data);

            // Sau khi lưu, chuyển hướng về trang chi tiết sản phẩm
            header('Location: index.php?controllers=product&action=detail&id=' . $_POST['product_id']);
            exit();
        }
    }

    public function show() {}
}