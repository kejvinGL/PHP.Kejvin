<?php
class AdminController
{
    //CREATE USER

    function createUser($role)
    {
        isAdmin();
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];


        $this->checkCreateForm($fullname, $username, $email, $password, $role);
        $this->checkNewUser($fullname, $username, $email, $password, $role);
    }
    private function checkCreateForm($fullname, $username, $email, $password, $role)
    {
        $errors = array();
        $errors[$role] = array();
        $errors[$role]["fullname"] = array();
        $errors[$role]["email"] = array();
        $errors[$role]["username"] = array();
        $errors[$role]["password"] = array();
        $errors["check"] = true;


        //Fullname
        if (empty($fullname)) {
            array_push($errors[$role]["fullname"], "Fullname cannot be empty.");
            $errors["check"] = false;
        } elseif ((!preg_match('/^[a-zA-Z ]+$/', $fullname))) {
            array_push($errors[$role]["fullname"], "Full name not valid");
            $errors["check"] = false;
        }


        //Email
        if (empty($email)) {
            array_push($errors[$role]["email"], "Email cannot be empty.");
            $errors["check"] = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors[$role]["email"], "Email not valid");
            $errors["check"] = false;
        } elseif (!verifyEmailUnique($username, [])) {
            array_push($errors[$role]["email"], "Email already taken.");
            $errors["check"] = false;
        }


        //Username
        if (empty($username)) {
            array_push($errors[$role]["username"], "Username cannot be empty.");
            $errors["check"] = false;
        } elseif (!verifyUsernameUnique($username, [])) {
            array_push($errors[$role]["username"], "Username already taken.");
            $errors["check"] = false;
        }


        //Password
        if (empty($password)) {
            array_push($errors[$role]["password"], "Password cannot be empty.");
            $errors["check"] = false;
        } elseif (strlen($password) < 8) {
            array_push($errors[$role]["password"], "Password must be at least 8 charactes long");
            $errors["check"] = false;
        }

        if ($errors["check"] == false) {
            addErrors($errors);
            redirectToAccess();
        }
    }


    private function checkNewUser($fullname, $username, $email, $password, $role)
    {
        switch ($role) {
            case 'admin':
                createAdmin($fullname, $username, $email, $password);
                break;
            case 'client':
                createClient($fullname, $username, $email, $password);
                break;
        }

        $user = getUserByUsername($username);
        mkdir(basePath("/assets/media/") . $user['user_id']);
        $messages = array();
        $messages[$role] = array();
        array_push($messages[$role], "New " . ucfirst($role) . " created");
        addMessages($messages);
        redirectToAccess();
    }




    //DELETE USER
    public function deleteUser($user_id)
    {
        isAdmin();
        $password = $_POST['password'];

        $this->checkDeleteForm($password);
        $this->checkDeleteUser($user_id, $password);
    }

    private function checkDeleteForm($password)
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
            redirectToUserList();
        }
    }

    private function checkDeleteUser($user_id)
    {
        if (deleteUser($user_id)) {
            $messages = array();
            $messages["changes"] = array();
            array_push($messages["changes"], "User deleted successfully");
            addMessages($messages);
            redirectToUserList();
        }
    }




    //CHANGE USER
    public function changeUser($user_id)
    {
        isAdmin();
        $user = getUserByID($user_id);
        $username = $user['username'];
        $email = $user['email'];
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];
        $this->checkUserReq($new_username, $new_email, $user_id);
        $this->checkChangeUser($username, $email, $new_username, $new_email);
    }

    private function checkUserReq($new_username, $new_email, $user_id)
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
            redirectToUserList();
        }
    }

    private function checkChangeUser($username, $email, $new_username, $new_email)
    {
        if (setDetails($username, $email, $new_username, $new_email)) {
            $messages = array();
            $messages['changes'] = array();
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
}
