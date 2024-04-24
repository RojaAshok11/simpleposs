<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminproductcategory' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminproductcategory') }}">{{ __('Product Category') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminuom' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminuom') }}">{{ __('UOM') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminexpensecategory' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminexpensecategory') }}">{{ __('Expense Category') }}</a>
    </nav>
</div>
