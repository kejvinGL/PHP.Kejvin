<?php

use Models\User;

function basePath($path): string
{
    return BASE_PATH . $path;
}

function view($view, $data = []): void
{
    require "protected/views/partials/header.php";

    require 'protected/views/' . $view . "View.php";

    require "protected/views/partials/footer.php";
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
    showErrorsLarge("post") ?? null;
    showErrorsLarge("post_id") ?? null;
    showErrorsLarge("title") ?? null;
    showErrorsLarge("body") ?? null;
}

function showProfileResponses(): void
{
    showMessages("avatar") ?? null;
    showErrorsLarge("avatar") ?? null;
    showErrorsLarge("new_username") ?? null;
    showErrorsLarge("new_email") ?? null;
}

function showPostlistResponses(): void
{
    showMessages("post_id") ?? null;
    showMessages("post") ?? null;
    showErrorsLarge("post_id") ?? null;
    showErrorsLarge("post") ?? null;
}

/**
 * Sets the user session.
 *
 * @param mixed $user The user data to be stored in the session.
 * @return void
 */
function setUserSession(array $user): void
{
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['darkmode'] = $user['darkmode'];
}



if (!function_exists('array_only')) {
    function array_only(array $haystack, array $needles): array
    {
        $result = [];

        foreach ($haystack as $value => $key) {

            if (in_array($value, $needles)) {
                $result[$value] = $key;
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
                $rules();
            }
        }
    }
}


/**
 * Displays an error message in cases where there is an array of errors.
 *
 * @param mixed $input The input for which error messages should be displayed.
 * @return void
 */
function showErrors(mixed $input): void
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500">' . $error . '</span> <br>';
        }
    }
    unset($_SESSION['errors'][$input]);
}

function showErrorsLarge($input): void
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500 text-lg">' . $error . '</span> <br>';
        }
    }
    unset($_SESSION['errors'][$input]);
}


/**
 * Displays a message to the user if there is an array of messages in the session.
 *
 * @param $input
 * @return void
 */
function showMessages($input): void
{
    if (isset($_SESSION['messages'][$input])) {
        foreach ($_SESSION['messages'][$input] as  $message) {
            echo '<span class="text-lg text-green-600" >' . $message . '</span> <br>';
        }
    }
    unset($_SESSION['messages'][$input]);
}


function redirectBack(): void
{
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
