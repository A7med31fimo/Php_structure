<?php

namespace App\Controllers;

use function App\helpers\jsonResponse;

class HomeController
{
    public function index()
    {
        return jsonResponse(["message" => "Welcome to My PHP Project 🚀"]);
    }
}
