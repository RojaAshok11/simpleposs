<?php

namespace App\Http\Controllers\Admin\Web\Settings\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UserController extends Controller
{
    public function usercreateoredit(): View
    {
        return view('admin.settings.user.user.usercreateoredit');
    }

    public function userchangepassword(): View
    {
        return view('admin.settings.user.changepassword.userchangepassword');
    }

    public function userrole(): View
    {
        return view('admin.settings.user.role.userrole');
    }

    public function permission($id): View
    {
        return view('admin.settings.user.role.permission', compact('id'));
    }
}
