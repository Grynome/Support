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
                <li class="breadcrumb-item active" aria-current="page">Report - Summary Data Helpdesk</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Summary</h4>
            </div>
            <form action="{{ route('sorting.ewHP', ['validate' => $vdt]) }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if ($role != 15)
                        <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                            <select class="js-example-basic-single form-select" data-width="100%" name="chosen_enHP">
                                <option value="">- Choose Helpdesk -</option>
                                @foreach ($hp as $item)
                                    <option value="{{ $item->nik }}" {{ $item->nik == $enHP ? 'selected' : '' }}>
                                        {{ $item->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($vdt == 'Week')
                            <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                                <select class="js-example-basic-single form-select" data-width="100%" name="chosen_monthHP">
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
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_yearHP">
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
            <form action="{{ url("export/$vdt/Summary-Act/Helpdesk") }}" method="POST">
                @csrf
                @if ($vdt == 'Week')
                    <input type="hidden" value="{{$month}}" name="act_month_srt">
                @endif
                <input type="hidden" value="{{$year}}" name="act_year_srt">
                <button type="submit" class="btn btn-success btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                    Excel
                </button>
            </form>
            <form action="{{ url("export/Daily/Summary-Act/Helpdesk") }}" method="POST">
                @csrf
                <input type="hidden" value="{{$month}}" name="act_month_srt">
                <input type="hidden" value="{{$year}}" name="act_year_srt">
                <button type="submit" class="btn btn-success btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                    Daily
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
                                        <th>Total Activity</th>
                                        <th>Ticket Created</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eachWeek as $item)
                                        <tr>
                                            <td>{{ $item->timeframe }}</td>
                                            <td>{{ $item->data_count }}</td>
                                            <td>{{ $item->sumTicket }}</td>
                                            <td>
                                                @php
                                                    if (empty($enHP)) {
                                                        $hp = 'null';
                                                    } else {
                                                        $hp = $enHP;
                                                    }
                                                @endphp
                                                @if ($vdt == 'Week')
                                                    <a
                                                        href="{{ url("Summary-HP/$vdt/$item->timeframe/$hp/$month/$year") }}">
                                                        <button class="btn btn-outline-dark btn-icon-text btn-sm">
                                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                                            View
                                                        </button>
                                                    </a>
                                                @else
                                                    @php
                                                        $month = 'Null';
                                                    @endphp
                                                    <a
                                                        href="{{ url("Summary-HP/$vdt/$item->month_number/$hp/$month/$year") }}">
                                                        <button class="btn btn-outline-dark btn-icon-text btn-sm">
                                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                                            View
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
                                            <th rowspan="2" id="col-sticky">User</th>
                                            <th colspan="4">Week 1</th>
                                            <th colspan="4">Week 2</th>
                                            <th colspan="4">Week 3</th>
                                            <th colspan="4">Week 4</th>
                                            <th colspan="4">Week 5</th>
                                        </tr>
                                        <tr>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2" id="col-sticky">User</th>
                                            <th colspan="4">Jan</th>
                                            <th colspan="4">Feb</th>
                                            <th colspan="4">March</th>
                                            <th colspan="4">April</th>
                                            <th colspan="4">May</th>
                                            <th colspan="4">June</th>
                                            <th colspan="4">July</th>
                                            <th colspan="4">August</th>
                                            <th colspan="4">Sept</th>
                                            <th colspan="4">Oct</th>
                                            <th colspan="4">Nov</th>
                                            <th colspan="4">DEC</th>
                                        </tr>
                                        <tr>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
                                            <th>Act</th>
                                            <th>Hdld</th>
                                            <th>Crt</th>
                                            <th>Cl</th>
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
                                            <td id="col-sticky">{{ $item->act_user }}</td>
                                            @if ($vdt == 'Week')
                                                <td
                                                    style="background-color: {{ $item->activity1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed5 }}</td>
                                            @else
                                                <td
                                                    style="background-color: {{ $item->activity1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed1 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed1 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed2 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed2 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed3 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed3 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed4 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed4 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed5 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed5 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity6 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity6 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled6 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled6 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created6 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created6 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed6== 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed6}}</td>
                                                <td
                                                    style="background-color: {{ $item->activity7 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity7 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled7 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled7 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created7 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created7 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed7 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed7 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity8 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity8 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled8 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled8 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created8 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created8 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed8 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed8 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity9 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity9 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled9 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled9 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created9 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created9 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed9 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed9 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity10 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity10 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled10 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled10 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created10 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created10 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed10 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed10 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity11 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity11 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled11 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled11 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created11 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created11 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed11 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed11 }}</td>
                                                <td
                                                    style="background-color: {{ $item->activity12 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->activity12 }}</td>
                                                <td
                                                    style="background-color: {{ $item->handled12 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->handled12 }}</td>
                                                <td
                                                    style="background-color: {{ $item->created12 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->created12 }}</td>
                                                <td
                                                    style="background-color: {{ $item->closed12 == 0 ? '#FF6384' : 'transparent' }}">
                                                    {{ $item->closed12 }}</td>
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
