<h5>{{ __('Inventory Reports') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('stockreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Stock Credit / Debit Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('currentstockreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box-fill" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Current Stock Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>


    </div>
</div>
