<?php
isLoggedIn();

function handlePasswordChange()
{
    $_SESSION['tab'] = "password";
    $user_id = $_SESSION["user_id"];
    $current_tried = $_POST['current_password'];
    $new_tried = $_POST['new_password'];
    $repeat_tried = $_POST['repeat_password'];

    if (checkFormReq($current_tried, $new_tried, $repeat_tried)) {
        changePassword($new_tried, $user_id);
    } else {
        redirectToProfile();
    }
}

function checkFormReq($current_tried, $new_tried, $repeat_tried): bool
{
    $errors = array();
    $errors["password"] = array();
    $errors["password"] = array();
    $errors["password"]['current'] = array();
    $errors["password"]['new_password'] = array();
    $errors["password"]['repeat_password'] = array();

    $errors["check"] = true;

    if (strlen($current_tried) == 0) {
        array_push($errors['password']['current'], "Current Password must be entered.");
        addErrors($errors);
        $errors["check"] = false;
    }

    if (strlen($new_tried) == 0) {
        array_push($errors['password']['new_password'], "New Password must be entered.");
        addErrors($errors);
        $errors["check"] = false;
    } elseif (strlen($repeat_tried) == 0) {
        array_push($errors['password']['repeat_password'], "New Password must be entered again.");
        addErrors($errors);
        $errors["check"] = false;
    } elseif (strlen($new_tried) < 8) {
        array_push($errors["password"]['new_password'], "New password must be at least 8 characters.");
        array_push($errors["password"]['repeat_password'], "");
        addErrors($errors);
        $errors["check"] = false;
    } elseif ($new_tried != $repeat_tried) {
        array_push($errors['password']["new_password"], "New Passwords do not match.");
        array_push($errors['password']["repeat_password"], null);
        addErrors($errors);
        $errors["check"] = false;
    } elseif ($new_tried == $current_tried) {
        array_push($errors['password']["new_password"], "New password must be different.");
        addErrors($errors);
        $errors["check"] = false;
    }


    $user = getCurrentUser();
    $old_password = $user['password'];
    if (!password_verify($current_tried, $old_password) && $current_tried != null) {
        array_push($errors['password']['current'], "Incorrect Current Password.");
        addErrors($errors);
        $errors["check"] = false;
    }


    if ($errors["check"] == false) {
        addErrors($errors);
    }


    return $errors["check"];
}

function changePassword($new_tried, $username)
{
    if (setPassword($new_tried, $username)) {
        array_push($messages, "Password changed successfully.");
        addMessages($messages);
        redirectToProfile();
    }
}

if (isset($_POST['submit'])) {
    handlePasswordChange();
}
