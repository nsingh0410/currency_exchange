<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Log::info('RouteServiceProvider booting: registering route groups');

        $this->routes(function () {
            Log::info('Registering API routes from routes/api.php');
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Log::info('Registering Web routes from routes/web.php');
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Log::info('RouteServiceProvider boot complete');
    }
}
