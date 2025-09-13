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
        require($viewPath);
    }

    protected function loadModel($modelPath)
    {
        $modelPath = self::MODEL_FOLDER_NAME . '/' . str_replace('.', '/', $modelPath) . '.php';
        require($modelPath);
    }
}
