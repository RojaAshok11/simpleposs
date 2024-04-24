<div class="">
    <div class="d-flex border border-secondary"
        style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }}">
        <div class="p-2">
            <a href="{{ route('admindashboard') }}" role="button" class="navbar-brand mb-0 h1 text-white">
                {{ App::make('companysetting') ? App::make('companysetting')->companyfullname : 'POS' }}
            </a>
        </div>

        <div class="ms-auto m-2 me-3">
            <div class="d-flex gap-3">
                <div class="position-relative">
                    <span><i class="bi bi-cart fs-5 text-white"></i></span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $form['total_items'] }}
                    </span>
                </div>
                <div class="px-2 text-white fs-6 fw-bold" wire:ignore>
                    <span id="date"></span>
                    <span id="time"></span>
                </div>
                <div class="d-flex badge bg-success text-dark text-wrap rounded justify-content-between align-items-center"
                    style="width: 110px">
                    <div class="">
                        <i class="bi bi-person-circle text-light me-2 fs-5"></i>
                    </div>
                    <div class="text-white">
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            @if (App::make('possetting')->pos_position == 1)
                <div class="order-2 order-md-1 col-md-4 mt-1">
                    @include('livewire.admin.pos.posbilllivewire')
                </div>
                <div class="order-1 order-md-2 col-md-8 mt-1">
                    @include('livewire.admin.pos.positemlivewire')
                </div>
            @else
                <div class="order-1 order-md-2 col-md-4 mt-1">
                    @include('livewire.admin.pos.posbilllivewire')
                </div>
                <div class="order-2 order-md-1 col-md-8 mt-1">
                    @include('livewire.admin.pos.positemlivewire')
                </div>
            @endif
        </div>
    </div>

    {{-- Print --}}
    @include('livewire.admin.sale.print')


    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
    @include('livewire.admin.sale.holdsalemodal')
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('holdsalemodal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('holdsaleModal'))
                myModal.show();
            });
        });
    </script>
    <script type="text/javascript">
        document.addEventListener('livewire:init', () => {
            Livewire.on('printmodal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('printmodal'))
                myModal.show();
            });
        });

        // TIME
        function myClock() {
            setTimeout(function() {
                const d = new Date();
                const n = d.toLocaleTimeString();
                document.getElementById("time").innerHTML = n;
                myClock();
            }, 1000)
        }
        myClock();

        // DATE
        const date = new Date();
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        let currentDate = `${day}-${month}-${year}`;
        document.getElementById("date").innerHTML = currentDate;
    </script>

</div>
