<?php
// ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type,Authorization");


ob_start();
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use App\Core\Router;

$router = new Router();
require './routes/web.php';
$router->run();



if (!isset($_SESSION['user'])) {
    header("Location: ./public/views/dashboard.php");
    exit;
}else{
    header("Location: ./public/views/home.php");
}
?>