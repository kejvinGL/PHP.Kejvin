<?php

namespace Controllers;

class ThemeController
{
    function changeTheme()
    {
        $_SESSION["darkmode"] = !$_SESSION["darkmode"];
        if (isset($_SESSION['username'])) {
            setUserTheme();
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
