<?php
isLoggedIn();
isAdmin();

$errors = array();
$errors["changes"] = array();

function handleUserDelete()
{
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];

    if (checkFormReq($password)) {
        checkDeleteUser($user_id, $password);
    } else {
        redirectToProfile();
    }
}

function checkFormReq($password): bool
{
    $errors = array();
    $errors["changes"];
    if (empty($password)) {
        array_push($errors["changes"], "Password is required");
        addErrors($errors);
        return false;
    }
    return true;
}

function checkDeleteUser($user_id, $password)
{
    $errors = array();
    $errors['changes'] = array();
    $user = getCurrentUser();
    $saved_password = $user['password'];
    if (password_verify($password, $saved_password)) {
        if (deleteUser($user_id)) {
            array_push($errors["changes"], "User deleted successfully");
            addMessages($errors);
            redirectToUserlist();
        }
    } else {
        array_push($errors['changes'], "Wrong password was entered");
        addErrors($errors);
        redirectToUserList();
    }
}

function redirectToUserList()
{
    header("Location: /views/users.php");
}

if (isset($_POST['delete'])) {
    handleUserDelete();
}
