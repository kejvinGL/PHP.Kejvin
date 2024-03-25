<?php

namespace Controllers;

use Validation\deleteUserValidator;
use Validation\UserAvatarValidator;
use Validation\UserDetailsValidator;
use Validation\UserPasswordValidator;

class ProfileController
{


    public function index()
    {
        isLoggedIn();
        view('profile');
    }

    // CHANGE AVATAR
    public function changeAvatar()
    {
        isLoggedIn();

        $_SESSION['tab'] = "avatar";

        $file = (new UserAvatarValidator)->validate();

        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];

        $this->checkChangeAvatar($user_id, $username, $file["ext"], $file["size"]);
    }


    private function checkChangeAvatar($user_id, $username, $file_ext, $file_size)
    {

        $hash_name = bin2hex(random_bytes(20));
        $target_dir = basePath("assets/media/") . $user_id;
        $saved_path = $user_id . '/' . $hash_name . '.' . $file_ext;
        $file_name = $username . "_" . $user_id;
        $file_path = $target_dir . '/' . $hash_name . '.' . $file_ext;

        //DELETE CURRENT AVATAR(IF EXISTS)
        if (hasUserAvatar($user_id)) {
            $avatar = getUserAvatar($user_id);
            echo $target_dir . $avatar["hash_name"] . '.' . $avatar["extension"];
            $delete_file_path = $target_dir . '/' . $avatar["hash_name"] . '.' . $avatar["extension"];
            unlink($delete_file_path);
            deleteUserAvatar($user_id);
        }
        // CREATE PERSONAL DIRECTORY (IF DOES NOT EXISTS)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        //SET NEW AVATAR / SAVE NEW FILE
        if (setUserAvatar($saved_path, $hash_name, $file_name, $file_ext, $file_size, $user_id)) {
            move_uploaded_file($_FILES["avatar"]["tmp_name"], $file_path);
            $messages["avatar"] = ["Avatar changed successfully"];
            addMessages($messages);
            redirectToProfile();
        }
    }


    //CHANGE DETAILS
    public function changeDetails()
    {
        isLoggedIn();

        $_SESSION['tab'] = "details";

        $data = (new UserDetailsValidator)->validate($_SESSION["user_id"]);

        $this->checkChangeDetails($_SESSION['username'], $_SESSION['email'], $data["new_username"], $data['new_email']);
    }

    private function checkChangeDetails($username, $email, $new_username, $new_email): void
    {
        if (setDetails($username, $email, $new_username, $new_email)) {

            $messages["avatar"] = ["User updated successfully!"];
            addMessages($messages);

            $_SESSION['username'] = $new_username;
            $_SESSION['email'] = $new_email;

            redirectToProfile();
        }
    }


    //CHANGE PASSWORD
    public function changePassword()
    {
        isLoggedIn();

        $_SESSION['tab'] = "password";
        $user = getCurrentUser();
        $file = (new UserPasswordValidator)->validate($user["password"]);

        $user_id = $_SESSION["user_id"];
        $new_password = $file['new_password'];
        $this->checkChangePassword($new_password, $user_id);
    }


    private function checkChangePassword($new_password, $user_id)
    {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        if (setPassword($new_password, $user_id)) {
            $messages = array();
            $messages["avatar"] = ["Password changed successfully."];
            addMessages($messages);
            redirectToProfile();
        }
    }




    //DELETE SELF
    public function deleteSelf()
    {
        isLoggedIn();

        $user = getCurrentUser();
        if ($user["user_id"] != $_SESSION["user_id"]) {
            redirectToLogout();
        }

        $data = (new deleteUserValidator)->validate($user);

        $this->checkDeleteSelf($user["user_id"]);
    }


    private function checkDeleteSelf($user_id)
    {
        if (deleteUser($user_id)) {
            redirectToLogout();
        }
    }
}
