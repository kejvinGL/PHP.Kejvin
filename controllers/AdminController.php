<?php

namespace Controllers;

use Validation\CreateUserValidator;
use Validation\UserDetailsValidator;
use Validation\deleteUserValidator;

class AdminController
{
    public $errors = array();
    public $messages = array();



    public function showOverall()
    {
        view('overall');
    }

    public function showUsers()
    {
        view('users');
    }

    public function showPosts()
    {
        view('posts');
    }

    public function showAccess()
    {
        view('access');
    }



    //CREATE USER

    function store(string $role)
    {
        isLoggedIn();
        isAdmin();
        $data = (new CreateUserValidator($role . "-"))->validate();
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
    public function destroy(int $user_id)
    {
        isLoggedIn();
        isAdmin();

        $user = getUserByID($user_id);

        $data = (new deleteUserValidator)->validate($user);

        $this->checkDeleteUser($user_id);
    }


    private function checkDeleteUser(int $user_id)
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
    public function edit(int $user_id)
    {
        isAdmin();

        $data = (new UserDetailsValidator)->validate($user_id);

        $user = getUserByID($user_id);

        $this->checkChangeUser($user['username'], $user['email'], $data["new_username"], $data['new_email']);
    }


    private function checkChangeUser(string $username, string $email, string $new_username, string $new_email)
    {
        if (setDetails($username, $email, $new_username, $new_email)) {

            $messages['changes'] =  ["User information changed successfully"];
            addMessages($messages);

            redirectToAdmin('users');
        }
    }
}
