<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">
        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adduser' ? 'active' : '' }}"
            aria-current="page" href="{{ route('usercreateoredit') }}">{{ __('Add User') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'changepassword' ? 'active' : '' }}"
            href="{{ route('userchangepassword') }}">{{ __('Change Password') }}</a>

        {{-- <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'userrole' ? 'active' : '' }}"
            href="{{ route('userrole') }}">User Role</a> --}}
    </nav>
</div>
