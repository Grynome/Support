@php
    use Illuminate\Support\Facades\DB;
    $role = auth()->user()->role;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - Summary Ticket Each Week</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Each Week</h4>
            </div>
            <form action="{{ route('sorting.eachWeek') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if ($role != 15)
                        <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                            <select class="js-example-basic-single form-select" data-width="100%" name="chosen_prj">
                                <option value="">- Choose Project -</option>
                                @foreach ($project as $item)
                                    <option value="{{ $item->project_id }}"
                                        {{ $item->project_id == $cprj ? 'selected' : '' }}>
                                        {{ $item->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_month">
                            <option value="">- Choose Month -</option>
                            @foreach ($loop_month as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}" {{ $monthNumber == $month ? 'selected' : '' }}>
                                    {{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_year">
                            <option value="">- Choose Year -</option>
                            @foreach ($loop_year as $years)
                                <option value="{{ $years }}" {{ $years == $year ? 'selected' : '' }}>
                                    {{ $years }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="search"></i>
                        Sort
                    </button>
                </form>
                <form action="{{ url('export/Weekly/Summary-Ticket') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$month}}" name="month_wkl_tc">
                    <input type="hidden" value="{{$year}}" name="year_wkl_tc">
                    <button type="submit" class="btn btn-success btn-icon-text mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                        Download Excel
                    </button>
                </form>
            </div>
        </div>
        @if ($role != 15)
            <div class="row grid-margin">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="display" class="table">
                                    <thead>
                                        <tr>
                                            <th>Time Frame</th>
                                            <th>Total Ticket</th>
                                            <th>Pending</th>
                                            <th>Close</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($eachWeek as $item)
                                            <tr>
                                                <td>{{ $item->timeframe }}</td>
                                                <td>{{ $item->data_count }}</td>
                                                <td>{{ $item->pending }}</td>
                                                <td>{{ $item->close_sum }}</td>
                                                <td>
                                                    @if (!empty($item->pending))
                                                        @php
                                                            if (empty($cprj)) {
                                                                $project = 'null';
                                                            } else {
                                                                $project = $cprj;
                                                            }
                                                            
                                                        @endphp
                                                        <a
                                                            href="{{ url("Pending-EW/Timeframe=$item->timeframe/$project/$month/$year") }}">
                                                            <button class="btn btn-outline-dark btn-icon-text btn-sm">
                                                                <i class="btn-icon-prepend" data-feather="search"></i> Detil
                                                                Pending
                                                            </button>
                                                        </a>
                                                        &nbsp;
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: rgba(233, 236, 239, 0.5);">
                                            <th>Summary</th>
                                            <th>{{ $total_entry }}</th>
                                            <th>{{ $total_pending }}</th>
                                            <th>{{ $total_close }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($role == 15 || $role == 20)
            <div class="row grid-margin">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Information :</label><br>
                                <div class="badge rounded-pill bg-created ms-auto">
                                    <h6>Created</h6>
                                </div>
                                <div class="badge rounded-pill bg-pending ms-auto">
                                    <h6>Pending</h6>
                                </div>
                                <div class="badge rounded-pill bg-close ms-auto">
                                    <h6>Close</h6>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="display" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Partner</th>
                                            <th rowspan="2" id="col-sticky">Project</th>
                                            <th colspan="3">Week 1</th>
                                            <th colspan="3">Week 2</th>
                                            <th colspan="3">Week 3</th>
                                            <th colspan="3">Week 4</th>
                                            <th colspan="3">Week 5</th>
                                        </tr>
                                        <tr>
                                            <th>CR</th>
                                            <th>PN</th>
                                            <th>CL</th>
                                            <th>CR</th>
                                            <th>PN</th>
                                            <th>CL</th>
                                            <th>CR</th>
                                            <th>PN</th>
                                            <th>CL</th>
                                            <th>CR</th>
                                            <th>PN</th>
                                            <th>CL</th>
                                            <th>CR</th>
                                            <th>PN</th>
                                            <th>CL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $noc = 1;
                                        @endphp
                                        @foreach ($compare as $item)
                                            <tr>
                                                <td>{{ $noc }}</td>
                                                <td>{{ $item->partner }}</td>
                                                <td id="col-sticky">{{ $item->project_name }}</td>
                                                <td
                                                    style="background-color: {{ $item->total1 != 0 ? '#36A2EB' : 'transparent' }}">
                                                    {{ $item->total1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->pending1 != 0 ? '#FFCE56' : 'transparent' }}">
                                                    {{ $item->pending1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->close1 != 0 ? '#05a34a' : 'transparent' }}">
                                                    {{ $item->close1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->total2 != 0 ? '#36A2EB' : 'transparent' }}">
                                                    {{ $item->total2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->pending2 != 0 ? '#FFCE56' : 'transparent' }}">
                                                    {{ $item->pending2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->close2 != 0 ? '#05a34a' : 'transparent' }}">
                                                    {{ $item->close2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->total3 != 0 ? '#36A2EB' : 'transparent' }}">
                                                    {{ $item->total3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->pending3 != 0 ? '#FFCE56' : 'transparent' }}">
                                                    {{ $item->pending3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->close3 != 0 ? '#05a34a' : 'transparent' }}">
                                                    {{ $item->close3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->total4 != 0 ? '#36A2EB' : 'transparent' }}">
                                                    {{ $item->total4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->pending4 != 0 ? '#FFCE56' : 'transparent' }}">
                                                    {{ $item->pending4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->close4 != 0 ? '#05a34a' : 'transparent' }}">
                                                    {{ $item->close4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->total5 != 0 ? '#36A2EB' : 'transparent' }}">
                                                    {{ $item->total5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->pending5 != 0 ? '#FFCE56' : 'transparent' }}">
                                                    {{ $item->pending5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->close5 != 0 ? '#05a34a' : 'transparent' }}">
                                                    {{ $item->close5 }}</td>
                                            </tr>
                                            @php
                                                $noc++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="weeklyTicket"></canvas>
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
        var chartData = {!! json_encode($chartData) !!};
    </script>
    <script src="{{ asset('assets') }}/js/mychart.js"></script>
@endpush
