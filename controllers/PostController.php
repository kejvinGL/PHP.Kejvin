<?php

namespace Controllers;


class PostController
{

    function index()
    {
        view('home');
        isClient();
    }

    function createPost()
    {
        isLoggedIn();
        isClient();
        $user_id = $_SESSION["user_id"];
        $title = $_POST["title"];
        $body = $_POST["body"];
        createPost($user_id, $title, $body);
        $messages = ["New post created successfully."];
        addMessages($messages);
        redirectToHome();
    }

    function deletePost($id)
    {
        isLoggedIn();
        $post = getPostByID($id);
        if (getCurrentUserRole() === 0 || $_SESSION["user_id"] == $post["user_id"]) {
            if (deletePost($id)) {
                $messages = ["Post deleted successfully."];
                addMessages($messages);
            } else {
                $errors = ["Post not found."];
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
