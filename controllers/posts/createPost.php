<?php
isLoggedIn();

function handlePostCreate()
{
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $body = $_POST["body"];
    createPost($user_id, $title, $body);
    $messages = ["New post created successfully."];
    addMessages($messages);
    redirectToClient();
}

if (isset($_POST["submit"])) {
    handlePostCreate();
}
