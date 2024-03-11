<?php
session_start();

require "../../methods/user.php";
require "../../methods/errors.php";


function handleRegister(): void
{
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (checkFormReq($fullname, $username, $email, $password));
    checkRegister($fullname, $username, $email, $password);
}


function checkFormReq($fullname, $username, $email, $password)
{
    $errors["fullname"] = array();
    $errors["username"] = array();
    $errors["email"] = array();
    $errors["password"] = array();
    $errors["check"] = true;

    if (empty($username)) {
        $errors["username"][] = "Username cannot be empty.";
        $errors["check"] = false;
    }
    if (empty($password)) {
        $errors["password"][] = "Password cannot be empty.";
        $errors["check"] = false;
    }
    if (empty($fullname)) {
        $errors["fullname"][] = "Fullname cannot be empty.";
        $errors["check"] = false;
    }
    if (empty($email)) {
        $errors["email"][] = "Email cannot be empty.";
        $errors["check"] = false;
    }
    if ((!preg_match('/^[a-zA-Z ]+$/', $fullname))) {
        $errors["fullname"][] = "Full name not valid";
        $errors["check"] = false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"][] = "Email not valid";
        $errors["check"] = false;
    }
    if (strlen($password) < 8) {
        $errors["password"][] = "Password must be at least 8 characters long";
        $errors["check"] = false;
    }
    if (!$errors["check"]) {
        addErrors($errors);
        handleErrorReport($errors);
    }
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
    if (empty($errors["fullname"])) {
        $_SESSION["input"]["fullname"] = $_POST["fullname"];
    } else {
        unset($_SESSION["input"]["fullname"]);
    }
    redirectToRegister();
}


function checkRegister($fullname, $username, $email, $password): void
{
    checkIncorrectRegister($username, $email);
    createClient($fullname, $username, $email, $password);
    $user = getUserByUsername($username);
    setUserSession($user);
    mkdir(dirname(__DIR__, 3) . "/assets/media/" . $user['user_id']);
    redirectToHome();
}


function checkIncorrectRegister($username, $email): void
{
    $errors = array();
    $errors["username"] = array();
    $errors["email"] = array();
    $errors["check"] = true;

    //CHECK IF USERNAME EXISTS
    if (!verifyUsernameUnique($username)) {
        unset($_SESSION["input"]["username"]);
        $errors["username"][] = "Username already exists.";
        $errors["check"] = false;
    }
    //CHECK IF EMAIL EXISTS
    if (!verifyEmailUnique($email)) {
        unset($_SESSION["input"]["email"]);
        $errors["email"][] = "Email already in use.";
        $errors["check"] = false;
    }

    if (!$errors["check"]) {
        addErrors($errors);
        handleErrorReport($errors);
    }
}


function setUserSession($user): void
{
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['darkmode'] = $user['darkmode'];
}

function redirectToRegister(): void
{
    header("Location: /loginpage/views/register.php");
    exit();
}


function redirectToHome(): void
{
    header("Location: /loginpage/views/home.php");
    exit();
}


if (isset($_POST["submit"])) {
    handleRegister();
}
