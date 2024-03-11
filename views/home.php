<?php
session_start();

require("../src/methods/user.php");
if (isset($_SESSION["username"])) {
    switch (getCurrentUserRole()) {
        case 0:
            header("Location: overall.php");
            break;
        case 1:
            header("Location: client.php");
            break;
        default:
            header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}