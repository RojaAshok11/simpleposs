<div class="{{ $col }} mx-auto my-2">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminsale' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminsale') }}">{{ __('Sales') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminsalehold' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminsalehold') }}">{{ __('Sale Hold') }}</a>


        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'adminsalereturn' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminsalereturn') }}">{{ __('Sale Return') }}</a>


    </nav>
</div>
