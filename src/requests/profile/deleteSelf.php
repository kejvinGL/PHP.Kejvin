<?php

session_start();
require "../../methods/user.php";
require "../../methods/errors.php";
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$errors = array();

function handleSelfDelete()
{
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];

    if (checkFormReq()) {
        deleteSelfUser($user_id, $password);
    } else {
        redirectToProfile();
    }
}


function checkFormReq($password): bool
{
    $errors = array();
    if (empty($password)) {
        array_push($errors, "Password is required");
        addErrors($errors);
        return false;
    }
    return true;
}

function deleteSelfUser($user_id, $password)
{
    $errors = array();
    $errors['user'] = array();
    $errors['delete'] = array();
    $user = getCurrentUser();
    $saved_password = $user['password'];
    if (password_verify($password, $saved_password)) {
        if (deleteUser($user_id)) {
            array_push($errors["user"], "User deleted successfully");
            addErrors($errors);
            unsetUserSession();
            redirectToLogin();
        }
    } else {
        array_push($errors['delete'], "Wrong password was entered");
        addErrors($errors);
        redirectToProfile();
    }
}

function unsetUserSession()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['darkmode']);
}

function redirectToLogin()
{
    header("Location: /loginpage/views/login.php");
}

function redirectToProfile()
{
    header("Location: /loginpage/views/profile.php");
}

if (isset($_POST['submit'])) {
    handleSelfDelete();
}
