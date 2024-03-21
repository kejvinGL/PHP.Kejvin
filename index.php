<?php
session_start();
const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;


require "vendor/autoload.php";

use Router\Router;

$router = new Router();

require 'routes.php';


$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

$method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
