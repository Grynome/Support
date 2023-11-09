@extends('Theme/header')
@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;

    if (empty($st_dt) && empty($nd_dt)) {
        $tanggal1 = $now_dt;
        $tanggal2 = $now_dt;
    } else {
        $tanggal1 = $st_dt;
        $tanggal2 = $nd_dt;
    }
@endphp
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Report Activity </li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Helpdesk Activity</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text"
                                            data-bs-toggle="modal" data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            Filter Report
                                        </button>
                                        &nbsp;
                                        <form action="{{url("export/Act-Helpdesk/Report")}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$user_dt}}" name="get_hp_act">
                                            <input type="hidden" value="{{$tanggal1}}" name="get_stDt">
                                            <input type="hidden" value="{{$tanggal2}}" name="get_ndDT">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend" data-feather="download"></i>
                                                Download Excel
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
                                            <form action="{{ route('sorting.act.helpdesk') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="srt_user_hp">
                                                                <option value="">- Choose User -</option>
                                                                @foreach ($user_hp as $item)
                                                                    <option value="{{ $item->nik }}"
                                                                        {{ $user_dt == $item->nik ? 'selected' : '' }}>
                                                                        {{ $item->full_name }}</option>
                                                                @endforeach
                                                            </select>
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
                                                                        placeholder="First Date" name="srt_st_date_act"
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
                                                                        value="{{ $tanggal2 }}" name="srt_nd_date_act"
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
            @if ($depart == 4 || $role == 20)
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="display" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Notiket</th>
                                            <th>Type Note</th>
                                            <th>Note</th>
                                            <th>User</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($act_hp as $item)
                                            <tr>
                                                @php
                                                    $notiket = $item->notiket;
                                                @endphp
                                                <td>{{ $no }}</td>
                                                <td>{{ $notiket }}</td>
                                                <td>{{ $item->ktgr_note }}</td>
                                                <td>{{ $item->note }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->created_at }}</td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: rgba(233, 236, 239, 0.2);">
                                            <th colspan="2">Total Ticket Handled</th>
                                            <th colspan="2"></th>
                                            <th>
                                                @if (!empty($total_ticket->tot_all))
                                                    {{ $total_ticket->tot_all }}
                                                @else
                                                    0
                                                @endif
                                                Ticket
                                            </th>
                                            <th colspan="1"></th>
                                        </tr>
                                        <tr style="background-color: rgba(233, 236, 239, 0.2);">
                                            <th colspan="2">Total Activity</th>
                                            <th colspan="3"></th>
                                            <th>
                                                {{ $all_act }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="d-none d-md-block col-md-3">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">Total Create Ticket by User</h6>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($get_user as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="me-2">
                                        <p>{{ $no++; }}.</p>
                                    </div>
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37"
                                        alt="">
                                    <div class="ms-2">
                                        <p>{{ $item->full_name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger fw-bolder ms-auto tx-13">{{$item->total_tiket}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom')
@endpush