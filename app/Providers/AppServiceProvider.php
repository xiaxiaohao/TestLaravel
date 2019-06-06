<?php

namespace App\Providers;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        app('Dingo\Api\Exception\Handler')->register(function (UserException $exception) {
            return Response::make(['error' => 'Hey, 你在干嘛!?'], 401);
        });


    }
}
