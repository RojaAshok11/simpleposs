<?php

namespace App\Providers;

use App;
use App\Models\Admin\Settings\Pos\Possetting;
use Illuminate\Support\ServiceProvider;

class PosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        App::singleton('possetting', function () {
            return Possetting::first();
        });
    }

/**
 * Bootstrap services.
 *
 * @return void
 */
    public function boot(): void
    {
        //
    }

}
