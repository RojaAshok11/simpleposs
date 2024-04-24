<?php

namespace App\Http\Controllers\Admin\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Miscellaneous\Trackmessagehelper;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminloginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showadminloginform(): view
    {
        return view('admin.auth.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = auth()->user();
        Log::info("User : " . $user->name . " Session ID :" . $request->session()->get('sessionid'));
        Trackmessagehelper::trackmessage($user, $user, 'admin_web_adminlogout', session()->getId(), 'WEB', 'Admin Logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();
        toast('Hi ' . $user->name . ', You have successfully logged out', 'info', 'top-right');
        return redirect('/');
    }

}
