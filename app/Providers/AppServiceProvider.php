<?php

namespace App\Providers;

use App\Order;
use Illuminate\Support\Facades\Redis;
use App\Custom\UpsShipping\UpsHandler;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;
use App\Custom\UpsShipping\UpsSoapClient;
use App\Custom\UpsShipping\Repositories\UpsShippingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UpsHandler', function ($app) {
            return new UpsHandler(
                new UpsShippingRepository
            );
        });


        $this->app->singleton('UpsSoapClient', function ($app) {
            return new UpsSoapClient(
                config('ups.user_id'), config('ups.password'), config('ups.access_key'), config('ups.wsdl_path')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Redis::enableEvents();
        Form::component('numberWrapped', 'front.includes.number-wrapped', ['name', 'value', 'attributes']);
    }
}
