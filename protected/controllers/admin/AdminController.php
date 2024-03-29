<?php

namespace Controllers\Admin;

use Models\Post;
use Models\User;
use Models\Media;
use Validation\CreateUserValidator;
use Validation\UserDetailsValidator;
use Validation\deleteUserValidator;
use Validation\Validator;

class AdminController
{

    public static function showOverall(): void
    {
        try {

            $data = [
                'totalClients' => User::totalClients(),
                'totalAdmins' => User::totalAdmins(),
                'totalPosts' => count(Post::all()),
                'recentPosts' => Post::recentPosts() . "(last 24h)",
            ];
            view('overall', $data);
        } catch (\Exception $e) {
            Validator::addErrors(['user' => ["An error occurred while getting data"]]);
            redirectBack();
        }
    }

    public static function showUsers(): void
    {
        try {
            $data = [];
            foreach (User::all() as $user) {
                $user["avatar"] = User::getAvatarPath($user["ID"]);
                $user["role"] = User::getRole($user["ID"]);
                $user['posts'] = count(Post::select(["user_id" => $user['ID']]));
                array_push($data, $user);
            }
        } catch (\Exception $e) {
            Validator::addErrors(['user' => ["An error occurred while getting data"]]);
            redirectBack();
        }

        view('users', $data);
    }

    public static function showPosts(): void
    {
        try {
            $data = [];
            foreach (Post::all() as $post) {
                $post["avatar"] = User::getAvatarPath($post["user_id"]);
                $post["poster"] = User::getUsername($post["user_id"]);
                array_push($data, $post);
            }
        } catch (\Exception $e) {
            Validator::addErrors(['user' => ["An error occurred while getting data"]]);
            redirectBack();
        }
        view('posts', $data);
    }

    public static function showAccess(): void
    {
        view('access');
    }



    //CREATE USER

    public static function store(string $role): void
    {
        try {
            $data = (new CreateUserValidator($role . "-"))->validate();
            self::checkNewUser($data[$role . "-fullname"], $data[$role . "-username"], $data[$role . "-email"], $data[$role . "-password"], $role);
        } catch (\Exception $e) {
            Validator::addErrors(['user' => ["An error occurred while getting data"]]);
            redirectBack();
        }
    }


    private static function checkNewUser($fullname, $username, $email, $password, $role): void
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        switch ($role) {
            case 'admin':
                User::insert(["role_id" => 0, "fullname" => $fullname, 'username' => $username, "email" => $email, "password" => $hashed_password]);
                break;
            case 'client':
                User::insert(["role_id" => 1, "fullname" => $fullname, 'username' => $username, "email" => $email, "password" => $hashed_password]);
                break;
        }

        $user = User::select(['username' => $username])[0];
        mkdir(basePath("/assets/media/") . $user['ID']);
        Validator::addMessages([$role => ["New " . ucfirst($role) . " created"]]);
        redirectBack();
    }


    //DELETE USER
    public static function destroy(int $user_id): void
    {
        try {
            $user = User::select(["ID" => $user_id])[0];
            if (empty($user)) {
                Validator::addErrors(['changes' => ["User not found"]]);
            }
            (new deleteUserValidator)->validate($user);
            self::checkDeleteUser($user_id);
        } catch (\Exception $e) {
            Validator::addErrors(['database' => ["An error occurred while getting data"]]);
            redirectBack();
        }
    }


    private static function checkDeleteUser($id): void
    {
        Post::delete(["user_id" => $id]);
        Media::delete(["user_id" => $id]);
        User::delete(["ID" => $id]);

        $folderPath = basePath("/assets/media/") . $id;
        if (is_dir($folderPath)) {
            array_map('unlink', glob($folderPath . '/*'));
            rmdir($folderPath);
        }

        $messages["changes"] = array();
        array_push($messages["changes"], "User deleted successfully");
        Validator::addMessages($messages);

        redirectBack();
    }


    //CHANGE USER
    public static function edit(int $user_id): void
    {
        try {
            $data = (new UserDetailsValidator)->validate($user_id);

            $user = User::select(["ID" => $user_id])[0];

            self::checkChangeUser($user['username'], $user['email'], $data["new_username"], $data['new_email']);
        } catch (\Exception $e) {
            Validator::addErrors(['database' => ["An error occurred while changing data"]]);
            redirectBack();
        }
    }


    private static function checkChangeUser(string $username, string $email, string $new_username, string $new_email): void
    {

        (User::update(["username" => $new_username, "email" => $new_email], ["username" => $username, "email" => $email]));
        $messages['changes'] =  ["User information changed successfully"];
        Validator::addMessages($messages);

        redirectBack();
    }
}
