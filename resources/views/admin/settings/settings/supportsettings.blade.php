<h5>{{ __('Support Setting') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('adminfaq') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-question-circle" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('FAQ') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminsupport') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-diagram-2" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Support') }} </div>
                    </div>
                </div>
            </a>
        </div>


    </div>
</div>
