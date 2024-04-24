<?php

use App\Http\Controllers\Admin\Web\Auth\AdminloginController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/admin/session', function () {
    (session('adminsessiontoggled') == 'toggled') ? session()->forget('adminsessiontoggled') : session(['adminsessiontoggled' => 'toggled']);
})->middleware('auth', 'preventbackbutton');

Route::get('logs', [LogViewerController::class, 'index']);

Route::controller(AdminloginController::class)
    ->group(function () {
        Route::get('/', 'showadminloginform')->name('adminlogin');
        Route::get('admin/login', 'showadminloginform')->name('adminshowlogin');
        Route::post('admin/login', 'adminlogin')->name('adminloginpost');
        Route::match(['get', 'post'], 'logout', 'logout')->name('adminlogout');
    });
