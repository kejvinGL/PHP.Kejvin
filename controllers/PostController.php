<?php

namespace Controllers;

use Validation\PostValidator;
use Validation\Validator;

class PostController
{

    public $errors = array();
    public $messages = array();
    public $v;
    function index()
    {
        isClient();
        view('home');
    }


    function store()
    {
        isLoggedIn();
        isClient();
        (new PostValidator)->store($_POST);

        $data = (new PostValidator)->store($_POST);

        createPost($_SESSION["user_id"], $data["title"], $data["body"]);
        $messages = ["New post created successfully."];
        addMessages($messages);
        redirectToHome();
    }

    function destroy($id)
    {
        isLoggedIn();

        $data = (new PostValidator)->destroy(["post_id" => $id]);


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
