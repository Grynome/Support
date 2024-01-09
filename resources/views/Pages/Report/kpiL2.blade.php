@extends('Theme/header')
@php
    if (empty($str) && empty($ndr)) {
        $tanggal1 = $stsd;
        $tanggal2 = $nded;
    } else {
        $tanggal1 = $str;
        $tanggal2 = $ndr;
    }
@endphp
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Report L2  </li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Data Report L2</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                            data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            Filter Report
                                        </button>
                                        &nbsp;
                                        <form action="{{url("export-KPI/L2/Report")}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$ske}}" name="srt_kpi_L2">
                                            <input type="hidden" value="{{$tanggal1}}" name="srt_kpiL2_st">
                                            <input type="hidden" value="{{$tanggal2}}" name="srt_kpiL2_nd">
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
                                            <form action="{{ route('sorting.kpiL2') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="l2_list">
                                                                <option value="">- Choose L2 -</option>
                                                                @foreach ($l2 as $item)
                                                                    <option value="{{ $item->nik }}"
                                                                        {{ $item->nik == $ske ? 'selected' : '' }}>
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
                                                                        placeholder="First Date" name="kpiL2_st_date_report"
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
                                                                        value="{{ $tanggal2 }}" name="kpiL2_nd_date_report"
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
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Engineer</th>
                                        <th>Project</th>
                                        <th>Kabupaten</th>
                                        <th>Entry Date</th>
                                        <th>Stand By</th>
                                        <th>Work Start</th>
                                        <th>Work Stop</th>
                                        <th>End Case</th>
                                        <th>Close Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($report as $item)
                                        <tr>
                                            @php
                                                $notiket = $item->notiket;
                                            @endphp
                                            <td>{{ $no }}</td>
                                            <td>{{ $notiket }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->kab }}</td>
                                            <td>
                                                @if ($item->visitting == 0)
                                                    {{ $item->entrydate }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->sb }}</td>
                                            <td>{{ $item->work_start }}</td>
                                            <td>{{ $item->work_stop }}</td>
                                            <td>{{ $item->end_case }}</td>
                                            <td>{{ $item->closedate }}</td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: rgba(233, 236, 239, 0.2);">
                                        <th colspan="2">Total Onsite</th>
                                        <th colspan="6"></th>
                                        <th>
                                            {{$all_total->onsite}} 
                                            x
                                        </th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <tr style="background-color: rgba(233, 236, 239, 0.2);">
                                        <th colspan="2">Total Ticket</th>
                                        <th colspan="7"></th>
                                        <th>
                                            {{$total_ticket}}
                                            Ticket
                                        </th>
                                        <th colspan="1"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom')
@endpush