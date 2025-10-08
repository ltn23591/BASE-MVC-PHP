<?php
class BaseController
{
    const VIEW_FOLDER_NAME = 'views';
    const MODEL_FOLDER_NAME = 'models';
    protected function view($viewPath, array $data = [], bool $withLayout = true)
    {

        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath =  self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';


        if ($withLayout) {

            include __DIR__ . '/../views/frontend/layouts/header.php';
            include __DIR__ . '/../views/frontend/layouts/navbar.php';
            require($viewPath);
            include __DIR__ . '/../views/frontend/layouts/footer.php';
        } else {
            require($viewPath);
        }
    }

    // Hàm này dành cho admin nhằm để ẩn header và footer của client
    protected function viewAdmin($viewPath, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        require($viewPath);
    }
}
