<?php
class BaseController
{
    const VIEW_FOLDER_NAME = 'views';
    const MODEL_FOLDER_NAME = 'models';
    protected function view($viewPath, array $data = [])
    {

        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath =  self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';

      
            include __DIR__ . '/../views/frontend/layouts/header.php';
            include __DIR__ . '/../views/frontend/layouts/navbar.php';
            require($viewPath);
            include __DIR__ . '/../views/frontend/layouts/footer.php';
      
       
    }

    protected function loadModel($modelPath)
    {
        $modelPath = self::MODEL_FOLDER_NAME . '/' . str_replace('.', '/', $modelPath) . '.php';
        require($modelPath);
    }
    protected function viewAdmin($viewPath, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        require($viewPath);
    }
}