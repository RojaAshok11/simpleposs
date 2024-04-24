<div class="{{ $col }} mx-auto mb-1">
    <nav class="nav nav-pills flex-column flex-sm-row shadow-sm rounded-pill bg-white">

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'alert' ? 'active' : '' }}"
            href="{{ route('adminalert') }}">Alert</a>

        <a class="flex-sm-fill text-sm-center nav-link rounded-pill {{ $name == 'pushnotification' ? 'active' : '' }}"
            aria-current="page" href="{{ route('adminpushnotification') }}">Push Notification</a>

    </nav>
</div>
