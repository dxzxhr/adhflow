<?php

namespace App\Providers;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


public function boot(Router $router): void
{
    //  ← ваша прочая логика

    // Регистрация алиасов, чтобы Router знал «role» и «permission»
    $router->aliasMiddleware('role', RoleMiddleware::class);
    $router->aliasMiddleware('permission', PermissionMiddleware::class);
}

}
