<?php

namespace Controllers;

use Validation\CreateUserValidator;
use Validation\UserDetailsValidator;
use Validation\deleteUserValidator;

class AdminController
{
    public $errors = array();
    public $messages = array();
    public $v;


    public function index($view)
    {
        isAdmin();
        view($view); // Overall/ Users / Posts / Access
    }


    //CREATE USER

    function store($role)
    {
        isLoggedIn();
        isAdmin();
        $data = (new CreateUserValidator)->validate($_REQUEST, $role . "-");
        $this->checkNewUser($data[$role . "-fullname"], $data[$role . "-username"], $data[$role . "-email"], $data[$role . "-password"], $role);
    }


    private function checkNewUser($fullname, $username, $email, $password, $role)
    {
        switch ($role) {
            case 'admin':
                createUser(0, $fullname, $username, $email, $password);
                break;
            case 'client':
                createUser(1, $fullname, $username, $email, $password);
                break;
        }

        $user = getUserByUsername($username);
        mkdir(basePath("/assets/media/") . $user['user_id']);
        $messages[$role] = array();
        array_push($messages[$role], "New " . ucfirst($role) . " created");
        addMessages($messages);
        redirectToAdmin('access');
    }




    //DELETE USER
    public function destroy($user_id)
    {
        isLoggedIn();
        isAdmin();

        $data = (new deleteUserValidator)->validate(array_merge($_REQUEST, ['user_id' => $user_id]));

        $this->checkDeleteUser($user_id);
    }


    private function checkDeleteUser($user_id)
    {
        if (deleteUser($user_id)) {

            $messages["changes"] = array();
            array_push($messages["changes"], "User deleted successfully");
            addMessages($messages);
            redirectToAdmin('users');
        } else {

            $errors['changes'] = array();
            array_push($errors["changes"], "User not found");
            addErrors($errors);
            redirectToAdmin('users');
        }
    }




    //CHANGE USER
    public function edit($user_id)
    {
        isAdmin();

        $data = (new UserDetailsValidator)->validate(array_merge($_REQUEST, ["user_id" => $user_id]));

        $user = getUserByID($user_id);

        $this->checkChangeUser($user['username'], $user['email'], $data["new_username"], $data['new_email']);
    }


    private function checkChangeUser($username, $email, $new_username, $new_email)
    {
        if (setDetails($username, $email, $new_username, $new_email)) {

            $messages['changes'] =  ["User information changed successfully"];
            addMessages($messages);

            redirectToAdmin('users');
        }
    }
}
