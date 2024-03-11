<?php
session_start();
$_SESSION["darkmode"] = !$_SESSION["darkmode"];
$back =  $_SERVER["HTTP_REFERER"];

if (isset($_SESSION['username'])) {
    require "../../methods/db.php";
    $mode = $_SESSION["darkmode"];
    $username = $_SESSION["username"];
    $query = "UPDATE users SET darkmode = '$mode'  WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
}

header("Location: $back");
exit();
