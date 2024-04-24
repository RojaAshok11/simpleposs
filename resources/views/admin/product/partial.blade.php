<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminproduct' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminproduct') }}">{{ __('Product') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminstockadjustment' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminstockadjustment') }}">{{ __('Stock Adjustment') }}</a>
    </nav>
</div>
