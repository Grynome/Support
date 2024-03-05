@php
    use Carbon\Carbon;
    use App\Models\RefReqs;
@endphp
@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Expenses</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <h4 class="mb-3 mt-3 me-2 mb-md-0">Data Report Expenses</h4>
                                <form action="{{ url('export-data/Report=Expenses') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-inverse-info btn-icon" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Download Report">
                                        <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <div class="input-group flatpickr wd-200 me-2 mb-md-0" id="flatpickr-date">
                                    <span class="input-group-text input-group-addon bg-transparent border-secondary"
                                        data-toggle><i data-feather="calendar" class="text-secondary"></i></span>
                                    <input type="text" class="form-control bg-transparent border-secondary"
                                        placeholder="First Date" name="st_dx" value="{{ $sortDX1 }}" data-input>
                                </div>
                                <h6 class="me-2">s/d</h6>
                                <div class="input-group flatpickr wd-200 me-2 mb-md-0" id="flatpickr-date">
                                    <span class="input-group-text input-group-addon bg-transparent border-secondary"
                                        data-toggle><i data-feather="calendar" class="text-secondary"></i></span>
                                    <input type="text" class="form-control bg-transparent border-secondary"
                                        placeholder="Second Date" name="nd_dx" value="{{ $sortDX2 }}" data-input>
                                </div>
                                <h4 class="me-2">|</h4>
                                <button type="button" class="btn btn-outline-secondary btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                    Sort
                                </button>
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
                            <table id="dataTableExample" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Expenses</th>
                                        <th>Request Date</th>
                                        <th>Description</th>
                                        <th>Engineer</th>
                                        <th>Type Request</th>
                                        <th>Type Transport</th>
                                        <th>Kota</th>
                                        <th>Requested</th>
                                        @foreach ($categories as $id => $description)
                                            <th>{{ $description }}</th>
                                        @endforeach
                                        <th>Actually</th>
                                        <th>Rq<>Act</th>
                                        <th>Paid By</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $tN = 0;
                                        $tA = 0;
                                        $rqact = 0;
                                    @endphp
                                    @foreach ($dt_reqs as $item)
                                        @php
                                            $getRef = $refTC->get($item->id);
                                            $tln = $item->tln;
                                            $tla = $item->tla;
                                            $kembali = $tln - $tla;
                                            $reqs_date = Carbon::parse($item->reqs_date)->format('Y-m-d');
                                        @endphp
                                        <tr>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-outline-success btn-icon btn-sm btn-modal-rdrt"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="List Reference Tickets" data-rdrt-no="{{ $no }}">
                                                    <i data-feather="search"></i>
                                                </button>
                                                <div class="modal fade" id="drt{{ $no }}" tabindex="-1"
                                                    aria-labelledby="DtReqsModal" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container mb-3">
                                                                    <h6 class="card-title">
                                                                        <span class="input-group-text">
                                                                            List Reference Tickets
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                                <hr>
                                                                <div class="table-responsive">
                                                                    <table id="display" class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Notiket</th>
                                                                                <th>Onsite</th>
                                                                                <th>Option</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $non = 1;
                                                                            @endphp
                                                                            @foreach ($getRef as $val)
                                                                                <tr>
                                                                                    <td>{{ $non }}</td>
                                                                                    <td>{{ @$val->notiket }}</td>
                                                                                    <td>{{ @$val->reqs_at }}</td>
                                                                                    <td>
                                                                                        <a href="{{ url('Detail/Ticket=') }}"
                                                                                            target="_blank">
                                                                                            <button type="button"
                                                                                                class="btn btn-outline-info btn-icon btn-sm"
                                                                                                data-bs-toggle="tooltip"
                                                                                                data-bs-placement="top"
                                                                                                title="Detil Ticket">
                                                                                                <i data-feather="link"></i>
                                                                                            </button>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                @php
                                                                                    $non++;
                                                                                @endphp
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->ctgr_exp }}</td>
                                            <td>{{ $reqs_date }}</td>
                                            <td>{{ $item->desc_exp }}</td>
                                            <td>{{ $item->engineer }}</td>
                                            <td>{{ $item->desc_reqs }}</td>
                                            <td>{{ $item->type_trans }}</td>
                                            <td>{{ $item->Kota }}</td>
                                            <td>{{ 'Rp ' . number_format($tln, 0, ',', '.') }}</td>
                                            @foreach ($categories as $id => $description)
                                                @php
                                                    $escapedDescription = str_replace(' ', '_', $description);
                                                @endphp
                                                <td>{{ 'Rp ' . number_format($item->$escapedDescription, 0, ',', '.') }}
                                                </td>
                                            @endforeach
                                            <td>{{ 'Rp ' . number_format($tla, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp ' . number_format($kembali, 0, ',', '.') }}</td>
                                            <td>
                                                {{ $paided = $item->paid_by == 1 ? 'Employee (to reimburse)' : 'Company' }}
                                            </td>
                                            <td>
                                                <h4>
                                                    <span class='badge rounded-pill bg-success'>
                                                        Confirmed
                                                        {{ $tln == $tla ? '(Pas)' : ($tln > $tla ? '(Refund)' : '(Sending)') }}
                                                    </span>
                                                </h4>
                                            </td>
                                            <td>{{ $item->note }}</td>
                                        </tr>
                                        @php
                                            $tN += $tln;
                                            $tA += $tla;
                                            $rqact += $kembali;
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9">Total</td>
                                        <td>{{ 'Rp ' . number_format($tN, 0, ',', '.') }}</td>
                                        <td colspan="{{ $categories->count() }}"></td>
                                        <td>{{ 'Rp ' . number_format($tA, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp ' . number_format($rqact, 0, ',', '.') }}</td>
                                        <td></td>
                                        <td>
                                            <h4>
                                                <span class='badge rounded-pill bg-info'>
                                                    {{ $tN == $tA + $rqact ? 'Balance' : 'Not Match' }}
                                                </span>
                                            </h4>
                                        </td>
                                        <td></td>
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
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
    <script>
        $('.btn-modal-rdrt').each(function(index) {
            $(this).on('click', function() {
                var get_rdrt = $(this).data('rdrt-no');
                var mrdrt = $('#drt' + get_rdrt);

                var mdl_rdrt = new bootstrap.Modal(mrdrt);
                mdl_rdrt.show();
            });
        });
    </script>
@endpush
