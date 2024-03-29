<?php

namespace Controllers;

use Models\User;
use Validation\Validator;

class ThemeController
{
    public static function changeTheme(): void
    {
        try {
            $_SESSION["darkmode"] = !$_SESSION["darkmode"];
            if (isset($_SESSION['username'])) {
                User::setTheme();
            }

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (\Exception $e) {
            Validator::addErrors(['database' => "An error ocurred while saving theme to Database."]);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
