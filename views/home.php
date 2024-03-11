<?php
if (isset($_SESSION["username"])) {
    switch (getCurrentUserRole()) {
        case 0:
            header("Location: overall");
            break;
        case 1:
            header("Location: client");
            break;
        default:
            header("Location: logout");
    }
} else {
    header("Location: logout");
}
