<?php

class AdminController extends BaseController
{
    private $adminModel;
    public function __construct() //dung chung cho tat ca cac phuong thuc
    {
        $this->loadModel('AdminModel');
        $this->adminModel = new AdminModel;
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $uploadedImages = [];
            $uploadDir = 'public/uploads/';

            // Nếu chưa có thư mục thì tạo
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = $targetPath;
                    }
                }
            }

            // Lấy dữ liệu còn lại từ form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $subCategory = $_POST['subCategory'];
            $sizes = json_encode($_POST['sizes'] ?? []);
            $bestseller = isset($_POST['bestseller']) ? 1 : 0;

            // Gọi model để lưu DB
            $this->adminModel->store([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => json_encode($uploadedImages),
                'category' => $category,
                'subCategory' => $subCategory,
                'sizes' => $sizes,
                'bestseller' => $bestseller,
                'date' => time()
            ]);

            // Quay về danh sách
            header('Location: index.php?controllers=auth&action=admin');
            exit();
        }

        return $this->viewAdmin('admin.components.add');
    }

    public function list()
    {
        $products = $this->adminModel->getAll(['*'], ['column' => 'id', 'order' => 'desc']);
        return $this->viewAdmin('admin.components.list', [
            'products' => $products
        ]);
    }

    public function orders()
    {
        return $this->viewAdmin('admin.components.orders');
    }
    public function delete()
    {
        $id = $_GET['id'];

        if ($id) {
            $this->adminModel->destroy($id);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
}
