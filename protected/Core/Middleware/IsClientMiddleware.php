<?php

namespace Core\Middleware;

use Models\User;

class IsClientMiddleware
{
    public function __invoke(): void
    {
        switch (User::getCurrentRole()) {
            case 0:
                header("Location: /overall");
                exit();
                break;
            case null:
                header("Location: /login");
                break;
            default:
                break;
        }
    }
}
