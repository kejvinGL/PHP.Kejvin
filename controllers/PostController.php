<?php

namespace Controllers;

use Validation\CreatePostValidator;
use Validation\DeletePostValidator;

class PostController
{
    function index()
    {
        isClient();
        view('home');
    }


    function store()
    {
        isLoggedIn();
        isClient();

        $data = (new CreatePostValidator())->validate();
        if (createPost($_SESSION["user_id"], $data["title"], $data["body"])) {
            $messages["post"] = ["Post created successfully."];
            addMessages($messages);
            redirectToHome();
        }
    }

    function destroy($id)
    {
        isLoggedIn();

        $data = (new DeletePostValidator)->destroy($id);


        if (deletePost($id)) {
            $messages["post"] = ["Post deleted successfully."];
            addMessages($messages);

            if (getCurrentUserRole() === 0) {
                redirectToAdmin('posts');
            } else {
                redirectToHome();
            }
        }
    }
}
