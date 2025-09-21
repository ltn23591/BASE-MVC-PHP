<?php

class OrderController extends BaseController
{
    private $orderModel;
    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
    }
    public function index()
    {

        $products = $this->orderModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']
        );


        $categories = $_GET['category'] ?? [];
        $subCategories = $_GET['subCategory'] ?? [];
        $sortType = $_GET['sort'] ?? 'relavent';

        return $this->view('frontend.products.index', [
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'sortType' => $sortType

        ]);
    }



    public function getAllProduct() {}
}
