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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controllers=auth&action=login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $favorites = $this->favoriteModel->getFavoritesByUser($userId);
        require_once './views/frontend/favorites.php';
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
