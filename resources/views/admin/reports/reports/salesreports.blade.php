<h5>{{ __('Sales Reports') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('salesreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box-seam" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Sales Reports') }} </div>
                        {{-- <p class="card-text">{{ $salesreports }}</p> --}}
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('saleitemsreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box-seam-fill" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Sale Items Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('amountcdreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-cash-stack" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Credit / Debit Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
