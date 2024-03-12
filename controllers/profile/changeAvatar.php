<?php
isLoggedIn();

function handleAvatarChange()
{
    $_SESSION['tab'] = "avatar";
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $messages = array();
    $file_ext = strtolower(pathinfo(basename($_FILES["new-avatar"]["name"]), PATHINFO_EXTENSION));
    $file_size = $_FILES['new-avatar']['size'];

    if (checkFileReq($file_ext, $file_size)) {
        changeAvatar($user_id, $username, $file_ext, $file_size, $messages);
    } else {
        redirectToProfile();
    }
}

function checkFileReq($file_ext, $file_size)
{
    $errors = array();
    $errors["avatar"] = array();
    $errors["check"] = true;
    if (!(in_array($file_ext, ["jpeg", "jpg", "png"]))) {
        array_push($errors["avatar"], "Extension not correct, please choose a JPEG or PNG file.");
        $errors["check"] = false;
    }
    if ($file_size > 10485760) {
        array_push($errors["avatar"], "File size must be less than 10 MB");
        $errors["check"] = false;
    }

    if ($errors["check"] == false) {
        addErrors($errors);
    }
    return $errors["check"];
}


function changeAvatar($user_id, $username, $file_ext, $file_size, $messages)
{
    $hash_name = bin2hex(random_bytes(20));
    $target_dir = dirname(__DIR__, 2) . "/assets/media/" . $user_id;
    $saved_path = $user_id . '/' . $hash_name . '.' . $file_ext;
    $file_name = $username . "_" . $user_id;
    $file_path = $target_dir . '/' . $hash_name . '.' . $file_ext;
    if (hasUserAvatar($user_id)) {
        $avatar = getUserAvatar($user_id);
        echo $target_dir . $avatar["hash_name"] . '.' . $avatar["extension"];
        $delete_file_path = $target_dir . '/' . $avatar["hash_name"] . '.' . $avatar["extension"];
        unlink($delete_file_path);
        deleteUserAvatar($user_id);
    }
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $avatar = setUserAvatar($saved_path, $hash_name, $file_name, $file_ext, $file_size, $user_id);
    if ($avatar) {
        move_uploaded_file($_FILES["new-avatar"]["tmp_name"], $file_path);
        array_push($messages, "Avatar changed successfully");
        addMessages($messages);
        redirectToProfile();
    }
}


if (isset($_FILES)) {
    handleAvatarChange();
}
