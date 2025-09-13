<?php

class CategoryController extends BaseController
{
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }
    public function index()
    {
        $category = $this->categoryModel->getAll(['*'], ['column' => 'id', 'order' => 'desc']);
        $pageTitle = 'Danh sach san pham theo danh muc: laptop';
        return $this->view(
            'frontend.categories.index',
            ['pageTitle' => $pageTitle, 'category' => $category],

        );
    }
    public function store()
    {
        $data = [
            'name' => 'Iphone 12',

        ];
        $this->categoryModel->store($data);
    }
    public function update()
    {
        $id = $_GET['id'];
        $data = [
            'name' => 'May lanh',
        ];
        $this->categoryModel->updateData($id, $data);
    }
    public function show()
    {
        $id = $_GET['id'];
        $category = $this->categoryModel->findById($id);
        echo '<pre>';
        print_r($category);
    }
    public function delete()
    {
        $id = $_GET['id'];
        $this->categoryModel->destroy($id);
    }
}
