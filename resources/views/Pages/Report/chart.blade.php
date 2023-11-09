@php
    if (empty($date_st) && empty($date_nd)) {
        $tanggal1 = $dt_now;
        $tanggal2 = $dt_now;
    } else {
        $tanggal1 = $date_st;
        $tanggal2 = $date_nd;
    }
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Ticket</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Monthly Ticketing</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                            data-feather="eye" class="icon-sm me-2"></i> <span
                                            class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                            data-feather="edit-2" class="icon-sm me-2"></i> <span
                                            class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                            data-feather="trash" class="icon-sm me-2"></i> <span
                                            class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                            data-feather="printer" class="icon-sm me-2"></i> <span
                                            class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                            data-feather="download" class="icon-sm me-2"></i> <span
                                            class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">Sales are activities related to selling or the number of goods or
                            services sold in a given time period.</p>
                        <div id="monthlySalesChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Grouped Ticket</h4>
          </div>
            <form action="{{route('sorting.chart')}}" method="post">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" name="eoc_dtSt" value="{{$tanggal1}}" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
                    </div>
                    <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" name="eoc_dtNd" value="{{$tanggal2}}" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="search"></i>
                        Sort
                    </button>
                </div>
            </form>
        </div>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartjsPolarArea"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/chartjs/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/apexcharts/apexcharts.min.js"></script>
@endpush
@push('custom-plug')
    <script>
        var mtTicketUrl = '{{ route('chart.data') }}';
        var valDateBar = '{{ $tanggal2.' s/d '.$tanggal2 }}';
        var valEntryTicket = {{ $tot_ticket }};
        var valClosedTicket = {{ $close_tcket }};
    </script>
    <script src="{{ asset('assets') }}/js/mychart.js"></script>
@endpush
