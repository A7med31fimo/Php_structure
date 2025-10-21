<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }


    public function run()
    {
        // var_dump($this->routes);
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
      
        
        $scriptName =  dirname($_SERVER['SCRIPT_NAME']);  //level up on directory to get current file
       
        $requestUri = str_replace($scriptName, '', $requestUri);
       
        // var_dump($requestUri);
        
        foreach ($this->routes as $route) {
            // var_dump($route["path"],$requestUri);
            if ($route["path"] === $requestUri && $route["method"] === $requestMethod) {
                
                return call_user_func($route["callback"]);
            }
        }
       

        // http_response_code(404);
        // echo json_encode(["error" => "Page not found"]);
    }
}
