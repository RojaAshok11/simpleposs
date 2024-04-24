<?php

namespace App\Providers;

use App;
use App\Models\Admin\Settings\Systemsettings\Currencymaster;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        App::singleton('currencymaster', function () {
            return Currencymaster::where('is_default', true)->first();
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
