<?php
ob_start();
session_start();
// simple auth gate used earlier; remove if not needed
if (isset($_SESSION['user_id'])) {
    // comment-out for local testing if you don't use sessions:
    header("Location: ./pages/login.php");
    exit;
}
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type,Authorization");

require "vendor/autoload.php";

use App\Core\Router;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create CV | FimoBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/index.css">
</head>