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

        $products = $this->productModel->getAll(
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



    public function detail()
    {
        // Lấy tất cả sản phẩm
        $column =  ['id', 'name', 'price'];
        $orderBy =  ['id', 'asc'];
        $relatedProducts = $this->productModel->getAll(
            ['*'],
            ['column' => 'id', 'order' => 'desc']

        );


        if (!isset($_GET['id'])) {
            die('Thiếu ID sản phẩm');
        }

        $id = $_GET['id'];
        $product = $this->productModel->findById($id);
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
        return $this->view(
            'frontend.components.ProductDetail',
            [
                'product' => $product,
                'related' => $related,
                'empty' => $empty
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
    public function getAllProduct() {}
}