<?php


namespace Controllers;

use Models\User;
use stdClass;
use Validation\CreateUserValidator;
use Validation\LoginValidator;
use Validation\Validator;

class AuthController
{
    public static function showLogin(): void
    {

        view("login");
    }


    public static function showRegister(): void
    {

        view("register");
    }




    //REGISTER
    public static function store(string $options = ""): void
    {
        try {
            $data = (new CreateUserValidator($options))->validate();

            self::checkRegister($data["fullname"], $data["username"], $data["email"], $data["password"]);
        } catch (\Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while registering"]]);
        }
        redirectBack();
    }


    private static function checkRegister($fullname, $username, $email, $password): void
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        User::insert(["role_id" => 1, "fullname" => $fullname, 'username' => $username, "email" => $email, "password" => $hashed_password]);
        $user = User::select(['username' => $username])[0];
        setUserSession($user);
        mkdir(basePath("/assets/media/") . $user['ID']);
    }




    // LOGIN

    public static function login(): void
    {
        try {
            $data = (new LoginValidator())->validate();
            self::checkLogin($data["username"]);
        } catch (\Exception $e) {
            Validator::addErrors(["database" => ["An error occurred while logging in"]]);
            redirectBack();
        }
        header("Location: /home");
    }

    private static function checkLogin($username): void
    {

        $user = User::select(['username' => $username])[0];
        if (!$user) {
            Validator::addErrors(["user" => ["Invalid username or password"]]);
            redirectBack();
        }
        User::update(['last_login' => date('Y-m-d H:i:s')], ['ID' => $user["ID"]]);
        unset($_SESSION["input"]);
        unset($_SESSION["errors"]);
        setUserSession($user);
        exit();
    }




    //LOGOUT

    public static function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['darkmode']);
        header("Location: /login");
        exit();
    }
}
