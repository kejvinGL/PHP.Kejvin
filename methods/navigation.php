<?php

function basePath($path): string
{
    return BASE_PATH . $path;
}

function redirectToHome(): void
{
    header("Location: /home");
    exit();
}


function redirectToAuth($target): void
{
    header("Location: /$target");
    exit();
}




function redirectToAdmin($target): void
{
    header("Location: /$target");
    exit();
}

function redirectToLogout(): void
{
    header("Location: /auth/logout");
    exit();
}

function redirectBack(): void
{
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
