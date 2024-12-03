<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The namespace for the controller routes in your application.
     * Set this to `null` if not using a default namespace.
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // Đường dẫn sẽ bắt đầu với /api
            ->middleware('api') // Middleware mặc định cho API
            ->namespace($this->namespace) // Namespace cho controller
            ->group(base_path('routes/api.php')); // Định nghĩa trong routes/api.php
    }
}
