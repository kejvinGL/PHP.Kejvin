<?php
class PostController
{

    function createPost()
    {
        isLoggedIn();
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
        $post = getPostByID($id);
        if (getCurrentUserRole() === 0 || getCurrentUser() || $_SESSION["user_id"] == $post["user_id"]) {
            if (deletePost($id)) addMessages(["Post deleted successfully"]);
            if (getCurrentUserRole() === 0) {
                redirectToPosts();
            } else {
                redirectToHome();
            }
        } else {
            http_response_code(400);
            addErrors(["Not authorised to delete Post"]);
            redirectToHome();
        }
    }
}
