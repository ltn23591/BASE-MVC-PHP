<?php

class HomeController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        // Gọi model để lấy dữ liệu sản phẩm hiển thị ở trang chủ
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }


    public function index()
    {
        // Lấy tất cả sản phẩm
        $products = $this->productModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']
        );

        // Giải mã JSON ảnh
        foreach ($products as &$p) {
            if (!empty($p['image'])) {
                $p['image'] = json_decode($p['image'], true);
            }
        }

        // Lọc ra các sản phẩm bán chạy
        $bestsellers = array_filter($products, function ($p) {
            return !empty($p['bestseller']) && (int)$p['bestseller'] === 1;
        });

        // Truyền sang view
        return $this->view(
            'frontend.home.index',
            [
                'products' => $products,
                'bestsellers' => $bestsellers
            ]
        );
    }
}