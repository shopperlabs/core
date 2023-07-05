<?php

declare(strict_types=1);

namespace Shopper\Core;

use Illuminate\Contracts\Auth\Guard;

final class Shopper
{
    public static function version(): string
    {
        return '2.0';
    }

    public static function auth(): Guard
    {
        return auth()->guard(config('shopper.auth.guard'));
    }

    public static function prefix(): string
    {
        return config('shopper.admin.prefix');
    }
}
