<?php
session_start();

require "vendor/autoload.php";

const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;

use Database\DatabaseConnect;
// use Router\Router;

// $router = new Router;
$pdo = new DatabaseConnect();

// require 'routes.php';
$data = [
    "role_id" => 1,
    "fullname" => "Kejvin Braka",
    "email" => "kejvin@gmail.com",
    "username" => "kejvin",
    "password" => "12345678"
];

// dd($pdo->insert("users", $data));
// dd($pdo->select("users", ["email" => "kejvinbraka@gmail.com"], ["*"], " JOIN", "posts", ["user_id"]));
// dd($pdo->update("users", ["role_id"=> 0], ["user_id" => 111]));
// dd($pdo->delete("posts", ["post_id" => 93]));
// dd($pdo->query("SELECT * from posts WHERE post_id = ?", ['94']));


$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

$method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
