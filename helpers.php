<?php

function view($view): void
{
    require "views/partials/header.php";
    isLoggedIn();

    require 'views/' . $view . "View.php";


    require "views/partials/footer.php";
}
function dd($v): void
{
    echo "<pre>";
    var_dump($v);
    echo "</pre>";
    die();
}

function showUserlistResponses(): void
{
    showMessages("changes") ?? null;
    showErrorsLarge("new_username") ?? null;
    showErrorsLarge("new_email") ?? null;
    showErrorsLarge("password") ?? null;
    showErrorsLarge("new_password") ?? null;
    showErrorsLarge("edit") ?? null;
    showErrorsLarge("changes") ?? null;
}
function showHomeResponses(): void
{
    showMessages("post") ?? null;
    showErrorsLarge("post_id") ?? null;
    showErrorsLarge("title") ?? null;
    showErrorsLarge("body") ?? null;
}

function showProfileResponses(): void
{
    showErrorsLarge("avatar") ?? null;
    showErrorsLarge("new_username") ?? null;
    showErrorsLarge("new_email") ?? null;
}


/**
 * Checks if a user is logged in.
 *
 * @return void Returns true if the user is logged in, false otherwise.
 */
function isLoggedIn(): void
{
    if (isset($_SESSION['user_id']) && getCurrentUser()) {
        if ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register') {
            getCurrentUserRole() === 0 ? redirectToAdmin('overall') : redirectToHome();
            exit;
        }
    } else {
        if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/register') {
            redirectToAuth('login');
            exit;
        }
    }
}

/**
 * Checks if the user is a client.
 *
 * @return void Redirects user to /Home if user is not a Client.
 */
function isClient(): void
{
    switch (getCurrentUserRole()) {
        case 0:
            redirectToAdmin("overall");
            break;
        case null:
            redirectToAuth('login');
            break;
        default:
            break;
    }
}


/**
 * Checks if the user is an admin.
 *
 * @return void Redirects user to /Home if user is not an Admin.
 */
function isAdmin(): void
{
    if (getCurrentUserRole() !== 0) {
        session_unset();
        redirectToAuth('login');
    }
}



/**
 * Sets the user session.
 *
 * @param mixed $user The user data to be stored in the session.
 * @return void
 */
function setUserSession($user): void
{
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['darkmode'] = $user['darkmode'];
}


/**
 * Unsets the session data for a specific user.
 *
 * @return void
 */
function unsetUserSession(): void
{
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['darkmode']);
}


if (!function_exists('array_only')) {
    function array_only(array $array, array $fields)
    {
        $result = [];
        foreach ($array as $field => $key) {
            if (in_array($field, $fields)) {
                $result[$field] = $array[$field];
            }
        }
        return $result;
    }
}

if (!function_exists('array_func')) {
    function array_func(array $functions, array $fields): void
    {
        foreach ($functions as $field => $rules) {
            if (in_array($field, $fields)) {
                $rules;
            }
        }
    }
}
