<?php


namespace Controllers;

use Validation\CreateUserValidator;
use Validation\LoginValidator;

class AuthController
{
    public function showLogin()
    {
        isLoggedIn();
        view("login");
    }


    public function showRegister()
    {
        isLoggedIn();
        view("register");
    }




    //REGISTER
    public function store(string $options)
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
        getCurrentUserRole() === 0 ? redirectToAdmin('access') : redirectToHome();
    }




    // LOGIN

    public function login()
    {
        $data = (new LoginValidator)->validate();

        $this->checkLogin($data["username"], $data["password"]);
    }

    private function checkLogin($username)
    {
        $user = getUserByUsername($username);
        setUserLastLogin($user['user_id']);
        setUserSession($user);
        unset($_SESSION["input"]);
        unset($_SESSION["errors"]);
        getCurrentUserRole() === 0 ? redirectToAdmin('overall') : redirectToHome();
    }




    //LOGOUT

    public function logout()
    {
        unsetUserSession();
        redirectToAuth('login');
    }
}
