<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\CvController;
use App\Controllers\UserController;
use App\Helpers\Helper;
use App\Middleware\AuthMiddleware;

/**
 * 
 * @api Dashboard
 * 
 */
$router->add("GET","/dashboard",function () {
        header("Location: public/views/dashboard.php");
    }
);

/**
 * 
 * @api User auth
 * 
 */
$router->add("GET","/users",function () {
        AuthMiddleware::protect();
        (new UserController())->getAll();
    }
);

$router->add("GET","/user",function () {
        AuthMiddleware::protect();
        $data = Helper::getInput();
        $id = $data["id"] ?? null;
        $id = intval($id);
        if ($id) (new UserController())->getUser($id);
        else echo json_encode(["error" => "ID is required"]);
    }
);

$router->add("DELETE", "/users/delete", function () {
        AuthMiddleware::protect();
        $id = Helper::getInput();
        $id = intval($id["id"] ?? null);
        // var_dump($id);
        if ($id) (new UserController())->delete($id);
        else echo json_encode(["error" => "ID is required"]);
});
$router->add("PUT", "/users/update", function () {
        $id = Helper::getInput();
        $id = intval($id["id"] ?? null);

        if ($id) (new UserController())->update($id);
        else echo json_encode(["error" => "ID is required"]);
});

/**
 * 
 * @api auth routes
 * 
 */
$router->add("POST", "/login", [new AuthController(), "login"]);
$router->add("POST", "/register", [new AuthController(), "register"]);
$router->add("POST", "/refresh", function () {
    (new AuthController())->refreshToken();
});
$router->add("POST", "/verify", function () {
    (new AuthController())->verify();
});

$router->add("POST", "/logout", function () {
    AuthMiddleware::protect();
    (new AuthController())->logout();
});

/**
 * 
 * @api Cv CRUD
 * 
*/
$router->add("GET","/cv",[new CvController(),"getCv"]);
$router->add("DELETE", "/cv/delete", [new CvController(),"delete"]);
$router->add("PUT", "/cv/save", [new CvController(),"save"]);
