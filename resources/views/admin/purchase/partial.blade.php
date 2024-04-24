<div class="{{ $col }} mx-auto my-2">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminpurchase' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminpurchase') }}">{{ __('Purchases') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminpurchasereturn' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminpurchasereturn') }}">{{ __('Purchase Return') }}</a>
    </nav>
</div>
