<?php

class ProductController extends BaseController
{
    private $productModel;
    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
    }
    public function index()
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
    public function detail()
    {
        if (!isset($_GET['id'])) {
            die('Thiếu ID sản phẩm');
        }
        $id = $_GET['id'];
        $product = $this->productModel->findById($id);
        if (!empty($product['image'])) {
            $product['image'] = json_decode($product['image'], true);
        }
        return $this->view(
            'frontend.components.ProductDetail',
            [
                'product' => $product,
            ]
        );
    }
    public function store()
    {
        $data = [
            'name'          => 'Iphone 12',
            'price'         => '12000000',
            'image'         => NULL,
            'category_id'   => 2
        ];
        $this->productModel->store($data);
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