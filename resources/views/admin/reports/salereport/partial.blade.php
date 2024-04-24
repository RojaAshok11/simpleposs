<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">
        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'salesreport' ? 'active' : '' }}"
            aria-current="page" href="{{ route('salesreport') }}">Sales Reports</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'saleitemsreport' ? 'active' : '' }}"
            href="{{ route('saleitemsreport') }}">Sale Items Reports</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'amountcdreport' ? 'active' : '' }}"
            href="{{ route('amountcdreport') }}">Credit / Debit Reports</a>

    </nav>
</div>
