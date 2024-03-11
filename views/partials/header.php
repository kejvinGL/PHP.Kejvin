<?php
session_start();

require("../src/methods/user.php");
require("../src/methods/errors.php");
require("../src/methods/messages.php");
require("../src/methods/post.php");
isLoggedIn();

$title = "Kejvin.PHP | Login";
switch ($_SERVER["REQUEST_URI"]) {
  case "/loginpage/views/register.php":
    $title = "Kejvin.PHP | Register";
    break;
  case "/loginpage/views/overall.php":
    $title = "Kejvin.PHP | Admin Dashboard";
    break;
  case "/loginpage/views/users.php":
    $title = "Kejvin.PHP | All Users";
    break;
  case "/loginpage/views/access.php":
    $title = "Kejvin.PHP | Create New User";
    break;
  case "/loginpage/views/posts.php":
    $title = "Kejvin.PHP | All Posts";
    break;
  case "/loginpage/profile.php":
    $title = "Kejvin.PHP | Profile";
    break;
}


include "head.php";
include "navbar.php";
switch ($_SERVER["REQUEST_URI"]) {
  case '/loginpage/views/client.php':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/loginpage/views/users.php':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/loginpage/views/posts.php':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  default:
    $body = '<body class="overflow-hidden h-full">';
    break;
}

echo $body;
