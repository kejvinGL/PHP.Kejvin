<?php

namespace Controllers;

use Validation\CreatePostValidator;
use Validation\DeletePostValidator;

class PostController
{
    function index(): void
    {
        isClient();
        view('home');
    }


    function store(): void
    {
        isLoggedIn();
        isClient();

        $data = (new CreatePostValidator())->validate();
        if (createPost($_SESSION["user_id"], $data["title"], trim($data["body"]))) {
            $messages["post"] = ["Post created successfully."];
            addMessages($messages);
            redirectBack();
        }
    }

    function destroy($id): void
    {
        isLoggedIn();

        $data = (new DeletePostValidator)->destroy($id);

        if (deletePost($id)) {
            $messages["post"] = ["Post deleted successfully."];
            addMessages($messages);

            redirectBack();
        }
    }
}
