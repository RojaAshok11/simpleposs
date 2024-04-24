<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">
        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'state' ? 'active' : '' }}"
            aria-current="page" href="{{ route('state') }}">{{ __('State') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'city' ? 'active' : '' }}"
            href="{{ route('city') }}">City</a>
    </nav>
</div>
