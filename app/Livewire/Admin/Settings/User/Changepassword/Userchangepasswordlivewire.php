<?php

namespace App\Livewire\Admin\Settings\User\Changepassword;

use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;

class Userchangepasswordlivewire extends Component
{
    use miscellaneousLivewireTrait;

    public $currentpassword, $password, $password_confirmation;

    protected $rules = [
        'currentpassword' => 'bail|required|min:8|max:20',
        'password' => 'bail|required|confirmed|min:8|max:20',
        'password_confirmation' => 'bail|required|min:8|max:20',
    ];

    protected $messages = [
        'currentpassword.required' => 'Enter your current password',
        'password.required' => 'Enter your new password',
        'password.confirmed' => 'Password does not match your new password',
        'password.min' => 'Password must be at least 8 characters',
    ];

    // #[Rule('required', message: 'Enter your current password')]
    // #[Rule('max:20', message: 'Password not greater than 20 characters')]
    // #[Rule('min:8', message: 'Password must be at least 8 characters')]

    // #[Rule('required', message: 'Please provide a post title')]
    // #[Rule('max:5', message: 'This title is max short')]
    // #[Rule('min:3', message: 'This title is too short')]
    // public $currentpassword;

    // #[Rule('required', message: 'Enter your new password')]
    // #[Rule('confirmed', message: 'Password does not match your new password')]
    // #[Rule('max:20', message: 'Password not greater than 20 characters')]
    // #[Rule('min:8', message: 'Password must be at least 8 characters')]
    // public $password;

    // #[Rule('required', message: 'Enter your confirmation password')]
    // #[Rule('max:20', message: 'Password not greater than 20 characters')]
    // #[Rule('min:8', message: 'Password must be at least 8 characters')]
    // public $password_confirmation;

    public function changepassword(): void
    {

        $validatedData = $this->validate();
        try {

            DB::beginTransaction();

            $user = auth()->user();
            if (Hash::check($this->currentpassword, $user->password)) {
                $user->update(['password' => $this->password]);
                Trackmessagehelper::trackmessage($user, 'Admin Change Password', 'admin_web_changepassword', session()->getId(), 'WEB', 'Admin Change Password');
                DB::commit();

                $this->formreset();
                $this->toaster('success', 'Your password has been changed successfully!!');
            } else {
                DB::rollback();
                $this->formreset();
                $this->toaster('error', 'Invalid Credentials, Please Try Again');
            }

        } catch (Exception $e) {
            $this->exceptionerror($user, 'admin_change_password', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror($user, 'admin_change_password', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror($user, 'admin_change_password', 'error_three : ' . $e->getMessage());
        }

    }

    public function onclickformreset(): void
    {
        $this->formreset();
        $this->toaster('warning', 'Oops! Change Password Discarded');
    }

    public function formreset(): void
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.admin.settings.user.changepassword.userchangepasswordlivewire');
    }

}
