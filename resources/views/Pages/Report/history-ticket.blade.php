@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - History Ticket</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">History Ticket</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                            data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            History Report
                                        </button>
                                        &nbsp;
                                        <form action="{{url("export/History-SLA-Ticket/Report")}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$hs_prj}}" name="hst_prj">
                                            <input type="hidden" value="{{$tanggal1}}" name="hst_st">
                                            <input type="hidden" value="{{$tanggal2}}" name="hst_nd">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend" data-feather="download"></i>
                                                Excel SLA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal fade" id="filter-report-ticket" tabindex="-1"
                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Filter
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <form action="{{ route('sorting.hisTicket') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="prj_hs_report">
                                                                    <option value="">- Choose Project -</option>
                                                                    @foreach ($project as $item)
                                                                        <option value="{{ $item->project_id }}"
                                                                            {{ $item->project_id == $hs_prj ? 'selected' : '' }}>
                                                                            {{ $item->project_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12"><label for=""
                                                                class="form-label">Range Date</label></div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="First Date" name="st_date_his_report"
                                                                        value="{{ $tanggal1 }}" data-input>
                                                                    <span class="input-group-text input-group-addon"
                                                                        data-toggle><i data-feather="calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Second Date"
                                                                        value="{{ $tanggal2 }}" name="nd_date_his_report"
                                                                        data-input>
                                                                    <span class="input-group-text input-group-addon"
                                                                        data-toggle><i data-feather="calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info sort">Sort</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h4 class="card-title">Data Report</h4>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tiket ID</th>
                                        <th>Case ID</th>
                                        <th>Location</th>
                                        <th>Project</th>
                                        <th>Email Coming</th>
                                        <th>Entry Date</th>
                                        <th>Deadline</th>
                                        <th>Close Date</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($report as $item)
                                        @php
                                            $notiket = $item->notiket;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->severity_name }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->ticketcoming }}</td>
                                            <td>{{ $item->entrydate }}</td>
                                            <td>{{ $item->deadline }}</td>
                                            <td>{{ $item->closedate }}</td>
                                            <td>
                                                <a href="{{url("Detil/History-Ticket/$notiket")}}">
                                                    <button class="btn btn-outline-dark btn-icon btn-sm">
                                                        <i class="btn-icon-prepend" data-feather="search"></i>
                                                    </button>
                                                </a>
                                            </td>
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