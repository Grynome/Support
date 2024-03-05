@push('css-plugin')
@endpush
@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
    $dtrs = 'Null';
    use App\Models\ReqsEnDT;
    use App\Models\RefReqs;
    if ($depart == 6) {
        $tab2 = 'Done';
    } else {
        $tab2 = 'All Expenses';
    }

@endphp
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    My Expenses
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($depart == 6 && $role == 16)
                                            <a href="{{ url("Past/Reqs-Accomodation/$dtrs") }}">
                                                <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Request for Past Tickets"
                                                    class="btn btn-inverse-primary btn-icon-text">
                                                    Add Reimburse
                                                    <i class="btn-icon-append" data-feather="plus"></i>
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </h6>
                            </div>
                            @if ($depart == 15)
                                <form action="{{ route('sorting.request') }}" method="post">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-3 mt-3 me-2 mb-md-0">Data Request</h4>
                                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                                            <div class="input-group wd-200 me-2 mb-md-0">
                                                <select class="js-example-basic-single form-select" data-width="100%"
                                                    name="en_reqs">
                                                    <option value="">- Engineer -</option>
                                                    @foreach ($engineer as $en)
                                                        <option value="{{ $en->en_id }}"
                                                            {{ $en->en_id == $enReqs ? 'selected' : '' }}>
                                                            {{ $en->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <h6 class="me-2 fw-bolder">or</h6>
                                            <div class="input-group wd-200 me-2 mb-md-0">
                                                <select class="js-example-basic-single form-select" data-width="100%"
                                                    name="type_reqs">
                                                    <option value="">- Type Reqs -</option>
                                                    <option value="1" {{ $typeReqs == 1 ? 'selected' : '' }}>
                                                        Reimburse
                                                    </option>
                                                    <option value="2" {{ $typeReqs == 2 ? 'selected' : '' }}>
                                                        Estimasi
                                                    </option>
                                                </select>
                                            </div>
                                            <h4 class="me-2">|</h4>
                                            <button type="submit" class="btn btn-outline-secondary btn-icon-text">
                                                <i class="btn-icon-prepend" data-feather="search"></i>
                                                Sort
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="progress-reqs-tab" data-bs-toggle="tab" href="#progress-reqs"
                                    role="tab" aria-controls="progress-reqs" aria-selected="true">In Progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="done-reqs-tab" data-bs-toggle="tab" href="#done-reqs" role="tab"
                                    aria-controls="done-reqs" aria-selected="false">{{ $tab2 }}</a>
                            </li>
                        </ul>
                        <div class="tab-content border border-top-0 p-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="progress-reqs" role="tabpanel"
                                aria-labelledby="progress-reqs-tab">
                                @if ($depart == 15)
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <form action="{{ route('excel.reimburse') }}" method="post"
                                                id="fm-excel-reimburse">
                                                @csrf
                                                <input type="hidden" value="{{ $enReqs }}" name="en_xcl"
                                                    id="en-xcl">
                                            </form>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="card-title mb-0">
                                                    <span class="input-group-text">
                                                        List Data
                                                    </span>
                                                </h6>
                                                <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Download Excel"
                                                    class="btn btn-inverse-success btn-icon-text btn-excel-reimburse">
                                                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                                    Reimburse
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table id="dataTableExample" class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No</th>
                                                <th>Type Reqs</th>
                                                {{-- @if ($role == 19 && $depart == 15)
                                                    <th>Description</th>
                                                    <th>Expenses</th>
                                                @endif --}}
                                                @if ($depart == 15)
                                                    <th>Engineer</th>
                                                @endif
                                                <th>Type Transport</th>
                                                <th>Total</th>
                                                <th>Confirmed Total</th>
                                                <th>Actual</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                                $totalOuter = 0;
                                                $totalConfirmed = 0;
                                                $totalActual = 0;
                                                if ($depart == 6) {
                                                    $col1 = 3;
                                                } else {
                                                    $col1 = 4;
                                                }
                                            @endphp
                                            @foreach ($data_reqs as $item)
                                                @php
                                                    $dtReqs = ReqsEnDT::where('id_dt_reqs', $item->id_dt_reqs)->get();
                                                    $list_of_ticket = RefReqs::where('id_reqs', $item->id)->get();
                                                    $cek_confirm = ReqsEnDT::where('id_dt_reqs', $item->id_dt_reqs)
                                                        ->groupBy('id_dt_reqs')
                                                        ->havingRaw('SUM(CASE WHEN `status` = 1 THEN 0 ELSE 1 END) = 0')
                                                        ->first();
                                                    $cek_attach = ReqsEnDT::selectRaw('MAX(CASE WHEN path IS NULL or actual = "" THEN 1 ELSE null END) AS qca')
                                                        ->where('id_dt_reqs', $item->id_dt_reqs)
                                                        ->groupBy('id_dt_reqs')
                                                        ->first();
                                                    $status = $item->status;
                                                    $checked = $dtReqs->where('status', 2);
                                                    $rct = $depart == 6 ? 'En' : 'Acc';
                                                    $btnDTReqs = $checked->isNotEmpty() && empty($item->reject) ? 'danger' : 'info';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="btn-toolbar" role="toolbar"
                                                            aria-label="Toolbar with button groups">
                                                            <div class="btn-group me-2" role="group"
                                                                aria-label="First group">
                                                                @if ($status == 2 && $cek_attach->qca == null && ($depart == 15 || ($depart == 6 && $role == 19)))
                                                                    @php
                                                                        $cek_Ssts = $depart == 6 ? [2] : ($role == 19 ? [3] : [0, 4]);
                                                                    @endphp
                                                                    @if (in_array($item->side_sts, $cek_Ssts))
                                                                        <form action="{{ route('done.reqs', $item->id) }}"
                                                                            method="post"
                                                                            id="fm-done-reqs-en-{{ $no }}">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                        </form>
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Update?"
                                                                            class="btn btn-inverse-primary btn-icon btn-sm btn-done-reqs-en"
                                                                            data-finish-id="{{ $no }}"
                                                                            data-val-tln="{{ $item->tln }}"
                                                                            data-val-tla="{{ $item->tla }}"
                                                                            data-val-note="{{ $item->note }}">
                                                                            <i data-feather="check"></i>
                                                                        </button>
                                                                        &nbsp;
                                                                    @endif
                                                                @endif
                                                                {{-- FM Reject --}}
                                                                <form
                                                                    action="{{ route('reject.reqs', ['dsc' => $rct, 'id' => $item->id]) }}"
                                                                    method="post"
                                                                    id="fm-reject-reqs-en-{{ $no }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                </form>
                                                                {{-- END FM --}}
                                                                @if ($role == 19)
                                                                    @if (in_array($status, [0, 1]))
                                                                        @if (empty($item->reject))
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon btn-sm btn-prc-reqs-en"
                                                                                data-proceed-id="{{ $no }}">
                                                                                <i data-feather="edit"></i>
                                                                            </button>
                                                                            <form
                                                                                action="{{ url("Confirm/Reqs-En/$item->id") }}"
                                                                                method="post"
                                                                                id="fm-prc-reqs-en-{{ $no }}">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                            </form>
                                                                            &nbsp;
                                                                            <button type="button"
                                                                                class="btn btn-inverse-danger btn-icon btn-sm btn-rct-reqs-en"
                                                                                data-reject-id="{{ $no }}">
                                                                                <i data-feather="x"></i>
                                                                            </button>
                                                                            &nbsp;
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @if ($depart == 6)
                                                                        @php
                                                                            [$urlDsc, $title] = $checked->isNotEmpty() && empty($item->reject) ? ['Re', 'Re-Create'] : ['Refs', 'Additional Detil'];
                                                                        @endphp
                                                                        @if (($item->type_reqs == 2 && ($status == 0 || $item->reject > 0)) || ($item->type_reqs == 1 && empty($cek_confirm)))
                                                                            <button type="button"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Delete Request"
                                                                                class="btn btn-inverse-danger btn-icon btn-sm btn-dstr-reqs-en"
                                                                                data-form-id="{{ $no }}">
                                                                                <i data-feather="delete"></i>
                                                                            </button>
                                                                            <form
                                                                                action="{{ url("Delete/Reqs-En/$item->id") }}"
                                                                                method="post"
                                                                                id="fm-dstr-reqs-en-{{ $no }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                            </form>
                                                                            &nbsp;
                                                                        @endif
                                                                        @if (
                                                                            ($item->type_reqs == 2 && $status == 0 && $checked->isEmpty() && $item->reject == 0) ||
                                                                                ($item->type_reqs == 1 && empty($cek_confirm)))
                                                                            <a
                                                                                href="{{ url("$urlDsc/Reqs-Accomodation/$item->id_dt_reqs") }}">
                                                                                <button type="button"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="{{ $title }}"
                                                                                    class="btn btn-inverse-info btn-icon btn-sm">
                                                                                    <i data-feather="tag"></i>
                                                                                </button>
                                                                            </a>
                                                                            &nbsp;
                                                                        @endif
                                                                    @else
                                                                        @if (
                                                                            (($item->type_reqs == 2 && $item->status == 1) || ($item->type_reqs == 1 && !empty($cek_confirm))) &&
                                                                                !empty(@$item->get_expenses->status))
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon btn-sm btn-execute-reqs-en"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Disburse Funds"
                                                                                data-execute-id="{{ $no }}">
                                                                                <i data-feather="check"></i>
                                                                            </button>
                                                                            <form
                                                                                action="{{ route('execute.reqs', $item->id) }}"
                                                                                method="post"
                                                                                id="fm-execute-reqs-en-{{ $no }}">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                            </form>
                                                                            &nbsp;
                                                                        @endif
                                                                        @if ($status == 1 && $checked->isNotEmpty() && empty($item->reject))
                                                                            <button type="button"
                                                                                class="btn btn-inverse-warning btn-icon btn-sm btn-reject-reqs-en"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Send Back to Engineer"
                                                                                data-reject-id="{{ $no }}">
                                                                                <i data-feather="chevrons-left"></i>
                                                                            </button>
                                                                            &nbsp;
                                                                        @endif
                                                                        @if (!empty($cek_confirm) && empty($item->id_expenses))
                                                                            <a
                                                                                href="{{ url("Form/Reqs-Expenses/$item->id_dt_reqs") }}">
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon btn-sm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Create Form">
                                                                                    <i data-feather="chevrons-right"></i>
                                                                                </button>
                                                                            </a>
                                                                            &nbsp;
                                                                        @endif
                                                                        <a href="{{ url("Print-Out/$item->id-$item->id_dt_reqs") }}"
                                                                            class="btn btn-outline-secondary btn-icon btn-sm"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Print Invoice"
                                                                            target="_blank">
                                                                            <i data-feather="printer"></i>
                                                                        </a>
                                                                        &nbsp;
                                                                    @endif
                                                                @endif
                                                                @if (!empty($item->tla) && $item->tln < $item->tla && $status == 2 && empty($item->note))
                                                                    <form action="{{ route('add.note.le', $item->id) }}"
                                                                        id="add-less-{{ $no }}" method="post">
                                                                        @csrf
                                                                        {{ method_field('patch') }}
                                                                        <input type="hidden" name="note_less"
                                                                            id="note_less">
                                                                    </form>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary btn-icon btn-sm btn-add-note-le"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Note" data-le-id="{{ $no }}">
                                                                        <i data-feather="plus"></i>
                                                                    </button>
                                                                    &nbsp;
                                                                @endif
                                                                <button type="button"
                                                                    class="btn btn-outline-success btn-icon btn-sm btn-modal-list-ref-ticket"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="List Reference Tickets"
                                                                    data-lrt-no="{{ $no }}">
                                                                    <i data-feather="search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="dt-refs-ticket{{ $no }}"
                                                            tabindex="-1" aria-labelledby="DtReqsModal"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="btn-close"></button>
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
                                                                                    @foreach ($list_of_ticket as $val)
                                                                                        <tr>
                                                                                            <td>{{ $non }}</td>
                                                                                            <td>{{ $val->notiket }}</td>
                                                                                            <td>{{ $val->reqs_at }}</td>
                                                                                            <td>
                                                                                                <a href="{{ url("Detail/Ticket=$val->notiket") }}"
                                                                                                    target="_blank">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-outline-info btn-icon btn-sm"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="Detil Ticket">
                                                                                                        <i
                                                                                                            data-feather="link"></i>
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
                                                    <td>{{ $item->desc_reqs }}</td>
                                                    {{-- @if ($role == 19 && $depart == 15)
                                                        <td>{{ @$item->get_expenses->description }}</td>
                                                        <td>{{ @$item->get_expenses->ctgr_exp->description }}</td>
                                                    @endif --}}
                                                    @if ($depart == 15)
                                                        <td>{{ $item->full_name }}</td>
                                                    @endif
                                                    <td>{{ $item->description }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <button type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Detil Request"
                                                                class="btn btn-inverse-{{ $btnDTReqs }} btn-icon btn-sm open-modal-detil-reqs-en"
                                                                data-mdr-no="{{ $no }}">
                                                                <i data-feather="eye"></i>
                                                            </button>
                                                            <div class="modal fade bd-example-modal-xl"
                                                                id="dt-reqs{{ $no }}" tabindex="-1"
                                                                aria-labelledby="DtReqsModal" aria-hidden="true">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="btn-close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-baseline sv-tc mb-3">
                                                                                    <h6 class="card-title mb-0">
                                                                                        <span class="input-group-text">
                                                                                            Detil Request Engineer
                                                                                        </span>
                                                                                    </h6>
                                                                                    @if ($depart == 15 && empty($item->reject) && empty(@$item->get_expenses))
                                                                                        <button type="button"
                                                                                            class="btn btn-inverse-primary btn-icon-text btn-sm btn-updt-check-DTreqs-en"
                                                                                            data-updt-check-id="{{ $no }}">
                                                                                            Save
                                                                                            <i data-feather="save"></i>
                                                                                        </button>
                                                                                    @elseif($depart == 6 && $role == 16 && ($cek_attach->qca == 1 && $item->type_reqs == 2))
                                                                                        <button type="button"
                                                                                            class="btn btn-inverse-primary btn-icon-text btn-sm btn-updt-attach-DTreqs-en"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-placement="top"
                                                                                            title="Save Attach"
                                                                                            data-updt-attach-id="{{ $no }}">
                                                                                            Save
                                                                                            <i data-feather="save"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            @if ($depart == 15 && empty($item->reject))
                                                                                <form action="{{ url('/Update-Detil') }}"
                                                                                    method="post"
                                                                                    id="fm-updt-check-DTreqs-en-{{ $no }}"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                @elseif ($depart == 6 && $role == 16 && ($cek_attach->qca == 1 && $item->type_reqs == 2))
                                                                                    <form
                                                                                        action="{{ url('/Update-Attach') }}"
                                                                                        method="post"
                                                                                        id="fm-updt-attach-DTreqs-en-{{ $no }}"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        @method('PATCH')
                                                                            @endif
                                                                            <div class="table-responsive">
                                                                                <table id="display" class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>No</th>
                                                                                            <th>Category</th>
                                                                                            <th>Nominal</th>
                                                                                            <th>Additional</th>
                                                                                            <th>Actual Price</th>
                                                                                            <th>Status</th>
                                                                                            @if ($depart == 15)
                                                                                                <th>Check</th>
                                                                                            @elseif($depart == 6)
                                                                                                <th>Created At</th>
                                                                                            @endif
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @php
                                                                                            $noDT = 1;
                                                                                        @endphp
                                                                                        @foreach ($dtReqs as $dtr)
                                                                                            <tr>
                                                                                                <td>{{ $noDT }}
                                                                                                </td>
                                                                                                <td>{{ $dtr->get_ctgr->description }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <br>
                                                                                                    @if ($depart == 15)
                                                                                                        <input
                                                                                                            name="nominal[{{ $dtr->id }}][]"
                                                                                                            id="total-expenses"
                                                                                                            class="form-control form-expenses mb-4 mb-md-0"
                                                                                                            placeholder="Rp0.00"
                                                                                                            data-inputmask="'alias': 'currency', 'prefix':'Rp'"
                                                                                                            value="{{ $dtr->nominal == 0 ? '' : $dtr->nominal }}" />
                                                                                                    @else
                                                                                                        {{ 'Rp ' . number_format($dtr->nominal, 0, ',', '.') }}
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td>
                                                                                                    @if (empty($dtr->path))
                                                                                                        @if ($depart == 6 && $role == 16)
                                                                                                            <div
                                                                                                                class="d-flex justify-content-between align-items-baseline att-rmv">
                                                                                                                <input
                                                                                                                    type="file"
                                                                                                                    class="file"
                                                                                                                    id="attach-reqs-{{ $no }}"
                                                                                                                    name="attachDT_file[{{ $dtr->id }}][]"
                                                                                                                    accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                                                                                            </div>
                                                                                                        @else
                                                                                                            No Attachments
                                                                                                        @endif
                                                                                                    @else
                                                                                                        <a href="#img{{ $no . $noDT }}"
                                                                                                            aria-label="Click to enlarge image">
                                                                                                            <img src="{{ url("$dtr->path") }}"
                                                                                                                class="img-fluid img-thumbnail table-image"
                                                                                                                alt="Proof of Payment">
                                                                                                        </a>
                                                                                                        <div class="lightbox"
                                                                                                            id="img{{ $no . $noDT }}">
                                                                                                            <a href="#"
                                                                                                                class="close-full-img"
                                                                                                                aria-label="close image">&times;</a>
                                                                                                            <img src="{{ url("$dtr->path") }}"
                                                                                                                alt="Proof of Payment"
                                                                                                                loading="lazy">
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    @if ($item->type_reqs == 2 && $depart == 6 && $role == 16 && $cek_attach->qca == 1)
                                                                                                        <hr>
                                                                                                        <label
                                                                                                            for="actual"
                                                                                                            class="col-form-label">Actual
                                                                                                            Price</label>
                                                                                                        <input
                                                                                                            name="actual[{{ $dtr->id }}][]"
                                                                                                            id="actual-{{ $no }}"
                                                                                                            class="form-control mb-4 mb-md-0"
                                                                                                            placeholder="Rp0.00"
                                                                                                            data-inputmask="'alias': 'currency', 'prefix':'Rp'" />
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td>{{ 'Rp ' . number_format($dtr->actual, 0, ',', '.') }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    @php
                                                                                                        [$sts, $spn] = empty($dtr->status) ? ['Not Checked Yet', 'info'] : ($dtr->status == 1 ? ['Confirmed', 'success'] : ['Rejected', 'danger']);
                                                                                                    @endphp
                                                                                                    <h4><span
                                                                                                            class="badge bg-{{ $spn }}">{{ $sts }}</span>
                                                                                                    </h4>
                                                                                                </td>
                                                                                                @if ($depart == 15)
                                                                                                    <td>
                                                                                                        @php
                                                                                                            $dsb = !empty($item->reject) || !empty(@$item->get_expenses) ? 'disabled' : '';
                                                                                                        @endphp
                                                                                                        <fieldset
                                                                                                            id="check-choose{{ $noDT }}"
                                                                                                            {{ $dsb }}>
                                                                                                            <div
                                                                                                                class="d-flex justify-content-between align-items-center">
                                                                                                                <div
                                                                                                                    class="form-check">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        class="form-check-input"
                                                                                                                        value="1"
                                                                                                                        name="confirmed[{{ $dtr->id }}][]"
                                                                                                                        id="check1{{ $noDT }}"
                                                                                                                        {{ $dtr->status == 1 ? 'checked' : '' }}>
                                                                                                                    <label
                                                                                                                        class="form-check-label"
                                                                                                                        for="check1{{ $noDT }}">
                                                                                                                        Accept
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    ||
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="form-check">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        class="form-check-input"
                                                                                                                        value="2"
                                                                                                                        name="confirmed[{{ $dtr->id }}][]"
                                                                                                                        id="check2{{ $noDT }}"
                                                                                                                        {{ $dtr->status == 2 ? 'checked' : '' }}>
                                                                                                                    <label
                                                                                                                        class="form-check-label"
                                                                                                                        for="check2{{ $noDT }}">
                                                                                                                        Reject
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </fieldset>
                                                                                                    </td>
                                                                                                @elseif($depart == 6)
                                                                                                    <td>
                                                                                                        {{ $dtr->created_at }}
                                                                                                    </td>
                                                                                                @endif
                                                                                            </tr>
                                                                                            @php
                                                                                                $noDT++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                        <td colspan="2">Total </td>
                                                                                        <td>{{ 'Rp ' . number_format($item->tln, 0, ',', '.') }}
                                                                                        </td>
                                                                                        <td></td>
                                                                                        <td>{{ 'Rp ' . number_format($item->tla, 0, ',', '.') }}
                                                                                        </td>
                                                                                        <td>=</td>
                                                                                        <td>
                                                                                            {{ $item->tln == $item->tla
                                                                                                ? 'Pas'
                                                                                                : ($item->tln >= $item->tla
                                                                                                    ? 'Kembalian (Rp ' . number_format($item->tln - $item->tla, 0, ',', '.') . ')'
                                                                                                    : 'Kurang (Rp ' . number_format($item->tla - $item->tln, 0, ',', '.') . ')') }}
                                                                                        </td>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                                                                            @if (
                                                                                ($depart == 15 && empty($item->reject)) ||
                                                                                    ($depart == 6 && $role == 16 && ($cek_attach->qca == 1 && $item->type_reqs == 2)))
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                {{ 'Rp ' . number_format($item->tln, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if (empty(@$item->get_expenses->total))
                                                            {{ 'Rp ' . number_format(0, 0, ',', '.') }}
                                                        @else
                                                            {{ 'Rp ' . number_format(@$item->get_expenses->total, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (empty($item->tla))
                                                            {{ 'Rp ' . number_format(0, 0, ',', '.') }}
                                                        @else
                                                            {{ 'Rp ' . number_format($item->tla, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->updated_at }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            [$desc, $span] =
                                                                $item->type_reqs == 2
                                                                    ? ($status == 0
                                                                        ? (empty($item->reject)
                                                                            ? ($role == 19
                                                                                ? ['Need to Proceed', 'primary']
                                                                                : ['Waiting Confirm Your Leader', 'info'])
                                                                            : ($role == 19
                                                                                ? ['Waiting for delete by Engineer', 'warning']
                                                                                : ['Rejected by Your Leader', 'danger']))
                                                                        : ($status == 1
                                                                            ? ($depart == 6
                                                                                ? ($checked->isEmpty()
                                                                                    ? (@$item->get_expenses->status == 1
                                                                                        ? ['Waiting for Disburse Funds', 'info']
                                                                                        : ['In Checks By Accounting', 'info'])
                                                                                    : (empty($item->reject)
                                                                                        ? ['wait for sent back!', 'warning']
                                                                                        : ['Rejected by Accounting', 'danger']))
                                                                                : (!empty($cek_confirm)
                                                                                    ? (empty(@$item->get_expenses->status)
                                                                                        ? ['Need to Create Form Request', 'primary']
                                                                                        : (@$item->get_expenses->status == 1
                                                                                            ? ['Please to Execute', 'info']
                                                                                            : ['Rejected, Please return it to En', 'info']))
                                                                                    : ($checked->isNotEmpty()
                                                                                        ? (empty($item->reject)
                                                                                            ? ['Some Reqs had been Rejected, Return it!', 'warning']
                                                                                            : ['Waiting : Sent it back', 'info'])
                                                                                        : ['Pls, to check!', 'primary'])))
                                                                            : ($status == 2
                                                                                ? ($cek_attach->qca == 1
                                                                                    ? ($depart == 6
                                                                                        ? ['Complete the data', 'warning']
                                                                                        : ['Data is uncomplete', 'warning'])
                                                                                    : ($depart == 6
                                                                                        ? ['It will updating to finish', 'info']
                                                                                        : ($item->tln == $item->tla
                                                                                            ? ['Set it Finish', 'info']
                                                                                            : ($item->tln >= $item->tla
                                                                                                ? ['Kembalian (Rp ' . number_format($item->tln - $item->tla, 0, ',', '.') . ')', 'info']
                                                                                                : ['Kurang (Rp ' . number_format($item->tla - $item->tln, 0, ',', '.') . ')', 'warning']))))
                                                                                : ['Done', 'success'])))
                                                                    : ($depart == 6
                                                                        ? ($checked->isEmpty()
                                                                            ? (@$item->get_expenses->status == 1
                                                                                ? ['Waiting for Disburse Funds', 'info']
                                                                                : ['In Checks By Accounting', 'info'])
                                                                            : ['Request Rejected!', 'warning'])
                                                                        : (!empty($cek_confirm)
                                                                            ? (empty(@$item->get_expenses->status)
                                                                                ? ['Need to Create Form Request', 'primary']
                                                                                : ['Please to Execute', 'info'])
                                                                            : ($checked->isNotEmpty() && empty($item->reject)
                                                                                ? ['Would be Delete or Re-Create!', 'warning']
                                                                                : ['Pls, to check!', 'primary'])));
                                                        @endphp
                                                        <h4><span
                                                                class="badge bg-{{ $span }} rounded-pill">{{ $desc }}</span>
                                                        </h4>
                                                        @if ($item->tln < $item->tla)
                                                            Note:&nbsp;{{ $item->note }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                    $totalOuter += $item->tln;
                                                    $totalConfirmed += @$item->get_expenses->total;
                                                    $totalActual += $item->tla;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <td>Total</td>
                                            <td colspan="{{ $col1 }}"></td>
                                            <td>{{ 'Rp ' . number_format($totalOuter, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp ' . number_format($totalConfirmed, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp ' . number_format($totalActual, 0, ',', '.') }}</td>
                                            <td colspan="2"></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="done-reqs" role="tabpanel" aria-labelledby="done-reqs-tab">
                                <div class="table-responsive">
                                    <table class="table tbl-done-reqs">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                @if ($depart == 15)
                                                    <th>Reqs By</th>
                                                @endif
                                                <th>Type Reqs</th>
                                                <th>Type Transport</th>
                                                <th>Status</th>
                                                <th>Finish At</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
@endpush
@push('custom')
    @if (session('new_reqs'))
        <script>
            const waNQ = "{{ session('new_reqs') }}";

            window.open(waNQ, '_blank');
        </script>
    @elseif (session('confirm1') && session('confirm2'))
        @if ($depart == 6 && $role == 19)
        <script>
            const c1 = "{{ session('confirm1') }}";

            window.open(c1, '_blank');
            const c2 = "{{ session('confirm2') }}";

            window.open(c2, '_blank');
        </script>
        @endif
    @endif
    <script>
        // Confirm Remove Request
        $('.btn-dstr-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var formId = $(this).data('form-id');
                var form = $('#fm-dstr-reqs-en-' + formId);

                Swal.fire({
                    title: "Confirm to Remove?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return false;
            });
        });
        // Execute Request
        $('.btn-execute-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var formId = $(this).data('execute-id');
                var form = $('#fm-execute-reqs-en-' + formId);

                Swal.fire({
                    title: "Continues for disburse funds?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return false;
            });
        });
        // Finish Request
        $('.btn-done-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var ffm = $(this).data('finish-id');
                var get_ffm = $('#fm-done-reqs-en-' + ffm);

                var tln = $(this).data('val-tln');
                var tla = $(this).data('val-tla');
                var note = $(this).data('val-note');


                var [title, text] = tln == tla ? ["Done it?", ""] :
                    (tln >= tla ? ["Have u Received the Money?", ''] : ["Have u Transfer the Money?",
                        "Note: " + note
                    ]);

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        get_ffm.submit();
                    }
                });
                return false;
            });
        });
        // Confirm Remove Request
        $('.btn-reject-reqs-en, .btn-rct-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var formId = $(this).data('reject-id');
                var form = $('#fm-reject-reqs-en-' + formId);

                Swal.fire({
                    title: "Return it to the Engineer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return false;
            });
        });
        // confirm Delete detil
        $('.btn-dlt-detil-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var fmDltDetilId = $(this).data('detil-id');
                var fmDltDetil = $('#fm-dlt-detil-reqs-en-' + fmDltDetilId);

                Swal.fire({
                    title: "Delete this Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fmDltDetil.submit();
                    }
                });
                return false;
            });
        });
        // Confirm Lead En
        $('.btn-prc-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var fmPrcId = $(this).data('proceed-id');
                var fmPrc = $('#fm-prc-reqs-en-' + fmPrcId);

                Swal.fire({
                    title: "Confirm this request?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fmPrc.submit();
                    }
                });
                return false;
            });
        });
        // Check Detil Reqs en
        $('.btn-updt-check-DTreqs-en').each(function(index) {
            $(this).on('click', function() {
                var ucDTId = $(this).data('updt-check-id');
                var ucDT = $('#fm-updt-check-DTreqs-en-' + ucDTId);

                Swal.fire({
                    title: "Continue to Update?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        ucDT.submit();
                    }
                });
                return false;
            });
        });
        // Update Attach Detil Reqs en
        $('.btn-updt-attach-DTreqs-en').each(function(index) {
            $(this).on('click', function() {
                var attchID = $(this).data('updt-attach-id');
                var tchID = $('#fm-updt-attach-DTreqs-en-' + attchID);

                Swal.fire({
                    title: "Continue to Update?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        tchID.submit();
                    }
                });
                return false;
            });
        });
        // Open Modal Detil Reqs En
        $('.open-modal-detil-reqs-en').each(function(index) {
            $(this).on('click', function() {
                var get_mdr = $(this).data('mdr-no');
                var mdr = $('#dt-reqs' + get_mdr);

                var modal = new bootstrap.Modal(mdr);
                modal.show();
            });
        });
        // Open Modal List Reference Tickets
        $('.btn-modal-list-ref-ticket').each(function(index) {
            $(this).on('click', function() {
                var get_lrt = $(this).data('lrt-no');
                var mdr = $('#dt-refs-ticket' + get_lrt);

                var mdl_lrt = new bootstrap.Modal(mdr);
                mdl_lrt.show();
            });
        });

        // btn add note when estimation is less then actual
        function showAddNoteSwal(fmNT) {
            Swal.fire({
                title: 'Add Note!',
                text: 'Whats your reason if this estimation is less than the actual?',
                icon: 'info',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                    type: 'hidden',
                    name: "note_less"
                },
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Save',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                inputPlaceholder: "Input Your Reason",
            }).then((result) => {
                if (result.value) {
                    jQuery('#note_less').val(result.value);
                    fmNT.submit();
                } else if (result.dismiss) {
                    Swal.close();
                } else {
                    Swal.fire({
                        title: "Your Note its empty!!",
                        text: "Type your Reason!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        showAddNoteSwal(fmNT);
                    });
                }
            });
        }

        $('.btn-add-note-le').each(function(index) {
            $(this).on('click', function() {
                var lessID = $(this).data('le-id');
                var fmNT = $('#add-less-' + lessID);
                showAddNoteSwal(fmNT);
            });
        });
        // Get Excel Reimburse
        $('.btn-excel-reimburse').on('click', function() {
            let engineer = document.getElementById("en-xcl").value;

            if (engineer == "") {
                Swal.fire({
                    title: 'Choose Engineer First!',
                    icon: 'warning',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
                return false;
            } else {
                jQuery('#fm-excel-reimburse').submit();
            }
        });
    </script>
    {{-- get table reqs Done --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('fetch.reqs.done') }}',
                type: 'GET',
                success: function(data) {
                    handleSuccess(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            function handleSuccess(data) {
                console.log(data);
                populateTable('.tbl-done-reqs', data.query_done_reqs, ['id_dt_reqs', 'full_name', 'desc_reqs',
                    'description',
                    'done_sts', 'updated_at'
                ], {{ $depart }});
                initializeDataTable('.tbl-done-reqs');
                initializeTooltips();
            }

            function populateTable(tableClass, items, columns, dept) {
                var table = $(tableClass + ' tbody');
                table.empty();

                if (items && items.length > 0) {
                    items.forEach(function(item, index) {
                        var rowHtml = '<tr>';
                        rowHtml += '<td>' + (index + 1) + '</td>';
                        if (dept === 15) {
                            rowHtml += '<td>' + item['full_name'] + '</td>';
                        }
                        rowHtml += '<td>' + item['desc_reqs'] + '</td>';
                        rowHtml += '<td>' + item['description'] + '</td>';

                        rowHtml += '<td>' +
                            "<h4><span class='badge rounded-pill bg-success'>" + item['done_sts'] +
                            '</span></h4>' + '</td>';

                        var isoDate = item['updated_at'];
                        var date = new Date(isoDate);
                        var formattedDate = date.toISOString().slice(0, 19).replace('T',
                            ' ');
                        rowHtml += '<td>' + formattedDate + '</td>';

                        // columns.forEach(function(column) {
                        //     if (column !== 'id_dt_reqs') { // Exclude 'id_dt_reqs'
                        //         if (column === 'updated_at') {
                        //             var isoDate = item[column];
                        //             var date = new Date(isoDate);
                        //             var formattedDate = date.toISOString().slice(0, 19).replace('T',
                        //                 ' ');
                        //             rowHtml += '<td>' + formattedDate + '</td>';
                        //         } else if (column === 'done_sts') {
                        //             rowHtml += '<td>' +
                        //                 "<h4><span class='badge rounded-pill bg-success'>" + item[
                        //                     column] + '</span></h4>' + '</td>';
                        //         } else {
                        //             rowHtml += '<td>' + item[column] + '</td>';
                        //         }
                        //     }
                        // });

                        var printUrl = '{{ url('Print-Out') }}/' + item['id_dt_reqs'];
                        rowHtml += '<td><a href="' + printUrl +
                            '" class="btn btn-inverse-primary btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Invoice" target="_blank">';
                        rowHtml += '<i data-feather="printer"></i>';
                        rowHtml += '</a></td>';

                        rowHtml += '</tr>';
                        table.append(rowHtml);
                    });
                }
                feather.replace();
            }

            function initializeDataTable(tableClass) {
                $(tableClass).DataTable({
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ]
                });
            }

            function initializeTooltips() {
                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    </script>
@endpush
