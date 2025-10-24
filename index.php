<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

ob_start();
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

$router = new Router();
require './routes/web.php';

// ✅ أولاً: لو الطلب من نوع POST (زي login/register) شغّل الراوتر وارجع JSON فقط
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $router->run();
    exit;
}

// ✅ ثانياً: لو المستخدم مش عامل login → وداخل على الموقع من المتصفح
if (!isset($_SESSION['user'])) {
    header("Location: ./public/views/dashboard.php");
    exit;
}

// ✅ ثالثاً: لو عامل login → ودخل على الموقع → يروح للـ home
header("Location: ./public/views/home.php");
exit;
