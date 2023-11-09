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
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Report Lat & Lng </li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Latitude & Longitude Report</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text"
                                            data-bs-toggle="modal" data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            Filter Report
                                        </button>
                                        &nbsp;
                                        <form action="{{ url('export-LatLng/Report') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $skp }}" name="srt_latlng_prj">
                                            <input type="hidden" value="{{ $tanggal1 }}" name="srt_latlng_st">
                                            <input type="hidden" value="{{ $tanggal2 }}" name="srt_latlng_nd">
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
                                            <form action="{{ route('sorting.latlng') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="sort_ltlg_project">
                                                                    <option value="">- Choose Project -</option>
                                                                    @foreach ($project as $item)
                                                                        <option value="{{ $item->project_id }}"
                                                                            {{ $skp == $item->project_id ? 'selected' : '' }}>
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
                                                                        placeholder="First Date" name="ltlg_st_date_report"
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
                                                                        value="{{ $tanggal2 }}"
                                                                        name="ltlg_nd_date_report" data-input>
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
                            <table id="display" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2" id="col-sticky">Notiket</th>
                                        <th rowspan="2" id="col-sticky">Engineer</th>
                                        <th rowspan="2">Project Name</th>
                                        <th rowspan="2">Kab.</th>
                                        <th colspan="2">Received</th>
                                        <th colspan="2">Go</th>
                                        <th colspan="2">Arrived</th>
                                        <th colspan="2">Work Start</th>
                                        <th colspan="2">Work Stop</th>
                                        <th colspan="2">Leave Site</th>
                                        <th colspan="2">Travel Stop</th>
                                    </tr>
                                    <tr>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                        <th>Lat</th>
                                        <th>Lng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($report as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td id="col-sticky">{{ $item->notiket }}</td>
                                            <td id="col-sticky">{{ $item->full_name }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->kab }}</td>
                                            <td>{{ $item->lat_receive }}</td>
                                            <td>{{ $item->lng_receive }}</td>
                                            <td>{{ $item->lat_gow }}</td>
                                            <td>{{ $item->lng_gow }}</td>
                                            <td>{{ $item->lat_arrive }}</td>
                                            <td>{{ $item->lng_arrive }}</td>
                                            <td>{{ $item->lat_ws }}</td>
                                            <td>{{ $item->lng_ws }}</td>
                                            <td>{{ $item->lat_wtp }}</td>
                                            <td>{{ $item->lng_wtp }}</td>
                                            <td>{{ $item->lat_ls }}</td>
                                            <td>{{ $item->lng_ls }}</td>
                                            <td>{{ $item->lat_ts }}</td>
                                            <td>{{ $item->lng_ts }}</td>
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
@push('custom')
@endpush    