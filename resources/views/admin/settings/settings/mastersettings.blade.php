<h5>{{ __('Master Setting') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('adminproductcategory') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-file-check" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Product Category') }}</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminuom') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-rulers" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('UOM') }}</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminexpensecategory') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-cash-stack" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Expense Category') }}</div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
