<?php

const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;


require "vendor/autoload.php";
// require 'controllers/Router.php';
// require 'controllers/AuthController.php';
// require 'controllers/AdminController.php';
// require 'controllers/ProfileController.php';
// require 'controllers/PostController.php';
// require 'controllers/ThemeController.php';
use Router\Router;

$router = new Router();

require 'routes.php';


$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

$method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
