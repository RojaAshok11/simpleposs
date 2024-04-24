@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('DASHBOARD') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
    </x-admin.layouts.adminbreadcrumb>
    <div class="row">
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('TOTAL SUPPLIER') }}</h6>
                    <p class="card-text">{{ $totalsupplier }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('TOTAL CUSTOMER') }}</h6>
                    <p class="card-text">{{ $totalcustomer }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('TOTAL SALES') }} </h6>
                    <p class="card-text">{{ $totalsales }}</p>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('TOTAL PURCHASE') }} </h6>
                    <p class="card-text">{{ $totalpurchases }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col">
            <div id="piechart_3d" class="justify-content-between rounded mt-4 p-4 bg-white shadow-sm">
            </div>
        </div>
        <div class="col">
            <div id="piechart_3d_2"class="justify-content-between rounded mt-4 p-4 bg-white shadow-sm ">
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('TODAY SALES') }} </h6>
                    <p class="card-text">{{ $todaysale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('YESTERDAY SALES') }}</h6>
                    <p class="card-text">{{ $yesterdaysale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('THIS WEEK SALES') }}</h6>
                    <p class="card-text">{{ $weeksale }}</p>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('LAST WEEK SALES') }}</h6>
                    <p class="card-text">{{ $lastweeksale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-4">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('THIS YEAR SALES') }}</h6>
                    <p class="card-text">{{ $yearsale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-4">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('PREVIOUS YEAR SALES') }}</h6>
                    <p class="card-text">{{ $previousyearsale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-4">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('THIS MONTH SALES') }}</h6>
                    <p class="card-text">{{ $monthsale }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-4">
            <div class="card bg-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('LAST MONTH SALES') }}</h6>
                    <p class="card-text">{{ $lastmonthsale }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#admindashboard_sidenav',
    ])


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable({!! json_encode($topsaletoday) !!});

            var options = {
                title: '{{ __('TOP SOLD ITEMS TODAY') }}',
                pieHole: 0.4,
                pieSliceTextStyle: {
                    color: 'white',
                    fontName: 'monospace',
                },
                slices: {
                    0: {
                        color: 'green'
                    },
                    1: {
                        color: 'gray'
                    },
                    2: {
                        color: 'orange'
                    }
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable({!! json_encode($topsalemonth) !!});

            var options = {
                title: '{{ __('TOP SOLD ITEMS OF THIS MONTH') }}',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_2'));
            chart.draw(data, options);
        }
    </script>
@endsection
