{{-- @livewireScripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    document.addEventListener('alert', (data) => {
        Swal.fire({
            icon: data.detail[0].type,
            title: data.detail[0].message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    })
</script>


<script>
    $(document).ready(function() {
        const $button = document.querySelector('#sidebar-toggle');
        const $wrapper = document.querySelector('#wrapper');
        $button.addEventListener('click', (e) => {
            e.preventDefault();
            $wrapper.classList.toggle('toggled');
        });
    });
</script>


<script type="module">
    $(document).ready(function() {
        $('#sidebar-toggle').click(function(e) {
            $.get("{{ URL('/admin/session') }}");
        });
    });
</script>

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

@section('footerSection')
@show
