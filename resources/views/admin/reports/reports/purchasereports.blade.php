<h5>{{ __('Purchase Reports') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('purchasereport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box2" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Purchase Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('purchaseitemreport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-box2-fill" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Purchase Items Reports') }} </div>
                    </div>
                </div>
            </a>
        </div>


    </div>
</div>
