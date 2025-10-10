<?php
namespace App\helpers;


function jsonResponse($data, $status = 200)
{
    http_response_code($status);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data);
}
