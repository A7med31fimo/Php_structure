<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Helpers\Helper;
use App\Middleware\AuthMiddleware;

// Routes

$router->add(
    "GET",
    "/users",
    function () {
        $user = AuthMiddleware::protect();
        (new UserController())->getAll();
    }
); //Done
$router->add(
    "GET",
    "/user",
    function () {
        $user = AuthMiddleware::protect();
        $data = Helper::getInput();
        $id = $data["id"] ?? null;
        $id = intval($id);
        if ($id) (new UserController())->getUser($id);
        else echo json_encode(["error" => "ID is required"]);
    }
); //Done
// $router->add("POST", "/users", [new UserController(), "create"]);
$router->add("DELETE", "/users/delete", function () {//done
    $user = AuthMiddleware::protect();
    $id = Helper::getInput();
    $id = intval($id["id"] ?? null);
    // var_dump($id);
    if ($id) (new UserController())->delete($id);
    else echo json_encode(["error" => "ID is required"]);
});
$router->add("PUT", "/users/update", function () { //done
    $id = Helper::getInput();
    $id = intval($id["id"] ?? null);

    if ($id) (new UserController())->update($id);
    else echo json_encode(["error" => "ID is required"]);
});


$router->add("POST", "/login", [new AuthController(), "login"]); //done
$router->add("POST", "/register", [new AuthController(), "register"]); //done
$router->add("POST", "/refresh", function () {
    (new AuthController())->refreshToken();
});//done
$router->add("POST", "/logout", function () {
    $user = AuthMiddleware::protect();
    (new AuthController())->logout();
});//done
