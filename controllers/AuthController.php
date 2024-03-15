<?php
class AuthController
{

    // REGISTER

    public function clientRegister()
    {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $this->checkRegForm($fullname, $username, $email, $password);
        $this->checkRegister($fullname, $username, $email, $password);
    }


    private function checkRegForm($fullname, $username, $email, $password)
    {
        $errors["fullname"] = array();
        $errors["username"] = array();
        $errors["email"] = array();
        $errors["password"] = array();
        $errors["check"] = true;

        if (empty($username)) {
            $errors["username"][] = "Username cannot be empty.";
            $errors["check"] = false;
        }
        if (empty($password)) {
            $errors["password"][] = "Password cannot be empty.";
            $errors["check"] = false;
        }
        if (empty($fullname)) {
            $errors["fullname"][] = "Fullname cannot be empty.";
            $errors["check"] = false;
        }
        if (empty($email)) {
            $errors["email"][] = "Email cannot be empty.";
            $errors["check"] = false;
        }
        if ((!preg_match('/^[a-zA-Z ]+$/', $fullname))) {
            $errors["fullname"][] = "Full name not valid";
            $errors["check"] = false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"][] = "Email not valid";
            $errors["check"] = false;
        }
        if (strlen($password) < 8) {
            $errors["password"][] = "Password must be at least 8 characters long";
            $errors["check"] = false;
        }
        if (!$errors["check"]) {
            $this->handleIncorrectRegister($errors);
        }
    }

    private function checkRegister($fullname, $username, $email, $password): void
    {
        $this->checkIncorrectRegister($username, $email);
        createClient($fullname, $username, $email, $password);
        $user = getUserByUsername($username);
        setUserSession($user);
        mkdir(basePath("/assets/media/") . $user['user_id']);
        redirectToHome();
    }

    private function checkIncorrectRegister($username, $email): void
    {
        $errors = array();
        $errors["username"] = array();
        $errors["email"] = array();
        $errors["check"] = true;

        //CHECK IF USERNAME EXISTS
        if (!verifyUsernameUnique($username)) {
            unset($_SESSION["input"]["username"]);
            $errors["username"][] = "Username already exists.";
            $errors["check"] = false;
        }
        //CHECK IF EMAIL EXISTS
        if (!verifyEmailUnique($email)) {
            unset($_SESSION["input"]["email"]);
            $errors["email"][] = "Email already in use.";
            $errors["check"] = false;
        }

        if (!$errors["check"]) {
            $this->handleIncorrectRegister($errors);
        }
    }

    private function handleIncorrectRegister($errors)
    {
        addErrors($errors);
        if (empty($errors["username"])) {
            $_SESSION["input"]["username"] = $_POST["username"];
        } else {
            unset($_SESSION["input"]["username"]);
        }
        if (empty($errors["email"])) {
            $_SESSION["input"]["email"] = $_POST["email"];
        } else {
            unset($_SESSION["input"]["email"]);
        }
        if (empty($errors["fullname"])) {
            $_SESSION["input"]["fullname"] = $_POST["fullname"];
        } else {
            unset($_SESSION["input"]["fullname"]);
        }
        redirectToRegister();
    }




    // LOGIN

    public function userLogin()
    {
        $username = $_GET["username"];
        $password = $_GET["password"];
        $this->checkLoginForm($username, $password);
        $this->checkLogin($username, $password);
    }

    private function checkLoginForm($username, $password)
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
        } elseif (strlen($password) < 8) {
            array_push($errors["password"], "Password must be at least 8 characters long");
            $errors["check"] = false;
        }
        if (!$errors["check"]) {
            $this->handleIncorrectLoginForm($errors);
        }
    }

    private function checkLogin($username, $password)
    {
        $user = getUserByUsername($username);
        $username = "";
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $username = $user['username'];
                setUserLastLogin($user['user_id']);
                setUserSession($user);
                unset($_SESSION["input"]);
                unset($_SESSION["errors"]);
                redirectToHome();
            } else {
                $this->handleIncorrectLogin($user["username"]);
            }
        } else {
            $this->handleIncorrectLogin($username);
        }
    }

    private function handleIncorrectLogin($username)
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

    private function handleIncorrectLoginForm($errors)
    {
        addErrors($errors);
        if (empty($errors["username"])) {
            $_SESSION["input"]["username"] = $_POST["username"];
        } else {
            unset($_SESSION["input"]["username"]);
        }
        redirectToLogin();
    }




    //LOGOUT

    public function userLogout()
    {
        session_start();
        session_unset();
        redirectToLogin();
    }
}
