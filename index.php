<?php

require 'views/partials/header.php';

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];



$routes = [

    // VIEWS
    "/" => "controllers/home.php",
    "/home" => "controllers/home.php",
    "/login" => "controllers/login.php",
    "/logout" => "controllers/logout.php",
    "/register" => "controllers/register.php",

    "/users" => "controllers/users.php",
    "/overall" => "controllers/overall.php",
    "/access" => "controllers/access.php",
    "/posts" => "controllers/posts.php",

    "/client" => "controllers/client.php",

    "/profile" => "controllers/profile.php",

    // REQUESTS
    "/auth/userCreate" => "controllers/auth/userCreate.php",
    "/auth/registerClient" => "controllers/auth/clientRegister.php",
    "/auth/userLogin" => "controllers/auth/userLogin.php",

    "/posts/createPost" => "controllers/posts/createPost.php",
    "/posts/deletePost" => "controllers/posts/deletePost.php",

    "/profile/changeAvatar" => "controllers/profile/changeAvatar.php",
    "/profile/changeDetails" => "controllers/profile/changeDetails.php",
    "/profile/changePassword" => "controllers/profile/changePassword.php",
    "/profile/deleteSelf" => "controllers/profile/deleteSelf.php",

    "/user/changeTheme" => "controllers/user/changeTheme.php",
    "/user/changeUser" => "controllers/user/changeUser.php",
    "/user/deleteUser" => "controllers/user/deleteUser.php"


];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require "views/404.php";
}
