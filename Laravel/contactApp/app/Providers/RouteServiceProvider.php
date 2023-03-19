<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\isNull;
use function Webmozart\Assert\Tests\StaticAnalysis\notNull;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
//        Explicit bindings
//        Route::model('contact', Contact::class);

//        바인딩 될 모델 커스텀하기
//        Route::bind('contact', function($value){
//            바인딩 될 모델 정의
//        if (is_int($va lue)){
//            return Contact::findOrFail($value);
//        }
//            return Contact::where('id', $value)->where('email', notNull() )->firstOrFail();
//        });

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
