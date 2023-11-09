@php
    if ($vdt == 'Week') {
        $varTbl = 'display';
        $num_int = 5;
    } else {
        $varTbl = 'd-Monthly';
        $num_int = 12;
    }
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
                <h4 class="mb-3 mb-md-0">Data Each {{ $vdt }}</h4>
            </div>
            <form action="{{ route('sorting.ewSP', ['validate' => $vdt]) }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if ($role != 15)
                        <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                            <select class="js-example-basic-single form-select" data-width="100%" name="chosen_ewSP">
                                <option value="">- Choose SP -</option>
                                @foreach ($office as $item)
                                    <option value="{{ $item->service_id }}"
                                        {{ $item->service_id == $ewSP ? 'selected' : '' }}>
                                        {{ $item->service_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($vdt == 'Week')
                            <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                                <select class="js-example-basic-single form-select" data-width="100%" name="chosen_monthSP">
                                    <option value="">- Choose Month -</option>
                                    @foreach ($loop_month as $monthNumber => $monthName)
                                        <option value="{{ $monthNumber }}" {{ $monthNumber == $month ? 'selected' : '' }}>
                                            {{ $monthName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif
                    <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_yearSP">
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
                <form action="{{ url("export/$vdt/Summary-SP") }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$month}}" name="month_wkl_sp">
                    <input type="hidden" value="{{$year}}" name="year_wkl_sp">
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
                                        @foreach ($eachWeek as $item)
                                            <tr>
                                                <td>{{ $item->timeframe }}</td>
                                                <td>{{ $item->data_count }}</td>
                                                <td>{{ $item->pending }}</td>
                                                <td>{{ $item->close_sum }}</td>
                                                <td>
                                                    @php
                                                        if (empty($ewSP)) {
                                                            $sp = 'null';
                                                        } else {
                                                            $sp = $ewSP;
                                                        }
                                                    @endphp
                                                    @if ($vdt == 'Week')
                                                        <a
                                                            href="{{ url("Summary-SP/$vdt/$item->timeframe/$sp/$month/$year") }}">
                                                            <button class="btn btn-outline-dark btn-icon btn-sm">
                                                                <i class="btn-icon-prepend" data-feather="search"></i>
                                                            </button>
                                                        </a>
                                                    @else
                                                        @php
                                                            $month = 'Null';
                                                        @endphp
                                                        <a
                                                            href="{{ url("Summary-SP/$vdt/$item->month_number/$sp/$month/$year") }}">
                                                            <button class="btn btn-outline-dark btn-icon btn-sm">
                                                                <i class="btn-icon-prepend" data-feather="search"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
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
                                <table id="{{ $varTbl }}" class="table table-bordered table-hover">
                                    <thead>
                                        @if ($vdt == 'Week')
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2" id="col-sticky">Service Point</th>
                                                <th colspan="3">Week 1</th>
                                                <th colspan="3">Week 3</th>
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
                                        @else
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2" id="col-sticky">Service Point</th>
                                                <th colspan="3">Jan</th>
                                                <th colspan="3">Feb</th>
                                                <th colspan="3">March</th>
                                                <th colspan="3">April</th>
                                                <th colspan="3">May</th>
                                                <th colspan="3">June</th>
                                                <th colspan="3">July</th>
                                                <th colspan="3">August</th>
                                                <th colspan="3">Sept</th>
                                                <th colspan="3">Oct</th>
                                                <th colspan="3">Nov</th>
                                                <th colspan="3">DEC</th>
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
                                                <th>CR</th>
                                                <th>PN</th>
                                                <th>CL</th>
                                                <th>CR</th>
                                                <th>PN</th>
                                                <th>CL</th>
                                            </tr>
                                        @endif
                                    </thead>
                                    <tbody>
                                        @php
                                            $noc = 1;
                                        @endphp
                                        @foreach ($compare as $item)
                                            <tr>
                                                <td>{{ $noc }}</td>
                                                <td id="col-sticky">
                                                    @if (empty($item->service_name))
                                                        Null
                                                    @else
                                                        {{ $item->service_name }}
                                                    @endif
                                                </td>
                                                @if ($vdt == 'Week')
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
                                                @else
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
                                                    <td
                                                        style="background-color: {{ $item->total6 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total6 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending6 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending6 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close6 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close6 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total7 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total7 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending7 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending7 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close7 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close7 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total8 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total8 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending8 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending8 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close8 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close8 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total9 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total9 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending9 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending9 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close9 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close9 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total10 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total10 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending10 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending10 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close10 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close10 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total11 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total11 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending11 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending11 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close11 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close11 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->total12 != 0 ? '#36A2EB' : 'transparent' }}">
                                                        {{ $item->total12 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->pending12 != 0 ? '#FFCE56' : 'transparent' }}">
                                                        {{ $item->pending12 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->close12 != 0 ? '#05a34a' : 'transparent' }}">
                                                        {{ $item->close12 }}</td>
                                                @endif
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
    </div>
@endsection
