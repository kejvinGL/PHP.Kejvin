<?php
session_start();
require "../../methods/user.php";
isLoggedIn();
require "../../methods/errors.php";
require "../../methods/messages.php";


function handleDetailsChange(): void
{
    $_SESSION['tab'] = "details";
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $errors = array();

    if (checkFormReq($new_username, $new_email, $user_id)) {
        changeDetails($username, $email, $new_username, $new_email);
    } else {
        handleErrorReport($errors);
    }
}

function checkFormReq($new_username, $new_email, $user_id): bool
{
    $errors = array();
    $errors["details"] = array();
    $errors["details"]['username'] = array();
    $errors["details"]['email'] = array();
    $errors["check"] = true;


    if (strlen($new_username) < 5) {
        $errors["details"]['username'][] = "An Username must be more than 5 characters.";
        $errors["check"] = false;
    }
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors["details"]['email'][] = "Invalid email format.";
        $errors["check"] = false;
    }
    if (!verifyUsernameUnique($new_username, [$user_id])) {
        $errors["details"]['username'][] = "Username already taken.";
        $errors["check"] = false;
    }
    if (!verifyEmailUnique($new_email, [$user_id])) {
        $errors["details"]["email"][] = "Email already taken.";
        $errors["check"] = false;
    }
    return $errors["check"];
}


function handleErrorReport($errors)
{

    addErrors($errors);
    if (empty($errors["username"])) {
        $_SESSION["input"]["username"] = $_POST["username"];
    } else {
        unset($_SESSION["input"]["username"]);
    }
    if (empty($errors["email"])) {
        $_SESSION["input"]["email"] = $_POST["email"];
    } else {
        unset($_SESSION["input"]["email"]);
    }
    redirectToProfile();
}


function changeDetails($username, $email, $new_username, $new_email): void
{
    if (setDetails($username, $email, $new_username, $new_email)) {
        $messages = array();


        $messages[] = "User updated successfully!";
        addMessages($messages);


        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;


        redirectToProfile();
    }
}


function redirectToProfile(): void
{
    header("Location: /loginpage/views/profile.php");
}

if (isset($_POST["submit"])) {
    handleDetailsChange();
}
