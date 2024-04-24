<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Generalsettings\Themesetting;
use Illuminate\Database\Seeder;

class ThemesettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            [
                'theme_name' => 'LightPurple',
                'path' => 'theme/lightpurpletheme.css',
                'theme_bg_color' => '#4c0bce',
                'collapse_active_color' => '#784bf6',
                'collapse_activesub_color' => '#784bf6',
                'is_default' => false,
            ],
            [
                'theme_name' => 'DarkPurple',
                'path' => 'theme/darkpurpletheme.css',
                'theme_bg_color' => '#563d7c',
                'collapse_active_color' => '#7952b3',
                'collapse_activesub_color' => '#7952b3',
                'is_default' => false,
            ],
            [
                'theme_name' => 'Teal',
                'path' => 'theme/tealtheme.css',
                'theme_bg_color' => '#37474f',
                'collapse_active_color' => '#0097a7',
                'collapse_activesub_color' => '#0097a7',
                'is_default' => true,
            ],
            [
                'theme_name' => 'Red',
                'path' => 'theme/redtheme.css',
                'theme_bg_color' => '#A42637',
                'collapse_active_color' => '#CC7D87',
                'collapse_activesub_color' => '#A42637',
                'is_default' => false,
            ],
            [
                'theme_name' => 'Blue',
                'path' => 'theme/bluetheme.css',
                'theme_bg_color' => '#1d5bc0',
                'collapse_active_color' => '#3b82f6',
                'collapse_activesub_color' => '#3b82f6',
                'is_default' => false,
            ]] as $row) {
            Themesetting::create($row);
        }
    }
}
