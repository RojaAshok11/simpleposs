<?php

namespace App\Providers;

use App;
use App\Models\Admin\Settings\Generalsettings\Themesetting;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        App::singleton('themesetting', function () {
            return Themesetting::where('is_default', true)->first();
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
