<?php
class FavoriteController extends BaseController
{
    private $favoriteModel;

    public function __construct()
    {
        $this->loadModel('FavoriteModel');
        $this->favoriteModel = new FavoriteModel();
    }

    // Thêm / xóa sản phẩm yêu thích
    public function toggle()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để thêm vào yêu thích']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];

        $isFav = $this->favoriteModel->isFavorite($userId, $productId);

        if ($isFav) {
            $this->favoriteModel->removeFavorite($userId, $productId);
            echo json_encode(['status' => 'removed']);
        } else {
            $this->favoriteModel->addFavorite($userId, $productId);
            echo json_encode(['status' => 'added']);
        }
    }

    // Danh sách yêu thích của user
    public function list()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            // Trả về view với thông báo chưa đăng nhập
            return $this->view('frontend.favorites.index', [
                'favorites' => [],
                'title' => 'Sản phẩm yêu thích',
                'isLoggedIn' => false
            ]);
        }

        $userId = $_SESSION['user_id'];
        
        // Lấy danh sách sản phẩm yêu thích
        $favorites = $this->favoriteModel->getFavoritesByUser($userId);
        
        // Xử lý hình ảnh nếu cần
        foreach ($favorites as &$product) {
            if (!empty($product['image'])) {
                $product['image'] = json_decode($product['image'], true);
            }
        }

        return $this->view('frontend.favorites.index', [
            'favorites' => $favorites,
            'title' => 'Sản phẩm yêu thích',
            'isLoggedIn' => true
        ]);
    }

    public function check()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'not_logged_in']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_GET['product_id'] ?? 0;

        $isFavorite = $this->favoriteModel->isFavorite($userId, $productId);
        echo json_encode(['isFavorite' => $isFavorite]);
    }
}
