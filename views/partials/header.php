<?php
session_start();

require("src/methods/user.php");
require("src/methods/errors.php");
require("src/methods/messages.php");
require("src/methods/post.php");
isLoggedIn();

$title = "Kejvin.PHP | Login";
switch ($_SERVER["REQUEST_URI"]) {
  case "/views/register":
    $title = "Kejvin.PHP | Register";
    break;
  case "/views/overall":
    $title = "Kejvin.PHP | Admin Dashboard";
    break;
  case "/views/users":
    $title = "Kejvin.PHP | All Users";
    break;
  case "/views/access":
    $title = "Kejvin.PHP | Create New User";
    break;
  case "/views/posts":
    $title = "Kejvin.PHP | All Posts";
    break;
  case "/profile":
    $title = "Kejvin.PHP | Profile";
    break;
}


include "head.php";
include "navbar.php";
switch ($_SERVER["REQUEST_URI"]) {
  case '/views/client':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/views/users':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/views/posts':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  default:
    $body = '<body class="overflow-hidden h-full">';
    break;
}

echo $body;
