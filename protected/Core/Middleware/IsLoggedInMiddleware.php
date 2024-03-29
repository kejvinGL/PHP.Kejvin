<?php

namespace Core\Middleware;

use Models\User;

class IsLoggedInMiddleware extends Middleware
{
    public function __invoke()
    {
        if (isset($_SESSION['user_id']) && User::select(['username' => $_SESSION["username"]]) != null) {
            if ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register') {
                User::getCurrentRole() === 0 ?   header("Location: /overall"): header("Location: /home");
                exit();
            }
        } else {
            if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/register') {
                header("Location: /login");
                exit();
            }
        }
    }
}
