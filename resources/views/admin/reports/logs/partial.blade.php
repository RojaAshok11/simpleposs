<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">
        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'loginlogs' ? 'active' : '' }}"
            aria-current="page" href="{{ route('logininfo') }}">{{ __('Login Logs Information') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'trackinglogs' ? 'active' : '' }}"
            href="{{ route('tracking') }}">{{ __('Tracking Logs Information') }}</a>

    </nav>
</div>
