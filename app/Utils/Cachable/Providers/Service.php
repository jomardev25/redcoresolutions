<?php

namespace App\Utils\Cachable\Providers;

use App\Utils\Cachable\Console\Commands\Clear;
use App\Utils\Cachable\Helper;
use App\Utils\Cachable\ModelCaching;
use Illuminate\Support\ServiceProvider;

class Service extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->commands([
            Clear::class
        ]);
    }

    public function register()
    {
        if (! class_exists('App\Utils\Cachable\CachedBuilder')) {
            class_alias(
                ModelCaching::builder(),
                'App\Utils\Cachable\CachedBuilder'
            );
        }

        $this->app->bind("model-cache", Helper::class);
    }
}