<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Middleware\RoleMiddleware;        // ← без “s”
use Spatie\Permission\Middleware\PermissionMiddleware;  // ← без “s”

class Kernel extends HttpKernel
{
    protected array $middlewareAliases = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'verified'   => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        '2fa'        => \App\Http\Middleware\EnsureTwoFactorEnabled::class,
        'role'       => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
    ];
}
