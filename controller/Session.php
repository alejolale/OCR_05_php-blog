<?php

declare(strict_types=1);

namespace Session;

class Session
{
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return ($_SESSION[$key] ?? null);
    }

    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }
}