<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$uri_parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
$project_name = $uri_parts[0];

define('BASE_URL', $protocol . $host . '/' . $project_name . '/');