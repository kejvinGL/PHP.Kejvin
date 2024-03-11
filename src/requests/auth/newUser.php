<?php
session_start();

require "../../methods/user.php";
require "../../methods/errors.php";
require "../../methods/messages.php";


function handleNewUser()
{
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];


    if (checkFormReq($fullname, $username, $email, $password, $role)) {
        checkNewUser($fullname, $username, $email, $password, $role);
    } else {
        redirectToAccess();
    }
}


function checkFormReq($fullname, $username, $email, $password, $role)
{
    $errors = array();
    $errors[$role] = array();
    $errors[$role]["fullname"] = array();
    $errors[$role]["email"] = array();
    $errors[$role]["username"] = array();
    $errors[$role]["password"] = array();
    $errors["check"] = true;


    //Fullname
    if (empty($fullname)) {
        array_push($errors[$role]["fullname"], "Fullname cannot be empty.");
        $errors["check"] = false;
    } elseif ((!preg_match('/^[a-zA-Z ]+$/', $fullname))) {
        array_push($errors[$role]["fullname"], "Full name not valid");
        $errors["check"] = false;
    }

    //Email
    if (empty($email)) {
        array_push($errors[$role]["email"], "Email cannot be empty.");
        $errors["check"] = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors[$role]["email"], "Email not valid");
        $errors["check"] = false;
    } elseif (!verifyEmailUnique($username, [])) {
        array_push($errors[$role]["email"], "Email already taken.");
        $errors["check"] = false;
    }


    //Username
    if (empty($username)) {
        array_push($errors[$role]["username"], "Username cannot be empty.");
        $errors["check"] = false;
    } elseif (!verifyUsernameUnique($username, [])) {
        array_push($errors[$role]["username"], "Username already taken.");
        $errors["check"] = false;
    }


    //Password
    if (empty($password)) {
        array_push($errors[$role]["password"], "Password cannot be empty.");
        $errors["check"] = false;
    } elseif (strlen($password) < 8) {
        array_push($errors[$role]["password"], "Password must be at least 8 charactes long");
        $errors["check"] = false;
    }

    if ($errors["check"] == false) {
        addErrors($errors);
    }

    return $errors["check"];
}

function checkNewUser($fullname, $username, $email, $password, $role)
{
    switch ($role) {
        case 'admin':
            createAdmin($fullname, $username, $email, $password);
            break;
        case 'client':
            createClient($fullname, $username, $email, $password);
            break;
    }

    $user = getUserByUsername($username);
    mkdir(dirname(__DIR__, 2) . "/assets/media/" . $user['user_id']);
    $messages = array();
    $messages["admin"] = array();
    array_push($messages["admin"], "New " . ucfirst($role) . " created");
    addMessages($messages);
    redirectToAccess();
}


function redirectToAccess()
{
    header("Location: /loginpage/views/access.php");
}


if (isset($_POST['submit'])) {
    handleNewUser();
}
