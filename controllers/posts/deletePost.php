<?php
isLoggedIn();


function handlePostDelete()
{
    $post_id = $_POST["post_id"];
    deletePost($post_id);
    addMessages(["Post deleted successfully"]);
    if (getCurrentUserRole() == 0) {
        redirectToPosts();
    } else {
        redirectToClient();
    }
}


if (isset($_POST["delete"])) {
    handlePostDelete();
}
