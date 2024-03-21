<?php

namespace Controllers;

use Validation\deleteUserValidator;
use Validation\UserDetailsValidator;

class ProfileController
{
    public $errors = array();
    public $messages = array();


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

        $this->v->setFields($_FILES);

        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $file_ext = strtolower(pathinfo(basename($_FILES["avatar"]["name"]), PATHINFO_EXTENSION));
        $file_size = $_FILES['avatar']['size'];

        $this->checkFileReq($file_ext, $file_size);
        $this->checkChangeAvatar($user_id, $username, $file_ext, $file_size);
    }


    private function checkFileReq($file_ext, $file_size)
    {
        $this->v->imgType("avatar", $file_ext);

        $this->v->size("avatar", $file_size);

        if ($this->v->foundErrors()) {
            redirectToProfile();
        }
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
            array_push($this->messages, "Avatar changed successfully");
            addMessages($this->messages);
            redirectToProfile();
        }
    }


    //CHANGE DETAILS
    public function changeDetails()
    {
        isLoggedIn();
        $_SESSION['tab'] = "details";
        $data = (new UserDetailsValidator)->validate(array_merge($_REQUEST, ["user_id" => $_SESSION["user_id"]]));



        $this->checkChangeDetails($_SESSION['username'], $_SESSION['email'], $data["new_username"], $data['new_email']);
    }

    private function checkChangeDetails($username, $email, $new_username, $new_email): void
    {
        if (setDetails($username, $email, $new_username, $new_email)) {

            $messages[] = "User updated successfully!";
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

        $this->v->clearErrors();
        $this->v->setFields($_POST);

        $user_id = $_SESSION["user_id"];
        $new_tried = $_POST['new_password'];

        $this->checkPasswordForm();
        $this->checkChangePassword($new_tried, $user_id);
    }


    private function checkPasswordForm()
    {

        $this->v->required("current_password", "Current password must be entered.")
            ->required("new_password")
            ->required("repeat_password")
            ->minLength("new_password", 8)
            ->matches("new_password", "repeat_password", "New Passwords must match.")
            ->different("new_password", "current_password", "New Password must be different.");


        $user = getCurrentUser();
        $old_password = $user['password'];
        $this->v->checkPassword("current_password", $old_password, "Incorrect Current Password");

        if ($this->v->foundErrors()) {
            redirectToProfile();
        }
    }


    private function checkChangePassword($new_tried, $user_id)
    {
        $new_tried = password_hash($new_tried, PASSWORD_DEFAULT);
        if (setPassword($new_tried, $user_id)) {
            $messages = array();
            array_push($messages, "Password changed successfully.");
            addMessages($messages);
            redirectToProfile();
        }
    }




    //DELETE SELF
    public function deleteSelf()
    {
        isLoggedIn();

        $user = getCurrentUser();
        if ($user["user_id"] != $user["user_id"]) {
            redirectToLogout();
        }

        $data = (new deleteUserValidator)->validate(array_merge($_REQUEST, ["user_id" => $user["user_id"]]));

        $this->checkDeleteSelf($user["user_id"]);
    }


    private function checkDeleteSelf($user_id)
    {
        if (deleteUser($user_id)) {
            redirectToLogout();
        }
    }
}
