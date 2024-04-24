<?php

namespace App\Providers;

use App;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        App::singleton('companysetting', function () {
            return Companysetting::first();
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
