<?php

namespace Controllers;

class ProfileController
{
    public $errors = array();
    public $messages = array();



    public function index()
    {
        view('profile');
    }

    // CHANGE AVATAR
    public function changeAvatar()
    {
        isLoggedIn();
        $_SESSION['tab'] = "avatar";
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];

        $file_ext = strtolower(pathinfo(basename($_FILES["new-avatar"]["name"]), PATHINFO_EXTENSION));
        $file_size = $_FILES['new-avatar']['size'];

        $this->checkFileReq($file_ext, $file_size);
        $this->checkChangeAvatar($user_id, $username, $file_ext, $file_size);
    }
    private function checkFileReq($file_ext, $file_size)
    {
        $errors["avatar"] = array();
        if (!(in_array($file_ext, ["jpeg", "jpg", "png"]))) {
            array_push($errors["avatar"], "Extension not correct, please choose a JPEG or PNG file.");
        }
        if ($file_size > 10485760) {
            array_push($errors["avatar"], "File size must be less than 10 MB");
        }

        if (!empty($errors["avatar"])) {
            addErrors($errors);
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



    //CHANGE DETAILS
    public function changeDetails()
    {
        isLoggedIn();
        $_SESSION['tab'] = "details";
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];

        $this->checkDetailsForm($new_username, $new_email, $user_id);
        $this->checkChangeDetails($username, $email, $new_username, $new_email);
    }
    private function checkDetailsForm($new_username, $new_email, $user_id)
    {
        $errors["details"] = array();
        $errors["details"]['username'] = array();
        $errors["details"]['email'] = array();


        if (strlen($new_username) < 5) {
            array_push($errors["details"]['username'], "An Username must be more than 5 characters.");
        }
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors["details"]['email'], "Invalid email format.");
        }
        if (!verifyUsernameUnique($new_username, [$user_id])) {
            array_push($errors["details"]['username'], "Username already taken.");
        }
        if (!verifyEmailUnique($new_email, [$user_id])) {
            array_push($errors["details"]["email"], "Email already taken.");
        }
        if (!empty($errors["details"]['username']) || !empty($errors["details"]['email'])) {
            addErrors($errors);
            if (empty($errors["details"]['username'])) {
                $_SESSION["input"]["username"] = $_POST["new_username"];
            }
            if (empty($errors["details"]["email"])) {
                $_SESSION["input"]["email"] = $_POST["new_email"];
            }
            redirectToProfile();
        }
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
        $user_id = $_SESSION["user_id"];
        $current_tried = $_POST['current_password'];
        $new_tried = $_POST['new_password'];
        $repeat_tried = $_POST['repeat_password'];

        $this->checkPasswordForm($current_tried, $new_tried, $repeat_tried);
        $this->checkChangePassword($new_tried, $user_id);
    }


    private function checkPasswordForm($current_tried, $new_tried, $repeat_tried)
    {
        $errors["password"] = array();
        $errors["password"] = array();
        $errors["password"]['current'] = array();
        $errors["password"]['new_password'] = array();
        $errors["password"]['repeat_password'] = array();

        if (strlen($current_tried) == 0) {
            array_push($errors['password']['current'], "Current Password must be entered.");
            addErrors($errors);
        }

        if (strlen($new_tried) == 0) {
            array_push($errors['password']['new_password'], "New Password must be entered.");
            addErrors($errors);
        } elseif (strlen($repeat_tried) == 0) {
            array_push($errors['password']['repeat_password'], "New Password must be entered again.");
            addErrors($errors);
        } elseif (strlen($new_tried) < 8) {
            array_push($errors["password"]['new_password'], "New password must be at least 8 characters.");
            array_push($errors["password"]['repeat_password'], "");
            addErrors($errors);
        } elseif ($new_tried != $repeat_tried) {
            array_push($errors['password']["new_password"], "New Passwords do not match.");
            array_push($errors['password']["repeat_password"], null);
            addErrors($errors);
        } elseif ($new_tried == $current_tried) {
            array_push($errors['password']["new_password"], "New password must be different.");
            addErrors($errors);
        }


        $user = getCurrentUser();
        $old_password = $user['password'];
        if (!password_verify($current_tried, $old_password) && $current_tried != null) {
            array_push($errors['password']['current'], "Incorrect Current Password.");
        }


        if (
            !empty($errors['password']['current']) ||
            !empty($errors['password']['new_password']) ||
            !empty($errors['password']['repeat_password'])
        ) {
            addErrors($errors);
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
        $user_id = $_SESSION['user_id'];

        if ($user_id != $user["user_id"]) {
            $auth = new AuthController;
            $auth->userLogout();
        }
        $password = $_POST['password'];

        $this->checkDeleteSelfForm($password);
        $this->checkDeleteSelf($user_id, $password);
    }


    private function checkDeleteSelfForm($password)
    {
        $errors['delete'] = array();
        if (empty($password)) {
            array_push($errors, "Password is required");
            addErrors($errors);
        }

        $user = getCurrentUser();
        $saved_password = $user['password'];
        if (password_verify($password, $saved_password)) {
            $this->checkDeleteSelf($user["user_id"]);
        } else {
            array_push($errors['delete'], "Wrong password was entered");
            addErrors($errors);
            redirectToProfile();
        }
    }
    private function checkDeleteSelf($user_id)
    {
        if (deleteUser($user_id)) {
            $errors['user'] = array();
            array_push($errors["user"], "User deleted successfully");
            addErrors($errors);
            header("Location: /auth/logout");
        }
    }
}
