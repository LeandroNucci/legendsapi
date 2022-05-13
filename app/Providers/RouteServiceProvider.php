<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    
    protected $namespace_controller = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();
    }
    
    public function map(){
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAuthRoutes();
        $this->mapSkinRoutes();
        $this->mapGenericRoutes();
        $this->mapUserRoutes();
        $this->mapChestRoutes();
        $this->mapScoresRoutes();
    }
        
    protected function mapWebRoutes(){
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(){
        Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
    }
    
    
    /**
     * Define as rotas characters da aplicacao.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace('App\Http\Controllers\Login')
            ->group(base_path('routes/auth.php'));
    }

    protected function mapSkinRoutes()
    {
        Route::prefix('api/skin')
            ->middleware('api')
            ->namespace('App\Http\Controllers\Skin')
            ->group(base_path('routes/skin.php'));
    }

    protected function mapGenericRoutes()
    {
        Route::prefix('api/generics')
            ->middleware('api')
            ->namespace('App\Http\Controllers\Generics')
            ->group(base_path('routes/generics.php'));
    }

    protected function mapScoresRoutes()
    {
        Route::prefix('api/score')
            ->middleware('api')
            ->namespace('App\Http\Controllers\Score')
            ->group(base_path('routes/score.php'));
    }

    protected function mapChestRoutes()
    {
        Route::prefix('api/chest')
            ->middleware('apiauth')
            ->namespace('App\Http\Controllers\Chest')
            ->group(base_path('routes/chest.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('api/user')
            ->middleware('apiauth')
            ->namespace('App\Http\Controllers\User')
            ->group(base_path('routes/user.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
