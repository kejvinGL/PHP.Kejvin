<?php

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
<html lang="en" data-theme='<?php if (!isset($_SESSION['darkmode'])) $_SESSION['darkmode'] = true;
                            echo $_SESSION['darkmode'] ? "black" : "retro" ?>'>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="/assets/media/logo.jpg">
  <link rel="stylesheet" href="/assets/styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
  <link href="/assets/styles/output.css" rel="stylesheet">
  <!DOCTYPE html>

  <title> <?php echo $title ?> </title>
</head>

<?php
include "navbar.php";
$body = match ($_SERVER["REQUEST_URI"]) {
  '/', '/home', '/users', '/posts' => '<body class="overflow-y-auto min-h-full h-full">',
  default => '<body class="overflow-hidden h-full">',
};

echo $body;
showErrorsLarge('database');
