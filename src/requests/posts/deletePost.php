<?php

function handlePostDelete()
{
    $post_id = $_POST["post_id"];

    require "db.php";
    $query = "DELETE FROM posts WHERE post_id = '$post_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: /loginpage/viewsdashboard.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}


if (isset($_POST["submit"])) {
    handlePostCreate();
}
