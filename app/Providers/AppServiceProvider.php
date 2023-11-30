<?php

namespace App\Providers;

use URL;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Scramble::extendOpenApi(static function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'bearer')
            );
        });
    }
}
