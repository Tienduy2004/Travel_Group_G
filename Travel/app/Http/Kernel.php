<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Các middleware global được tải vào trong ứng dụng.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\EncryptCookies::class,
    ];

    /**
     * Các nhóm middleware có thể áp dụng cho các route.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.admin' => \App\Http\Middleware\RedirectIfNotAuthenticatedAdmin::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
