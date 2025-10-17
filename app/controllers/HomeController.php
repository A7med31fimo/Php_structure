<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Helpers\Helper;


class HomeController
{

    public function index()
    {
        return Helper::jsonResponse(["message" => "Welcome to My PHP Project 🚀"]);
    }
}
