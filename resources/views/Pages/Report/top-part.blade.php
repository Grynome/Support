@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - Top Part</li>
            </ol>
        </nav>
        
        
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Top Part</h4>
            </div>
            <form action="{{ route('sorting.topPart') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_prj_part">
                            <option value="">- Choose Project -</option>
                            @foreach ($project as $item)
                                <option value="{{ $item->project_id }}"
                                    {{ $item->project_id == $prj_part ? 'selected' : '' }}>
                                    {{ $item->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
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
            </div>
        </div>
        <div class="row grid-margin mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                            <div>
                                <h4 class="card-title">Part Each Week</h4>
                            </div>
                            <form action="{{url("export/Top-Part/EW/Report")}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$month}}" name="month_ew_part">
                                <input type="hidden" value="{{$year}}" name="year_ew_part">
                                <input type="hidden" value="{{$prj_part}}" name="prj_ew_part">
                                <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="download"></i>
                                    Excel Each Week
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th id="col-sticky">Category</th>
                                        <th>Week 1</th>
                                        <th>Week 2</th>
                                        <th>Week 3</th>
                                        <th>Week 4</th>
                                        <th>Week 5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($part_ew as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->type_name }}</td>
                                            <td>{{ $item->week1 }}</td>
                                            <td>{{ $item->week2 }}</td>
                                            <td>{{ $item->week3 }}</td>
                                            <td>{{ $item->week4 }}</td>
                                            <td>{{ $item->week5 }}</td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                            <div>
                                <h4 class="card-title">Part Each Month</h4>
                            </div>
                            <form action="{{url("export/Top-Part/EM/Report")}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$year}}" name="year_em_part">
                                <input type="hidden" value="{{$prj_part}}" name="prj_em_part">
                                <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="download"></i>
                                    Excel Each Month
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th id="col-sticky">Category</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>March</th>
                                        <th>April</th>
                                        <th>May</th>
                                        <th>June</th>
                                        <th>July</th>
                                        <th>August</th>
                                        <th>Sept</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>DEC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($part_em as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->type_name }}</td>
                                            <td>{{ $item->jan }}</td>
                                            <td>{{ $item->feb }}</td>
                                            <td>{{ $item->march }}</td>
                                            <td>{{ $item->april }}</td>
                                            <td>{{ $item->may }}</td>
                                            <td>{{ $item->june }}</td>
                                            <td>{{ $item->july }}</td>
                                            <td>{{ $item->aug }}</td>
                                            <td>{{ $item->sept }}</td>
                                            <td>{{ $item->october }}</td>
                                            <td>{{ $item->nov }}</td>
                                            <td>{{ $item->december }}</td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection