<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Miscellaneous\DeviceInfohelper;
use App\Models\Miscellaneous\Trackmessagehelper;
use Auth;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Adminloginlivewire extends Component
{

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required|min:8|max:20')]
    public $password = '';

    public function login(): Redirector
    {
        $this->validate();

        if (Auth::attempt(array('email' => $this->email, 'password' => $this->password))) {
            session()->flash('message', "You are Login successful.");

            DB::beginTransaction();
            $user = auth()->user();
            request()->session()->regenerate();
            request()->session()->put('sessionid', (string) Str::uuid());
            Trackmessagehelper::trackmessage($user, $user, 'admin_web_postadminlogin', session()->getId(), 'WEB', 'Admin Login');
            DeviceInfohelper::deviceInfo($user, session()->getId(), 'WEB');
            DB::commit();
            toast('Hi ' . $user->name . ', You Have Logged In Successfully!', 'success');

            return redirect()->route('admindashboard');

        } else {
            session()->flash('error', 'Email and Password are wrong.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.auth.adminloginlivewire');
    }

}
