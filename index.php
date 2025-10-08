<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/vendor/autoload.php';

$controllerName = ucfirst(strtolower(($_REQUEST['controllers']) ?? 'home')) . 'Controller';
$actionName = ($_REQUEST['action'] ?? 'index');

$controllerObj = new $controllerName;
$controllerObj->$actionName();
