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

        $scriptName =  dirname($_SERVER['SCRIPT_NAME']); //"/Php_structure/public" delete it from uri to get route name directly.
        $requestUri = str_replace($scriptName, '', $requestUri);
        // var_dump($scriptName);


        foreach ($this->routes as $route) {
            
            if ($route["path"] === $requestUri && $route["method"] === $requestMethod) {
                return call_user_func($route["callback"]);
            }
            // else{
            //     var_dump($route["path"]);
            //     var_dump($route["method"]);
                
            // }
        }
        
        http_response_code(404);
        echo json_encode(["error" => "Route not found"]);
    }
}
