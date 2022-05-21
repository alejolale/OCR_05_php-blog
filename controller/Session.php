<?php

declare(strict_types=1);

namespace Session;

class Session
{
    public static function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return ($_SESSION[$key] ?? null);
    }
}

