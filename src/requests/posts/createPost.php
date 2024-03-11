<?php
session_start();

function handlePostCreate()
{
    $messages = array();
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $body = $_POST["body"];
    require "db.php";
    $query = "INSERT INTO posts (title, body, user_id) VALUES ('$title','$body', $user_id)";
    if (mysqli_query($conn, $query)) {
        header("Location: /loginpage/views/dashboard.php");
    } else {
    }
}

if (isset($_POST["submit"])) {
    handlePostCreate();
}
