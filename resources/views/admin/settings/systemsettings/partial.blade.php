<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a href="{{ route('admincurrencymaster') }}"
            class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'currencymaster' ? 'active' : '' }}">Currency</a>

        <a href="{{ route('admintimezonemaster') }}"
            class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'timezonemaster' ? 'active' : '' }}"
            aria-current="page">{{ __('Timezone') }}</a>

    </nav>
</div>
