@php
    use Carbon\Carbon;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - Pending Ticket</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Pending Ticket</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                            data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            Search
                                        </button>
                                        &nbsp;
                                        <form action="{{url("export/Pending-Ticket/Report")}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$pdTC_prj}}" name="pdtcFlter">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend" data-feather="download"></i>
                                                Download
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
                                            <form action="{{ route('sorting.pdTicket') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="prj_pd_tc">
                                                                    <option value="">- Choose Project -</option>
                                                                    @foreach ($project as $item)
                                                                        <option value="{{ $item->project_id }}"
                                                                            {{ $item->project_id == $pdTC_prj ? 'selected' : '' }}>
                                                                            {{ $item->project_name }}</option>
                                                                    @endforeach
                                                                </select>
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
                                        <th>Notiket</th>
                                        <th>Case ID</th>
                                        <th>Service Point</th>
                                        <th>Kota User</th>
                                        <th>Project</th>
                                        <th>Pending Status</th>
                                        <th>Catatan</th>
                                        <th>Onsite</th>
                                        <th>Aging Ticket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($report as $item)
                                        @php
                                            $now = Carbon::now()->addHours(7);
                                            $notiket = $item->notiket;
                                            $mail_date = Carbon::parse($item->ticketcoming);
                                            $agingTicket = $mail_date->diffInDays($now);
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->service_name }}</td>
                                            <td>{{ $item->kota }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->root_cause }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>{{ $item->total_onsite }}</td>
                                            <td>{{ $agingTicket }}</td>
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