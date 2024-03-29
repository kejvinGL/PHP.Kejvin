<?php
session_start();

require "vendor/autoload.php";

use Models\User;
use Models\Post;
use Models\Media;
use Models\Role;


const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;

use Core\Router;

$router = new Router;

require 'routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

$method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
