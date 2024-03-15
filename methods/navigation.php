<?php

function basePath($path): string
{
    return BASE_PATH . $path;
}

function redirectToHome()
{
    header("Location: /home");
    exit();
}


function redirectToLogin()
{
    header("Location: /login");
    exit();
}




function redirectToRegister()
{
    header("Location: /register");
    exit();
}




function redirectToUserList()
{
    header("Location: /users");
    exit();
}


function redirectToOverall()
{
    header("Location: /overall");
    exit();
}


function redirectToAccess()
{
    header("Location: /access");
    exit();
}


function redirectToPosts()
{
    header("Location: /posts");
    exit();
}



function redirectToProfile()
{
    header("Location: /profile");
    exit();
}
