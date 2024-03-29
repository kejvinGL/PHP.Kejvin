<?php

namespace Core\Middleware;

class Middleware
{
    private static $MAP = [
        'isLoggedIn' => IsLoggedInMiddleware::class,
        'isAdmin' => IsAdminMiddleware::class,
        'isClient' => IsClientMiddleware::class
    ];

    public static function check($middleware): void
    {
        (new self::$MAP[$middleware])();
    }
}
