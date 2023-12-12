@push('css-plugin')
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
@endpush
@extends('Theme/header')
@php
    if (empty($str) && empty($ndr)) {
        $tanggal1 = $stsd;
        $tanggal2 = $ndsd;
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
                <li class="breadcrumb-item"><a href="#">Report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report Ticket</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Report Ticket</h4>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-inverse-primary btn-icon-text"
                                            data-bs-toggle="modal" data-bs-target="#filter-report-ticket">
                                            <i class="btn-icon-prepend" data-feather="search"></i>
                                            Filter Report
                                        </button>
                                        &nbsp;
                                        <form action="{{ url('export-ticket/Report') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $sts }}" name="ex_sts">
                                            <input type="hidden" value="{{ $prt }}" name="ex_prt">
                                            <input type="hidden" value="{{ $prj }}" name="ex_prj">
                                            <input type="hidden" value="{{ $sp }}" name="ex_sp">
                                            <input type="hidden" value="{{ $tanggal1 }}" name="ex_st">
                                            <input type="hidden" value="{{ $tanggal2 }}" name="ex_nd">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend mdi mdi-file-excel"></i>
                                                Data Detil
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="{{ url('Data/Report/PIC') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $sts }}" name="ex_stsP">
                                            <input type="hidden" value="{{ $prt }}" name="ex_prtP">
                                            <input type="hidden" value="{{ $prj }}" name="ex_prjP">
                                            <input type="hidden" value="{{ $sp }}" name="ex_spP">
                                            <input type="hidden" value="{{ $tanggal1 }}" name="ex_stP">
                                            <input type="hidden" value="{{ $tanggal2 }}" name="ex_ndP">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend mdi mdi-file-excel"></i>
                                                Data PIC
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="{{ url('Data/Report/Split') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $sts }}" name="ex_stS">
                                            <input type="hidden" value="{{ $prt }}" name="ex_prtS">
                                            <input type="hidden" value="{{ $prj }}" name="ex_prjS">
                                            <input type="hidden" value="{{ $sp }}" name="ex_spS">
                                            <input type="hidden" value="{{ $tanggal1 }}" name="ex_stS">
                                            <input type="hidden" value="{{ $tanggal2 }}" name="ex_ndS">
                                            <button type="submit" class="btn btn-inverse-info btn-icon-text">
                                                <i class="btn-icon-prepend mdi mdi-file-excel"></i>
                                                Data Split Onsite
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
                                            <form action="{{ route('sorting.report') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="Choose Sts" class="border-bottom mb-1"> ~ Status
                                                                ~</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="stats_report">
                                                                <option value="">- Choose -</option>
                                                                <option value="1" {{ $sts == 1 ? 'selected' : '' }}>
                                                                    Open
                                                                </option>
                                                                <option value="2" {{ $sts == 2 ? 'selected' : '' }}>
                                                                    Closed
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 border-end-lg mb-3">
                                                            <label for="Choose Partner" class="border-bottom mb-1"> ~
                                                                Partner ~</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="prt_id" id="dt-prt-select">
                                                                <option value="">- Choose -</option>
                                                                @foreach ($partner as $item)
                                                                    <option value="{{ $item->partner_id }}"
                                                                        {{ $prt == $item->partner_id ? 'selected' : '' }}>
                                                                        {{ $item->partner }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="Choose Project" class="border-bottom mb-1"> ~
                                                                Project ~</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="sort_prj_report" id="dt-get-prj">
                                                                <option value="">- Choose -</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="Choose SP" class="border-bottom mb-1"> ~ Service
                                                                Point ~</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="sort_sp_report">
                                                                <option value="">- Choose -</option>
                                                                @foreach ($office as $item)
                                                                    <option value="{{ $item->service_id }}"
                                                                        {{ $sp == $item->service_id ? 'selected' : '' }}>
                                                                        {{ $item->service_name }}</option>
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
                                                                        placeholder="First Date" name="st_date_report"
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
                                                                        value="{{ $tanggal2 }}" name="nd_date_report"
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
                                        <th>Project</th>
                                        <th>Incoming e-mail</th>
                                        <th>Entry Date</th>
                                        <th>Delivered</th>
                                        <th>Go</th>
                                        <th>Work Start</th>
                                        <th>Work Stop</th>
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
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->ticketcoming }}</td>
                                            <td>{{ $item->entrydate }}</td>
                                            <td>{{ $item->arrive }}</td>
                                            <td>{{ $item->gow }}</td>
                                            <td>{{ $item->work_start }}</td>
                                            <td>{{ $item->work_stop }}</td>
                                            <td>{{ $item->closedate }}</td>
                                            <td>
                                                {{-- <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group"> --}}
                                                        <a href="{{ url("Data/Detil-Report/$notiket") }}">
                                                            <button class="btn btn-outline-dark btn-icon btn-sm">
                                                                <i class="btn-icon-prepend" data-feather="search"></i>
                                                            </button>
                                                        </a>
                                                        {{-- &nbsp;
                                                        <button class="btn btn-outline-warning btn-icon btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#updt-null{{$no}}">
                                                            <i class="btn-icon-prepend" data-feather="edit"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal fade bd-example-modal-lg" id="updt-null{{$no}}" tabindex="-1"
                                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sourceModalLabel">Fill on Null
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('sorting.ticket') }}"
                                                                    method="post" id="updt-on-null">
                                                                    @csrf
                                                                    <input type="text" style="display: none;"
                                                                        value="{{ $notiket }}"
                                                                        name="vald_tiket">
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-4">
                                                                            <label for="Choose Partner"
                                                                                class="form-label">Go</label>
                                                                            <div class="input-group flatpickr" id="null-gow">
                                                                                <input type="text"
                                                                                    value="{{ $item->gow }}"
                                                                                    class="form-control"
                                                                                    placeholder="Select Date/Time"
                                                                                    name="val-gow"
                                                                                    id="null-gow"
                                                                                    data-input>
                                                                                <span class="input-group-text input-group-addon" data-toggle><i
                                                                                        data-feather="calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="Choose Partner"
                                                                                class="form-label">Work Start</label>
                                                                            <div class="input-group flatpickr" id="null-ws">
                                                                                <input type="text"
                                                                                    value="{{ $item->work_start }}"
                                                                                    class="form-control"
                                                                                    placeholder="Select Date/Time"
                                                                                    name="val_ws"
                                                                                    id="null-ws"
                                                                                    data-input>
                                                                                <span class="input-group-text input-group-addon" data-toggle><i
                                                                                        data-feather="calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="Choose Partner"
                                                                                class="form-label">Work Stop</label>
                                                                            <div class="input-group flatpickr" id="null-wt">
                                                                                <input type="text"
                                                                                    value="{{ $item->work_stop }}"
                                                                                    class="form-control"
                                                                                    placeholder="Select Date/Time"
                                                                                    name="val_wt"
                                                                                    id="null-wt"
                                                                                    data-input>
                                                                                <span class="input-group-text input-group-addon" data-toggle><i
                                                                                        data-feather="calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-info btn-on-null">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
    <script>
        function dtProject(url, prt_id, project) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    prt_id: prt_id
                },
                success: function(data) {
                    if (data.length === 0) {
                        $('#' + project).empty();
                        $('#' + project).append(
                            '<option value="">- No Project found for the selected Partner -</option>');
                    } else {
                        $('#' + project).empty();
                        $('#' + project).append('<option value="">- Choose -</option>');
                        $.each(data, function(key, value) {
                            selected = '';
                            if ('{{ $prj }}' ==
                                key) {
                                selected = 'selected';
                            }
                            $('#' + project).append('<option value="' + key + '" ' + selected + '>' +
                                value + '</option>');
                        });
                    }
                }
            });
        }

        $(function() {
            var partnerSelect = $('#dt-prt-select');
            var projectSelect = $('#dt-get-prj');
            var selectedPartner = '{{ $prt }}';

            if (selectedPartner !== '') {
                partnerSelect.val(selectedPartner);
                dtProject('{{ route('GetdtProject') }}', partnerSelect.val(), 'dt-get-prj');
            } else {
                projectSelect.empty();
                projectSelect.append('<option value="">- Select Partner First -</option>');
            }

            partnerSelect.on('change', function() {
                var selectedPartnerId = $(this).val();
                if (selectedPartnerId === '') {
                    projectSelect.empty();
                    projectSelect.append('<option value="">- Choose -</option>');
                } else {
                    dtProject('{{ route('GetdtProject') }}', selectedPartnerId, 'dt-get-prj');
                }
            });
        });
    </script>
@endpush