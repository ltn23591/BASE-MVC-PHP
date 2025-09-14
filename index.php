<?php
require './core/Database.php';
require './models/BaseModel.php';
require './controllers/BaseController.php';
$controllerName = ucfirst(strtolower(($_REQUEST['controllers']) ?? 'home')) . 'Controller';

$actionName = ($_REQUEST['action'] ?? 'index');

include './controllers/' . $controllerName . '.php';

$controllerObj = new $controllerName;

$controllerObj->$actionName();
