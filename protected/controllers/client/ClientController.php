<?php

namespace Controllers\Client;

use Models\Post;
use Models\User;
use Validation\Validator;

class ClientController
{
    public static function index(): void
    {

        try {
            $data = [];
            foreach (Post::select(["user_id" => $_SESSION['user_id']]) as $post) {
                $post['avatar'] = User::getAvatarPath($_SESSION['user_id']);
                array_push($data, $post);
            }

            view('home', $data);
        } catch (\Exception $e) {
            Validator::addErrors(["database" => ["An error occurred"]]);
            redirectBack();
        }
    }
}
