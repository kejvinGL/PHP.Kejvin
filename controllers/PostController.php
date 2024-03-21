<?php

namespace Controllers;


class PostController
{

    public $errors = array();
    public $messages = array();
    public $v;
    function index()
    {
        view('home');
        isClient();
    }


    function store()
    {
        isLoggedIn();
        isClient();
        $this->v->setFields($_POST);

        $this->v->required("title", "Post title cannot be empty")->required("body", "Post body cannot be empty");
        if ($this->v->foundErrors()) {
            redirectToHome();
        } else {
            $user_id = $_SESSION["user_id"];
            createPost($user_id, $_POST["title"], $_POST["body"]);
            $messages = ["New post created successfully."];
            addMessages($messages);
            redirectToHome();
        }
    }

    function destroy($id)
    {
        isLoggedIn();
        $post = getPostByID($id);
        $errors = [];
        $messages = [];

        if (getCurrentUserRole() === 0 || $_SESSION["user_id"] == $post["user_id"]) {
            if (deletePost($id)) {
                $messages["post"] = ["Post deleted successfully."];
                addMessages($messages);
            } else {
                $errors["post"] = ["Post not found."];
                addErrors($errors);
            }
            if (getCurrentUserRole() === 0) {
                redirectToAdmin('posts');
            } else {
                redirectToHome();
            }
        } else {
            http_response_code(400);
            addMessages(["Not authorised to delete Post"]);
            redirectToHome();
        }
    }
}
