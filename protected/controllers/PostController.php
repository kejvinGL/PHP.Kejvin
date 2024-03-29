<?php

namespace Controllers;

use Models\Post;
use Validation\CreatePostValidator;
use Validation\DeletePostValidator;
use Validation\Validator;

class PostController
{

    public static function store(): void
    {
        try {
            $data = (new CreatePostValidator())->validate();

            if (Post::insert(['title' => $data['title'], 'body' => $data['body'], 'user_id' => $_SESSION['user_id']])) {
                $messages["post"] = ["Post created successfully."];
                Validator::addMessages($messages);
            }
        } catch (\Exception $e) {
            Validator::addErrors(["databse" => ["An error occurred while adding post"]]);
        }
        redirectBack();
    }

    public static function destroy($id): void
    {

        try {
            (new DeletePostValidator)->destroy($id);
            Post::delete(["ID" => $id]);
            $messages["post"] = ["Post deleted successfully."];
            Validator::addMessages($messages);
        } catch (\Exception $e) {
            Validator::addErrors(["databse" => ["An error occurred while deleting post"]]);
        }
        redirectBack();
    }
}
