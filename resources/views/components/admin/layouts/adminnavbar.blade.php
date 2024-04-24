<nav class="navbar navbar-expand-lg  theme_bg_color py-1 px-4 navbar-dark rounded">
    <div class="container-fluid">
        <div class="navbar-brand d-flex align-items-center">
            <a href="#" class="" id="sidebar-toggle">
                <i class="bi bi-text-left text-white fs-2 me-3" style="font-weight: bold;"></i>
            </a>
            <h2 class="fs-4 m-0 text-white ms-5">{{ $modulename }}</h2>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <livewire:livewirehelper.offline.offlinelivewire lazy />


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                {{-- POS --}}
                <li class="" style="margin-right:50px;">
                    <a class="nav-link second-text fw-bold mt-1" href="{{ route('salepos') }}" role="button"
                        aria-expanded="false">
                        POS
                    </a>
                </li>

                <li class="nav-item dropdown" style="margin-right:50px;">
                    <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill me-2 fs-5"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu" style="font-size:12px;" aria-labelledby="navbarDropdown">
                        <li>
                            <div class="p-3 border-bottom">
                                <span>{{ auth()->user()->name }}</span>
                                <span class="text-secondary">{{ auth()->user()->username }}</span>
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('usercreateoredit') }}">{{ __('Profile') }}</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('userchangepassword') }}">{{ __('Change Password') }}</a>
                        </li>
                        {{-- <li><a class="dropdown-item" href="{{ route('2fa') }}">2FA</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('adminlogout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">{{ __('Logout') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form id="logout-form-navbar" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</nav>
