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
                <li class="breadcrumb-item active" aria-current="page">Report - Summary Activity Engineer Each
                    {{ $vdt }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Activity Engineer</h4>
            </div>
            <form action="{{ route('sorting.ewAE', ['validate' => $vdt]) }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if ($role != 15)
                        <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                            <select class="js-example-basic-single form-select" data-width="100%" name="chosen_enAE">
                                <option value="">- Choose Engineer -</option>
                                @foreach ($en as $item)
                                    <option value="{{ $item->nik }}" {{ $item->nik == $enAE ? 'selected' : '' }}>
                                        {{ $item->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($vdt == 'Week')
                            <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                                <select class="js-example-basic-single form-select" data-width="100%" name="chosen_monthAE">
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
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_yearAE">
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
                <form action="{{ url("export/$vdt/Summary-AE") }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$month}}" name="month_wkl_ae">
                    <input type="hidden" value="{{$year}}" name="year_wkl_ae">
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
                                            <th>Total Berangkat</th>
                                            <th>Total Schedule</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getActEN as $item)
                                            <tr>
                                                <td>{{ $item->timeframe }}</td>
                                                <td>{{ $item->data_count }}</td>
                                                <td>{{ $item->sumOnDuty }}</td>
                                                <td>{{ $item->sumSchedule }}</td>
                                                <td>
                                                    @php
                                                        if (empty($enAE)) {
                                                            $en = 'null';
                                                        } else {
                                                            $en = $enAE;
                                                        }
                                                    @endphp
                                                    @if ($vdt == 'Week')
                                                        <a
                                                            href="{{ url("Summary-AE/$vdt/$item->timeframe/$en/$month/$year") }}">
                                                            <button class="btn btn-outline-dark btn-icon btn-sm">
                                                                <i class="btn-icon-prepend" data-feather="search"></i>
                                                            </button>
                                                        </a>
                                                    @else
                                                        @php
                                                            $month = 'Null';
                                                        @endphp
                                                        <a
                                                            href="{{ url("Summary-AE/$vdt/$item->month_number/$en/$month/$year") }}">
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
                                        {{-- <tr style="background-color: rgba(233, 236, 239, 0.5);">
                                            <th>Summary</th>
                                            <th>{{$act->total}}</th>
                                            <th></th>
                                        </tr> --}}
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
                            <div class="table-responsive">
                                <table id="{{ $varTbl }}" class="table table-bordered table-hover">
                                    <thead>
                                        @if ($vdt == 'Week')
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2" id="col-sticky">Engineer</th>
                                                <th colspan="2">Week 1</th>
                                                <th colspan="2">Week 2</th>
                                                <th colspan="2">Week 3</th>
                                                <th colspan="2">Week 4</th>
                                                <th colspan="2">Week 5</th>
                                            </tr>
                                            <tr>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2" id="col-sticky">Engineer</th>
                                                <th colspan="2">Jan</th>
                                                <th colspan="2">Feb</th>
                                                <th colspan="2">March</th>
                                                <th colspan="2">April</th>
                                                <th colspan="2">May</th>
                                                <th colspan="2">June</th>
                                                <th colspan="2">July</th>
                                                <th colspan="2">August</th>
                                                <th colspan="2">Sept</th>
                                                <th colspan="2">Oct</th>
                                                <th colspan="2">Nov</th>
                                                <th colspan="2">DEC</th>
                                            </tr>
                                            <tr>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
                                                <th>Go</th>
                                                <th>SCH</th>
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
                                                <td id="col-sticky">{{ $item->full_name }}</td>
                                                @if ($vdt == 'Week')
                                                    <td
                                                        style="background-color: {{ $item->go1 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go1 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule1 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule1 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go2 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go2 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule2 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule2 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go3 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go3 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule3 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule3 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go4 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go4 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule4 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule4 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go5 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go5 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule5 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule5 }}</td>
                                                @else
                                                    <td
                                                        style="background-color: {{ $item->go1 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go1 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule1 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule1 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go2 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go2 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule2 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule2 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go3 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go3 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule3 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule3 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go4 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go4 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule4 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule4 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go5 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go5 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule5 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule5 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go6 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go6 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule6 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule6 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go7 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go7 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule7 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule7 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go8 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go8 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule8 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule8 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go9 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go9 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule9 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule9 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go10 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go10 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule10 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule10 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go11 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go11 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule11 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule11 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->go12 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->go12 }}</td>
                                                    <td
                                                        style="background-color: {{ $item->schedule12 == 0 ? '#FF6384' : 'transparent' }}">
                                                        {{ $item->schedule12 }}</td>
                                                @endif
                                            </tr>
                                            @php
                                                $noc++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr style="background-color: rgba(233, 236, 239, 0.5);">
                                            <th>Summary</th>
                                            <th>{{ $total_entry }}</th>
                                            <th>{{ $total_pending }}</th>
                                            <th>{{ $total_close }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
