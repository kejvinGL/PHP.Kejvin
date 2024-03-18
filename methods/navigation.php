<?php

use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\ProfileController;
use Controllers\PostController;

function basePath($path): string
{
    return BASE_PATH . $path;
}

function redirectToHome()
{
    header("Location: /home");
    exit();
}


function redirectToAuth($target)
{
    header("Location: /$target");
    exit();
}




function redirectToAdmin($target)
{
    header("Location: /$target");
    exit();
}




function redirectToProfile()
{
    header("Location: /profile");
    exit();
}
