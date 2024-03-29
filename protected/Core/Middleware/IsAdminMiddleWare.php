<?php

namespace Core\Middleware;

use Models\User;

class  IsAdminMiddleWare
{

    public function __invoke()
    {
        if (User::getCurrentRole() !== 0) {
            session_unset();
            header("Location: /login");
            exit();
        }
    }
}
