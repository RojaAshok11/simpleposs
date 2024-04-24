<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ApiMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ref https://www.youtube.com/watch?v=joWaHTwdZR0
        Response::macro('success', function ($data, $status_code = 200) {
            return Response::json([
                'success' => $data[0],
                'data' => $data[1],
                'message' => $data[2],
            ], $status_code);
        });

        Response::macro('error', function ($data, $status_code = 404) {
            return Response::json([
                'success' => $data[0],
                'message' => $data[1],
            ], $status_code);
        });

        Response::macro('apisessionid', function () {
            return substr(request()->header('authorization'), -33);
        });

        Response::macro('validatorerror', function () {
            return substr(request()->header('authorization'), -33);
        });

    }
}
