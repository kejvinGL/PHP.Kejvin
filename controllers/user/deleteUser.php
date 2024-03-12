<?php
isLoggedIn();
isAdmin();



function handleUserDelete()
{
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    if (checkFormReq($password)) {
        checkDeleteUser($user_id, $password);
    } else {
        redirectToUserList();
    }
}

function checkFormReq($password): bool
{
    $errors = array();
    $errors["changes"] = array();
    $errors['check'] = true;
    $user = getCurrentUser();
    $saved_password = $user['password'];

    if (empty($password)) {
        array_push($errors["changes"], "Password is required");
        $errors['check'] = false;
    } elseif (!password_verify($password, $saved_password)) {
        array_push($errors["changes"], "Wrong password was entered");
        $errors['check'] = false;
    }


    if ($errors['check'] == false) {
        addErrors($errors);
    }

    return $errors["check"];
}

function checkDeleteUser($user_id)
{
    if (deleteUser($user_id)) {
        $messages = array();
        array_push($messages, "User deleted successfully");
        addMessages($messages);
        redirectToUserList();
    }
}


if (isset($_POST['delete'])) {
    handleUserDelete();
}
