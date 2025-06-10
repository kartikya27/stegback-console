<?php

namespace Kartikey\PanelPulse;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class PanelPulseServiceProvider extends ServiceProvider
{
    public function boot()
    {

        if (File::exists(__DIR__ . '\app\CommonHelper.php')) {
            require __DIR__ . '\app\CommonHelper.php';
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'PanelPulse');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');

        $this->loadJsonTranslationsFrom(__DIR__ . '/lang');

        $this->publishes([
            __DIR__ . '/../publishable/assets' => public_path('/assets/'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/lang' => resource_path('lang/'),
        ], 'lang');
    }

    public function register()
    {
        //
    }
}
