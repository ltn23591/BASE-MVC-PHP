<?php

class ProductController extends BaseController
{
    private $productModel;
    private $productSizeModel;
    private $ratingModel;
    private $favoriteModel;

    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;

        $this->loadModel('ProductSizeModel');
        $this->productSizeModel = new ProductSizeModel;

        $this->loadModel('RatingModel');
        $this->ratingModel = new RatingModel();

        $this->loadModel('FavoriteModel');
        $this->favoriteModel = new FavoriteModel();
    }
    public function index()
    {
        $limit = 10000;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Lấy tổng số sản phẩm
        $totalProduct = $this->productModel->countAll();
        $totalPages = ceil($totalProduct / $limit);

        // Lấy danh sách sản phẩm có phân trang
        $products = $this->productModel->getPaginated(
            $limit,
            $offset,
            ['column' => 'id', 'order' => 'DESC']
        );

        $categories = $_GET['category'] ?? [];
        $subCategories = $_GET['subCategory'] ?? [];
        $sortType = $_GET['sort'] ?? 'relavent';

        return $this->view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'sortType' => $sortType,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function detail()
    {
        // Lấy ID từ URL parameter
        $id = $_GET['id'] ?? null;

        if (!$id) {
            // Xử lý khi không có ID
            header('Location: index.php?controllers=product&action=index');
            exit();
        }

        // Lấy tất cả sản phẩm
        $column =  ['id', 'name', 'price'];
        $orderBy =  ['id', 'asc'];
        $relatedProducts = $this->productModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']
        );

        $product = $this->productModel->findById($id);

        // Kiểm tra sản phẩm có tồn tại không
        if (!$product) {
            // Xử lý khi sản phẩm không tồn tại
            header('Location: index.php?controllers=product&action=index');
            exit();
        }

        if (!empty($product['image'])) {
            $product['image'] = json_decode($product['image'], true);
        }

        $related = [];
        $empty = "";
        $currentCategory = $product['category'];
        $currentSubCategory = $product['subCategory'];

        foreach ($relatedProducts as $p) {
            if ($p['id'] != $product['id'] && $p['category'] == $currentCategory && $p['subCategory'] ==  $currentSubCategory) {
                array_push($related, $p);
                if (count($related) >= 5) break; // chỉ lấy tối đa 5 sản phẩm
            } else {
                $empty = "";
            }
        }

        // Tồn kho
        $totalProductResult = $this->productSizeModel->getTotalProduct($id);
        $totalProduct = $totalProductResult[0]['total'] ?? 0;

        // Lấy danh sách size còn hàng
        $productSizes = $this->productSizeModel->getSizeByProductId($id);

        // Lấy danh sách đánh giá
        $getAllRatings = $this->ratingModel->getAllRatings($id);

        // Tổng số đánh giá
        $total = $this->ratingModel->totalRatings($id);
        $totalReviewsResult = $total[0]['total_reviews'] ?? 0;

        // trung bình số sao
        $average = $this->ratingModel->averageRatings($id);
        $averageRating = (int)$average[0]['avg_rating'] ?? 0;

        // Kiểm tra trạng thái yêu thích
        $isFavorited = false;
        if (isset($_SESSION['user_id'])) {
            $isFavorited = $this->favoriteModel->isFavorite($_SESSION['user_id'], $id);
        }

        return $this->view(
            'frontend.components.ProductDetail',
            [
                'product' => $product,
                'related' => $related,
                'empty' => $empty,
                'totalInventory' => $product['quantity'] ?? 0,
                'totalProduct' => $totalProduct,
                'productSizes' => $productSizes,
                'getAllRatings' => $getAllRatings,
                'totalReviewsResult' => $totalReviewsResult,
                'averageRating' => $averageRating,
                'isFavorited' => $isFavorited 
            ]
        );
    }

    public function update()
    {
        $id = $_GET['id'];
        $data = [
            'name'          => 'Iphone 16',
            'price'         => '10000',
            'image'         => NULL,
            'category_id'   => 2
        ];
        $this->productModel->updateData($id, $data);
    }
    public function delete()
    {
        $id = $_GET['id'];
        $this->productModel->destroy($id);
    }
    public function show()
    {
        $column =  ['id', 'name', 'price'];
        $orderBy =  ['id', 'asc'];

        $products = $this->productModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']

        );
        return $this->view(
            'frontend.components.LastedCollection',
            [
                'products' => $products
            ],
        );
    }
}