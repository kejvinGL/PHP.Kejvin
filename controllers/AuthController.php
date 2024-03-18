<?php

namespace Controllers;


class AuthController
{
    public $errors = array();


    public function index($view)
    {
        view($view); // Login / Register
    }


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

        //CHECK USERNAME
        if (empty($username)) {
            array_push($errors["username"], "Username cannot be empty.");
        } elseif (!verifyUsernameUnique($username)) {
            array_push($errors["username"], "Username already exists.");
        }
        //CHECK PASSWORD
        if (empty($password)) {
            array_push($errors["password"], "Password cannot be empty.");
        } elseif (strlen($password) < 8) {
            array_push($errors["password"], "Password must be at least 8 characters long");
        }
        //CHECK FULLNAME
        if (empty($fullname)) {
            array_push($errors["fullname"], "Fullname cannot be empty.");
        } elseif ((!preg_match('/^[a-zA-Z ]+$/', $fullname))) {
            array_push($errors["fullname"], "Full name not valid");
        }

        //CHECK EMAIL
        if (empty($email)) {
            array_push($errors["email"], "Email cannot be empty.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors["email"], "Email not valid");
        } elseif (!verifyEmailUnique($email)) {
            array_push($errors["email"], "Email already in use.");
        }

        // IF ERRORS WHERE FOUND:
        if (
            !empty($errors["fullname"]) ||
            !empty($errors["username"]) ||
            !empty($errors["email"]) ||
            !empty($errors["password"])
        ) {
            addErrors($errors);
            unset($_SESSION["input"]);
            if (empty($errors["username"])) {
                $_SESSION["input"]["username"] = $_POST["username"];
            }
            if (empty($errors["email"])) {
                $_SESSION["input"]["email"] = $_POST["email"];
            }
            if (empty($errors["fullname"])) {
                $_SESSION["input"]["fullname"] = $_POST["fullname"];
            }
            redirectToAuth('register');
        }
    }

    private function checkRegister($fullname, $username, $email, $password): void
    {
        createUser(1, $fullname, $username, $email, $password);
        $user = getUserByUsername($username);
        setUserSession($user);
        mkdir(basePath("/assets/media/") . $user['user_id']);
        redirectToHome();
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
        $errors["username"] = array();
        $errors["password"] = array();
        if (empty($username)) {
            array_push($errors["username"], "Username is required.");
        }
        if (empty($password)) {
            array_push($errors["password"], "Password is required.");
        } elseif (strlen($password) < 8) {
            array_push($errors["password"], "Password must be at least 8 characters long");
        }
        if (!empty($errors["username"]) || !empty($errors["password"])) {
            addErrors($errors);
            if (!empty($errors["username"])) {
                $_SESSION["input"]["username"] = $username;
            } else {
                unset($_SESSION["input"]["username"]);
            }
            redirectToAuth('login');
        }
    }

    private function checkLogin($username, $password)
    {
        $user = getUserByUsername($username);
        if (!$user) {
            $this->handleIncorrectLogin();
        } elseif (password_verify($password, $user['password'])) {
            $username = $user['username'];
            setUserLastLogin($user['user_id']);
            setUserSession($user);
            unset($_SESSION["input"]);
            unset($_SESSION["errors"]);
            getCurrentUserRole() === 0 ? redirectToAdmin('overall') : redirectToHome();
        } else {
            $this->handleIncorrectLogin($user["username"]);
        }
    }

    private function handleIncorrectLogin($username = null)
    {
        $errors["username"] = array();
        $errors["password"] = array();
        if ($username) {
            $_SESSION["input"]["username"] = $username;
            array_push($errors["password"], "Incorrect Password.");
            addErrors($errors);
        } else {
            unset($_SESSION["input"]["username"]);
            array_push($errors["username"], "");
            array_push($errors["password"], "No User found with these credentials.");
            addErrors($errors);
        }

        redirectToAuth('login');
    }




    //LOGOUT

    public function userLogout()
    {
        session_unset();
        redirectToAuth('login');
    }
}
