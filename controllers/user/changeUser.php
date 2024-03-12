<?php
isLoggedIn();


function handleUserChange()
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $user_id = $_POST['user_id'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    if (checkUserReq($new_username, $new_email, $user_id)) {
        changeUser($username, $email, $new_username, $new_email);
    } else {
        redirectToUserList();
    }
}




function checkUserReq($new_username, $new_email, $user_id)
{
    $errors = array();
    $errors["changes"] = array();
    $errors["check"] = true;
    if (strlen($new_username) < 5) {
        array_push($errors["changes"], "An Username must be more than 5 characters.");
        $errors["check"] = false;
    }
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors["changes"], "Invalid email format.");
        $errors["check"] = false;
    }
    if (!verifyUsernameUnique($new_username, [$user_id])) {
        array_push($errors["changes"], "Username already taken.");
        $errors["check"] = false;
    }
    if (!verifyEmailUnique($new_email, [$user_id])) {
        array_push($errors["changes"], "Email already taken.");
        $errors["check"] = false;
    }

    if ($errors["check"] == false) {
        addErrors($errors);
    }
    return $errors["check"];
}

function changeUser($username, $email, $new_username, $new_email)
{
    if (setDetails($username, $email, $new_username, $new_email)) {
        $messages = array();
        array_push($messages['changes'], "User information changed successfully");
        if ($username == $_SESSION["username"]) {
            $_SESSION["username"] = $new_username;
        }
        if ($email == $_SESSION["email"]) {
            $_SESSION["username"] = $new_username;
        }
        addMessages($messages);
        redirectToUserList();
    }
}


if (isset($_POST['edit'])) {
    handleUserChange();
}
