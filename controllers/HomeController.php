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
        // Lấy 10 sản phẩm mới nhất
        $products = $this->productModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']
        );

        // Gọi view trang home và truyền dữ liệu sang
        return $this->view(
            'frontend.home',
            [
                'products' => $products,
                'pageTitle' => 'Trang chủ'
            ]
        );
    }
}
