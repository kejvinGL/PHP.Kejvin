<?php


/**
 * Handles the login process for the user.
 *
 * @return void
 */
function handleLogin()
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    checkFormReq($username, $password);
    checkLogin($username, $password);
}


/**
 * Checks the username and password entered for user login.
 *
 *
 * @param string $username The username entered by the user.
 * @param string $password The password entered by the user.
 * @return void
 */
function checkFormReq($username, $password)
{
    $errors = array();
    $errors["username"] = array();
    $errors["password"] = array();
    $errors["check"] = true;
    if (empty($username)) {
        array_push($errors["username"], "Username is required.");
        $errors["check"] = false;
    }
    if (empty($password)) {
        array_push($errors["password"], "Password is required.");
        $errors["check"] = false;
    } elseif (strlen($_POST["password"]) < 8) {
        array_push($errors["password"], "Password must be at least 8 characters long");
        $errors["check"] = false;
    }
    if (!$errors["check"]) {
        handleIncorrectFormReq($errors);
    }
}


/**
 * Handles the request when the form submission is incorrect.
 *
 * @param array $errors An array containing the validation errors.
 * @return void
 */
function handleIncorrectFormReq($errors)
{
    addErrors($errors);
    if (empty($errors["username"])) {
        $_SESSION["input"]["username"] = $_POST["username"];
    } else {
        unset($_SESSION["input"]["username"]);
    }
    redirectToLogin();
}


/**
 * Checks whether the valid form submission is corresponds to a registered user.
 *
 * @param string $username The username of the user.
 * @param string $password The password of the user.
 * @return bool Returns true if the login credentials are valid, false otherwise.
 */
function checkLogin($username, $password)
{
    $user = getUserByUsername($username);
    $username = "";
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $username = $user['username'];
            setUserLastLogin($user['user_id']);
            setUserSession($user);
            redirectToHome();
        } else {
            handleIncorrectLogin($user["username"]);
        }
    } else {
        handleIncorrectLogin($username);
    }
}


/**
 * Handles the cases when an user wasn't found with the form submission.
 *
 * @param string $username The username used in the login attempt.
 * @return void
 */
function handleIncorrectLogin($username)
{
    $errors = array();
    $errors["username"] = array();
    $errors["password"] = array();
    if ($username) {
        $_SESSION["input"]["username"] = $username;
        array_push($errors["password"], "Incorrect Password.");
        addErrors($errors);
    } else {
        unset($_SESSION["input"]["username"]);
        array_push($errors["password"], "No User found with these credentials.");
        addErrors($errors);
    }
    redirectToLogin();
}


/**
 * Sets the user data in the session.
 *
 * @param mixed $user The user object or data to be stored in the session.
 * @return void
 */
function setUserSession($user)
{
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['darkmode'] = $user['darkmode'];
}

/**
 * Redirects the user to /Home.
 *
 * @return void
 */
function redirectToHome()
{
    unset($_SESSION["input"]);
    unset($_SESSION["errors"]);
    header("Location: /views/");
    exit();
}

/**
 * Redirects the user to /Login.
 *
 * @return void
 */
function redirectToLogin()
{
    header("Location: /views/login");
    exit();
}

if (isset($_POST["submit"])) {
    handleLogin();
}
