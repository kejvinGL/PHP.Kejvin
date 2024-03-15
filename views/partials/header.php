<?php
session_start();

require("methods/user.php");
require("methods/errors.php");
require("methods/messages.php");
require("methods/post.php");
require("methods/navigation.php");
$title = "Kejvin.PHP | Login";
switch ($_SERVER["REQUEST_URI"]) {
  case "/register":
    $title = "Kejvin.PHP | Register";
    break;
  case "/overall":
    $title = "Kejvin.PHP | Admin Dashboard";
    break;
  case "/users":
    $title = "Kejvin.PHP | All Users";
    break;
  case "/access":
    $title = "Kejvin.PHP | Create New User";
    break;
  case "/posts":
    $title = "Kejvin.PHP | All Posts";
    break;
  case "/profile":
    $title = "Kejvin.PHP | Profile";
    break;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <!DOCTYPE html>
  <html lang="en" data-theme='<?php if (!isset($_SESSION['darkmode'])) $_SESSION['darkmode'] = true;
                              echo $_SESSION['darkmode'] ? "black" : "retro" ?>'>
  <title> <?php echo $title ?> </title>
</head>

<?php
include "navbar.php";
switch ($_SERVER["REQUEST_URI"]) {
  case '/client':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/users':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  case '/posts':
    $body = '<body class="overflow-y-auto h-max">';
    break;
  default:
    $body = '<body class="overflow-hidden h-full">';
    break;
}

echo $body;
