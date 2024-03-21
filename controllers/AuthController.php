<?php


namespace Controllers;

use Validation\CreateUserValidator;
use Validation\LoginValidator;

class AuthController
{
    public $errors = array();
    public $v;


    public function index($view)
    {
        isLoggedIn();
        view($view); // Login / Register
    }


    //REGISTER
    public function store()
    {
        $data = (new CreateUserValidator)->validate($_REQUEST);
        $this->checkRegister($data["fullname"], $data["username"], $data["email"], $data["password"]);
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

    public function login()
    {
        $data = (new LoginValidator)->validate($_REQUEST);

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
        session_unset();
        redirectToAuth('login');
    }
}
