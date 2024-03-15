<?php

function createPost($id, $title, $body)
{
    require "db.php";
    $stmt = $pdo->prepare("INSERT INTO posts (title, body, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $body, $id]);
}


function deletePost($id)
{
    require "db.php";
    $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
    $stmt->execute([$id]);
}

/**
 *
 * @return int The total number of posts.
 */
function totalPosts(): int
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->rowCount();
}


/**
 *
 * @return int Number of Posts in the last 24 hours.
 */
function recentPosts(): int
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM posts  WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 DAY);");
    $stmt->execute();
    return $stmt->rowCount();
}


/**
 * Calculates the total number of posts for a specified user.
 *
 * @param int $id The ID of the user.
 * @return int The total number of posts for the user.
 */
function totalUserPosts($id): int
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM posts  WHERE user_id= ? ;");
    $stmt->execute([$id]);
    return $stmt->rowCount();
    return mysqli_num_rows($result);
}


function getPosts()
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM posts;");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getPostByID($id)
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = ?;");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Retrieves the posts of the current user.
 *
 * @return array An array containing the posts of the current user.
 */
function getCurrentUserPosts(): array
{
    require "db.php";
    $id = $_SESSION["user_id"];
    $stmt = $pdo->prepare("SELECT * FROM posts  WHERE user_id= ? ;");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
