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
        $column =  ['id', 'name', 'category_id', 'price'];
        $orderBy =  ['id', 'asc'];
        $pageTitle = "Trang danh sach san pham";
        $products = $this->productModel->getAll(
            $column,
            $orderBy

        );
        return $this->view(
            'frontend.products.index',
            [
                'pageTitle' => $pageTitle,
                'products' => $products
            ],


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
        echo __METHOD__;
    }
}