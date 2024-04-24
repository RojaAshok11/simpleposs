<h5>{{ __('General Setting') }}</h5>
<div class="pb-4 pt-2">
    <div class="row g-3 row-cols-1 row-cols-md-2">


        <div class="col-md-2">
            <a href="{{ route('admincompanysetting') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-buildings" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Company Settings') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminemailsetting') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-envelope-at" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Email') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admingateway') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-currency-rupee" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Gateway') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminsmssetting') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-chat-left-dots" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('SMS') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminthemesetting') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-palette" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('Theme') }} </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{ route('adminfcmsetting') }}" class="text-decoration-none text-dark text-center">
                <div class="card shadow-sm bg-white">
                    <i class="bi bi-phone" style="font-size: 2.4rem;"></i>
                    <div class="card-footer">
                        <div class="fw-b">{{ __('FCM') }} </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
