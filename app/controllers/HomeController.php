<?php

namespace App\Controllers;

use App\Core\BaseController;


class HomeController
{

    public function index()
    {
        return (new BaseController())->jsonResponse(["message" => "Welcome to My PHP Project 🚀"]);
    }
}
