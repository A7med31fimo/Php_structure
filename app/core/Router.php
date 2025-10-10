<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = compact("method", "path", "callback");
    }

    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        // $parts = explode('/', $requestUri);
        // $requestUri = "/" . end($parts);
        // إزالة اسم المجلد (يدويًا أو تلقائيًا)
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $requestUri = str_replace($scriptName, '', $requestUri);


        foreach ($this->routes as $route) {
            if ($route["path"] === $requestUri && $route["method"] === $requestMethod) {
                return call_user_func($route["callback"]);
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Route not found"]);
    }
}
