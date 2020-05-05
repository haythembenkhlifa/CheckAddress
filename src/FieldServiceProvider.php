<?php

namespace Haythem\CheckAddress;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('check-address', __DIR__ . '/../dist/js/field.js');
            Nova::style('check-address', __DIR__ . '/../dist/css/field.css');
        });
        $this->publishes([
            __DIR__ . '/images' => public_path('haythem/CheckAddress'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
