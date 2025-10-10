<?php


header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require "../app/controllers/AuthController.php";
require "../app/controllers/UserController.php";
require "../app/helpers/Functions.php";



// loads all classes automatically
require "../vendor/autoload.php";

use App\Controllers\AuthController;
use App\Core\Router;
use App\Controllers\UserController;

$router = new Router();

// 🧭 Routes
$router->add("GET", "/users", [new UserController(), "getAll"]); //Done
// $router->add("POST", "/users", [new UserController(), "create"]);
$router->add("DELETE", "/users/delete", function () {
    $id = $_GET["id"] ?? null;
    if ($id) (new UserController())->delete($id);
});
$router->add("Put", "/users/update", function () {
    $id = $_GET["id"] ?? null;
    if ($id) (new UserController())->update($id);
});

$router->add("POST", "/login", [new AuthController(), "login"]);
$router->add("POST", "/register", [new AuthController(), "register"]);

$router->run();
