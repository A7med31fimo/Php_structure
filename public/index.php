<?php


header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type,Authorization");

// loads all classes automatically
require "../vendor/autoload.php";

use App\Core\Router;


$router = new Router();
require '../routes/web.php';
$router->run();
