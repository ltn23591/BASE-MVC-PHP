<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/config_url.php';
require './core/Database.php';
require './models/BaseModel.php';
require './controllers/BaseController.php';


$controllerName = ucfirst(strtolower(($_REQUEST['controllers']) ?? 'home')) . 'Controller';
$actionName = ($_REQUEST['action'] ?? 'index');
include './controllers/' . $controllerName . '.php';
$controllerObj = new $controllerName;
$controllerObj->$actionName(); 