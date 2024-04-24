<h5>{{ __('Notification Setting') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">

        <div class="col-md-2">
            <a href="{{ route('adminalert') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-info-circle" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Alert') }} </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('adminpushnotification') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-app-indicator" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Push Notifiaction') }} </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
