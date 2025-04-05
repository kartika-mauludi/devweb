<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\URL;

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
     * @param  string  $url
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // $host = Request::getSchemeAndHttpHost(); // http(s)://domain.com
        // Config::set('app.asset_url', $host);
        // URL::forceRootUrl(config('app.url'));
        // URL::forceScheme('https');
    }
}
