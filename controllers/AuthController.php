<?php


namespace Controllers;

use Validation\CreateUserValidator;
use Validation\LoginValidator;

class AuthController
{
    public function showLogin(): void
    {
        isLoggedIn();
        view("login");
    }


    public function showRegister(): void
    {
        isLoggedIn();
        view("register");
    }




    //REGISTER
    public function store(string $options): void
    {
        $data = (new CreateUserValidator($options))->validate();

        $this->checkRegister($data["fullname"], $data["username"], $data["email"], $data["password"]);
    }


    private function checkRegister($fullname, $username, $email, $password): void
    {
        createUser(1, $fullname, $username, $email, $password);
        $user = getUserByUsername($username);
        setUserSession($user);
        mkdir(basePath("/assets/media/") . $user['user_id']);
        redirectBack();
    }




    // LOGIN

    public function login(): void
    {
        $data = (new LoginValidator)->validate();

        $this->checkLogin($data["username"]);
    }

    private function checkLogin($username): void
    {
        $user = getUserByUsername($username);
        setUserLastLogin($user['user_id']);
        setUserSession($user);
        unset($_SESSION["input"]);
        unset($_SESSION["errors"]);
        redirectBack();
    }




    //LOGOUT

    public function logout(): void
    {
        unsetUserSession();
        redirectToAuth('login');
    }
}
