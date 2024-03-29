<?php

namespace Controllers;

use Exception;
use Models\Media;
use Models\User;
use Validation\deleteUserValidator;
use Validation\UserAvatarValidator;
use Validation\UserDetailsValidator;
use Validation\UserPasswordValidator;
use Validation\Validator;

class ProfileController
{


    public static function index()
    {

        $data = ["avatar" => User::getCurrentAvatar()];

        view('profile', $data);
    }

    // CHANGE AVATAR
    public static function changeAvatar()
    {

        try {

            $_SESSION['tab'] = "avatar";

            $file = (new UserAvatarValidator)->validate();

            $username = $_SESSION['username'];
            $user_id = $_SESSION['user_id'];

            self::checkChangeAvatar($user_id, $username, $file["ext"], $file["size"]);
        } catch (\Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while registering"]]);
        }
        redirectBack();
    }


    private static function checkChangeAvatar($user_id, $username, $file_ext, $file_size)
    {

        $hash_name = bin2hex(random_bytes(20));
        $target_dir = basePath("assets/media/") . $user_id;
        $saved_path = $user_id . '/' . $hash_name . '.' . $file_ext;
        $file_name = $username . "_" . $user_id;
        $file_path = $target_dir . '/' . $hash_name . '.' . $file_ext;

        //DELETE CURRENT AVATAR(IF IT EXISTS)
        if (User::hasAvatar($user_id)) {
            $avatar = User::getAvatar($user_id);
            $delete_file_path = $target_dir . '/' . $avatar["hash_name"] . '.' . $avatar["extension"];
            unlink($delete_file_path);
            Media::delete(['user_id' => $user_id]);
        }
        // CREATE PERSONAL DIRECTORY (IF IT DOES NOT EXIST)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        //SET NEW AVATAR / SAVE NEW FILE
        if (Media::insert([
            "path" => $saved_path,
            "hash_name" => $hash_name,
            "original_name" => $file_name,
            "extension" => $file_ext,
            "size" => $file_size,
            "type" => "avatar",
            "user_id" => $_SESSION['user_id']
        ])) {
            move_uploaded_file($_FILES["avatar"]["tmp_name"], $file_path);
            $messages["avatar"] = ["Avatar changed successfully"];
            Validator::addMessages($messages);
        }
    }


    //CHANGE DETAILS
    public static function changeDetails(): void
    {

        try {

            $_SESSION['tab'] = "details";
            $data = (new UserDetailsValidator)->validate($_SESSION["user_id"]);

            self::checkChangeDetails($_SESSION['username'], $_SESSION['email'], $data["new_username"], $data['new_email']);
        } catch (Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while registering"]]);
        }
        redirectBack();
    }

    private static function checkChangeDetails($username, $email, $new_username, $new_email): void
    {
        if (User::update(
            ['username' => $new_username, 'email' => $new_email],
            ['username' => $username, 'email' => $email]
        )) {

            $messages["avatar"] = ["User updated successfully!"];
            Validator::addMessages($messages);

            $_SESSION['username'] = $new_username;
            $_SESSION['email'] = $new_email;
        }
    }


    //CHANGE PASSWORD
    public static function changePassword()
    {
        try {
            $_SESSION['tab'] = "password";
            $user = User::select(['username' => $_SESSION["username"]])[0];
            $file = (new UserPasswordValidator)->validate($user["password"]);
            $user_id = $_SESSION["user_id"];
            $new_password = $file['new_password'];
            self::checkChangePassword($new_password, $user_id);
        } catch (Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while registering"]]);
        }
        redirectBack();
    }


    private static function checkChangePassword($new_password, $user_id)
    {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        if (User::update(['password' => $new_password], ['user_id' => $user_id])) {
            $messages = array();
            $messages["avatar"] = ["Password changed successfully."];
            Validator::addMessages($messages);;
        }
    }




    //DELETE SELF
    public static function deleteSelf()
    {
        try {
            $user = User::select(['username' => $_SESSION["username"]])[0];
            if ($user["user_id"] != $_SESSION["user_id"]) {
                header("Location: /auth/logout");
                exit();
            }

            $data = (new deleteUserValidator)->validate($user);
            self::checkDeleteSelf($user["user_id"]);
        } catch (\Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while registering"]]);
        }
        redirectBack();
    }


    private static function checkDeleteSelf($user_id)
    {
        if (User::delete(["user_id" => $user_id])) {
            header("/auth/logout");
        }
    }
}
