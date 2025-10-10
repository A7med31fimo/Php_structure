<?php


header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type,Authorization");
require "../app/controllers/AuthController.php";
require "../app/controllers/UserController.php";
require "../app/helpers/Functions.php";



// loads all classes automatically
require "../vendor/autoload.php";

use App\Controllers\AuthController;
use App\Core\Router;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$router = new Router();

// 🧭 Routes
$router->add("GET", "/users", function(){
    $user = AuthMiddleware::protect();
    (new UserController())->getAll();
}
); //Done
// $router->add("POST", "/users", [new UserController(), "create"]);
$router->add("DELETE", "/users/delete", function () {
    // $user = AuthMiddleware::protect();
    $id = $_GET["id"] ?? null;
    if ($id) (new UserController())->delete($id);
});
$router->add("PUT", "/users/update", function () { //done
    $id = $_GET["id"] ?? null;
    if ($id) (new UserController())->update($id);
});


$router->add("POST", "/login", [new AuthController(), "login"]);//done
$router->add("POST", "/register", [new AuthController(), "register"]); //done
$router->add("POST", "/refresh", function () {
    (new AuthController())->refreshToken();
});
$router->run();
