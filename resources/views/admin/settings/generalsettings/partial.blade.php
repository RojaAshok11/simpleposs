<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'company' ? 'active' : '' }}"
            href="{{ route('admincompanysetting') }}">{{ __('Company') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'email' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminemailsetting') }}">{{ __('Email') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'gateway' ? 'active' : '' }}"
            href="{{ route('admingateway') }}">{{ __('Gateway') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'sms' ? 'active' : '' }}"
            href="{{ route('adminsmssetting') }}">{{ __('SMS') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'fcm' ? 'active' : '' }}"
            href="{{ route('adminfcmsetting') }}">{{ __('FCM') }}</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'theme' ? 'active' : '' }}"
            href="{{ route('adminthemesetting') }}">{{ __('Theme') }}</a>
    </nav>
</div>
