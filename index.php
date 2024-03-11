<?php
require 'views/partials/header.php';

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];



$routes = [


    // VIEWS
    "/" => "views/home.php",
    "/views/" => "views/home.php",
    "/views/login" => "views/login.php",
    "/views/logout" => "views/logout.php",
    "/views/register" => "views/register.php",
    "/views/users" => "views/users.php",
    "/views/overall" => "views/overall.php",
    "/views/access" => "views/access.php",
    "/views/posts" => "views/posts.php",
    "/views/profile" => "views/profile.php",

    // REQUESTS
    "/src/requests/auth/newUser" => "src/requests/auth/newUser.php",
    "/src/requests/auth/registerClient" => "src/requests/auth/registerClient.php",
    "/src/requests/auth/userLogin" => "src/requests/auth/userLogin.php",

    "/src/requests/posts/createPost" => "src/requests/posts/createPost.php",
    "/src/requests/posts/deletePost" => "src/requests/posts/deletePost.php",

    "/src/requests/profile/changeAvatar" => "src/requests/profile/changeAvatar.php",
    "/src/requests/profile/changeDetails" => "src/requests/profile/changeDetails.php",
    "/src/requests/profile/changePassword" => "src/requests/profile/changePassword.php",
    "/src/requests/profile/deleteSelf" => "src/requests/profile/deleteSelf.php",

    "/src/requests/user/changeTheme" => "src/requests/user/changeTheme.php",
    "/src/requests/user/changeUser" => "src/requests/user/changeUser.php",
    "/src/requests/user/deleteUser" => "src/requests/user/deleteUser.php"


];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require "views/404.php";
}
