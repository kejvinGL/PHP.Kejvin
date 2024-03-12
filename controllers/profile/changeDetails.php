<?php
isLoggedIn();

function handleDetailsChange(): void
{
    $_SESSION['tab'] = "details";
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $errors = array();

    checkFormReq($new_username, $new_email, $user_id);
    changeDetails($username, $email, $new_username, $new_email);
}

function checkFormReq($new_username, $new_email, $user_id)
{
    $errors = array();
    $errors["details"] = array();
    $errors["details"]['username'] = array();
    $errors["details"]['email'] = array();
    $errors["check"] = true;


    if (strlen($new_username) < 5) {
        array_push($errors["details"]['username'], "An Username must be more than 5 characters.");
        $errors["check"] = false;
    }
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors["details"]['email'], "Invalid email format.");
        $errors["check"] = false;
    }
    if (!verifyUsernameUnique($new_username, [$user_id])) {
        array_push($errors["details"]['username'], "Username already taken.");
        $errors["check"] = false;
    }
    if (!verifyEmailUnique($new_email, [$user_id])) {
        array_push($errors["details"]["email"], "Email already taken.");
        $errors["check"] = false;
    }
    if ($errors["check"] == false) {
        handleErrorReport($errors);
    }
}


function handleErrorReport($errors)
{

    if (empty($errors["details"]['username'])) {
        $_SESSION["input"]["username"] = $_POST["new_username"];
    } else {
        unset($_SESSION["input"]["username"]);
    }
    if (empty($errors["details"]['email'])) {
        $_SESSION["input"]["email"] = $_POST["new_email"];
    } else {
        unset($_SESSION["input"]["email"]);
    }
    addErrors($errors);
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


if (isset($_POST["submit"])) {
    handleDetailsChange();
}
