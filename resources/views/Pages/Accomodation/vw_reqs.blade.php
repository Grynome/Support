@push('css-plugin')
@endpush
@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
    list($urlDsc, $title) = empty($item->reject) ? ["Refs" ,"Additional Detil"] : ["Re", "Re-Create"];
    $dtrs = "Null";
@endphp
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Expenses</li>
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
                                        {{ $title = $depart == 6 ? 'My Expenses' : 'Request Engineer' }}
                                        <a href="{{ url("Past/Reqs-Accomodation/$dtrs") }}">
                                            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This Request is just for the ticket is already Closed" class="btn btn-inverse-primary btn-icon-text">
                                                Add Reimburse
                                                <i class="btn-icon-append" data-feather="plus"></i>
                                            </button>
                                        </a>
                                    </div>
                                </h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        @if ($role == 19 && $depart == 15)
                                            <th>Description</th>
                                            <th>Expenses</th>
                                        @endif
                                        @if ($depart == 15)
                                            <th>Engineer</th>
                                        @endif
                                        <th>Type Transport</th>
                                        <th>Total</th>
                                        <th>Confirmed Total</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use App\Models\ReqsEnDT;
                                        $no = 1;
                                        $totalOuter = 0;
                                        $totalConfirmed = 0;
                                        if ($depart == 6) {
                                            $col1 = 3;
                                            $col2 = 2;
                                        } else {
                                            if ($role == 19) {
                                                $col1 = 5;
                                                $col2 = 3;
                                            } else {
                                                $col1 = 4;
                                                $col2 = 2;
                                            }
                                        }
                                        
                                    @endphp
                                    @foreach ($data_reqs as $item)
                                        @php
                                            $dtReqs = ReqsEnDT::where('id_dt_reqs', $item->id_dt_reqs)->get();
                                            $cek_confirm = ReqsEnDT::select('id_dt_reqs')
                                                            ->where('id_dt_reqs', $item->id_dt_reqs)
                                                            ->groupBy('id_dt_reqs')
                                                            ->havingRaw('SUM(CASE WHEN `status` = 1 THEN 0 ELSE 1 END) = 0')
                                                            ->first();
                                            $cek_attach = ReqsEnDT::select('id_dt_reqs')
                                                            ->where('id_dt_reqs', $item->id_dt_reqs)
                                                            ->groupBy('id_dt_reqs')
                                                            ->havingRaw('SUM(CASE WHEN `path`IS NOT NULL then 0 ELSE 1 END) = 1')
                                                            ->first();
                                            $totalNominal = 0;
                                            $status = $item->status;
                                            $checked = $dtReqs->where('status', 2);
                                            $Acc = "Acc";
                                            $En = "En";
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        @if ($role == 19)
                                                            <button type="button"
                                                                class="btn btn-inverse-primary btn-icon btn-sm btn-prc-reqs-en"
                                                                data-proceed-id="{{ $no }}">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                            <form action="{{ url("Confirm/Reqs-En/$item->id") }}"
                                                                method="post" id="fm-prc-reqs-en-{{ $no }}">
                                                                @csrf
                                                                @method('PATCH')
                                                            </form>
                                                            &nbsp;
                                                        @else
                                                            @if ($depart == 6)
                                                                @if ($status == 0 || !empty($item->reject))
                                                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Delete Request" class="btn btn-inverse-danger btn-icon btn-sm btn-dstr-reqs-en"
                                                                        data-form-id="{{ $no }}">
                                                                        <i data-feather="delete"></i>
                                                                    </button>
                                                                    <form action="{{ url("Delete/Reqs-En/$item->id") }}"
                                                                        method="post"
                                                                        id="fm-dstr-reqs-en-{{ $no }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                    &nbsp;
                                                                    <a
                                                                        href="{{ url("$urlDsc/Reqs-Accomodation/$item->id_dt_reqs") }}">
                                                                        <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="{{$title}}" class="btn btn-inverse-info btn-icon btn-sm">
                                                                            <i data-feather="tag"></i>
                                                                        </button>
                                                                    </a>
                                                                    &nbsp;
                                                                @endif
                                                            @else
                                                                @if (!empty(@$item->get_expenses->status) && $item->status == 1)
                                                                    <button type="button"
                                                                        class="btn btn-inverse-primary btn-icon btn-sm btn-execute-reqs-en"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Disburse Funds" data-execute-id="{{ $no }}">
                                                                        <i data-feather="check"></i>
                                                                    </button>
                                                                    <form action="{{ route('execute.reqs', $item->id) }}"
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
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Send Back to Engineer" data-reject-id="{{ $no }}">
                                                                        <i data-feather="chevrons-left"></i>
                                                                    </button>
                                                                    <form action="{{ route('reject.reqs', ['dsc' => $Acc, 'id' => $item->id]) }}"
                                                                        method="post"
                                                                        id="fm-reject-reqs-en-{{ $no }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                    </form>
                                                                    &nbsp;
                                                                @endif
                                                                @if (!empty($cek_confirm) && empty($item->id_expenses))
                                                                    <a
                                                                        href="{{ url("Form/Reqs-Expenses/$item->id_dt_reqs") }}">
                                                                        <button type="button"
                                                                            class="btn btn-inverse-primary btn-icon btn-sm"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="Create Form">
                                                                            <i data-feather="chevrons-right"></i>
                                                                        </button>
                                                                    </a>
                                                                    &nbsp;
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <a href="{{ url("Detail/Ticket=$item->notiket") }}"
                                                            target="_blank">
                                                            <button type="button"
                                                                class="btn btn-outline-success btn-icon btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Detil Ticket">
                                                                <i data-feather="search"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->notike }}</td>
                                            @if ($role == 19 && $depart == 15)
                                                <td>{{@$item->get_expenses->description}}</td>
                                                <td>{{@$item->get_expenses->ctgr_exp->description}}</td>
                                            @endif
                                            @if ($depart == 15)
                                                <td>{{ $item->get_user->full_name }}</td>
                                            @endif
                                            <td>{{ $item->type_trans->description }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detil Request"
                                                        class="btn btn-inverse-info btn-icon btn-sm open-modal-detil-reqs-en"
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
                                                                            @elseif ($depart == 6 && $role == 16 && !empty($cek_attach))
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-sm btn-updt-attach-DTreqs-en"
                                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                                    title="Save Attach" data-updt-attach-id="{{ $no }}">
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
                                                                    @elseif ($depart == 6 && $role == 16 && !empty($cek_attach))
                                                                        <form action="{{ url('/Update-Attach') }}"
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
                                                                                        <th>Attach</th>
                                                                                        <th>Status</th>
                                                                                        @if ($depart == 15)
                                                                                            <th>Check</th>
                                                                                        @elseif ($depart == 6)
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
                                                                                            <td>{{ 'Rp ' . number_format($dtr->nominal, 0, ',', '.') }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if (empty($dtr->path))
                                                                                                    @if ($depart == 6 && $role == 16 )
                                                                                                        <div class="d-flex justify-content-between align-items-baseline att-rmv">
                                                                                                            <input type="file" class="file" id="attach-reqs" name="attachDT_file[{{ $dtr->id }}][]"
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
                                                                                            </td>
                                                                                            <td>
                                                                                                @php 
                                                                                                    list($sts, $spn) = empty($dtr->status) 
                                                                                                        ? ['Not Checked Yet', 'info'] 
                                                                                                        : ($dtr->status == 1 
                                                                                                            ? ['Confirmed', 'success'] 
                                                                                                            : ['Rejected', 'danger'])
                                                                                                @endphp
                                                                                                <h4><span class="badge bg-{{$spn}}">{{$sts}}</span></h4>
                                                                                            </td>
                                                                                            @if ($depart == 15)
                                                                                                <td>
                                                                                                    @php
                                                                                                        $dsb = !empty($item->reject) || !empty(@$item->get_expenses) ? "disabled" : "";
                                                                                                    @endphp
                                                                                                    <fieldset
                                                                                                        id="check-choose{{ $noDT }}" {{$dsb}}>
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
                                                                                                    {{$dtr->created_at}}
                                                                                                </td>
                                                                                            @endif
                                                                                        </tr>
                                                                                        @php
                                                                                            $noDT++;
                                                                                            $totalNominal += $dtr->nominal;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <td colspan="2">Total </td>
                                                                                    <td>{{ 'Rp ' . number_format($totalNominal, 0, ',', '.') }}
                                                                                    </td>
                                                                                    <td colspan="3"></td>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                    @if (($depart == 15 && empty($item->reject)) || $depart == 6 && $role == 16 && !empty($cek_attach))
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        {{ 'Rp ' . number_format($totalNominal, 0, ',', '.') }}
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
                                                {{ $item->created_at }}
                                            </td>
                                            <td>
                                                @php 
                                                    list($desc, $span) =
                                                        $status == 0 && $role == 19
                                                            ? ['Need to Proceed', 'primary']
                                                            : ($status == 0
                                                                ? ['Waiting Confirm Your Leader', 'info']
                                                                : ($depart == 6
                                                                    ? (!empty($item->id_expenses) && empty(@$item->get_expenses->status)
                                                                        ? ['Waiting Confirm from Leader Accounting', 'info']
                                                                        : ($checked->isNotEmpty()
                                                                            ? (empty($item->reject) 
                                                                                ? ['Waiting to be Returned by Accounting', 'warning']
                                                                                : ($item->reject == 1
                                                                                    ? ['Rejected by Accounting', 'danger']
                                                                                    : ['Rejected by Your Leader', 'danger']))
                                                                            : ['In Checks By Accounting', 'info']))
                                                                    : (!empty($item->id_expenses) && empty(@$item->get_expenses->status)
                                                                        ? ($role == 16 
                                                                            ? ['Waiting Confirm from Your Leader', 'info'] 
                                                                            : ["Need to Confirm", 'primary'])
                                                                        : (!empty($cek_confirm)
                                                                            ? (empty(@$item->get_expenses->status) 
                                                                                ? ['Need to Create Form Request', 'primary']
                                                                                : (@$item->get_expenses->status == 1 
                                                                                    ? ['Confirmed, Please to Execute', 'info']
                                                                                    : ['Rejected, Please return it to En', 'info']))
                                                                            : ($checked->isNotEmpty()
                                                                                ? (empty($item->reject) 
                                                                                    ? ['Return it to Engineer to re-create Request', 'warning']
                                                                                    : ['The request will be resent or deleted', 'info'])
                                                                                : ['Must be Checked', 'primary']))))) 
                                                @endphp
                                                <h4><span class="badge bg-{{$span}} rounded-pill">{{$desc}}</span></h4>
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                            $totalOuter += $totalNominal;
                                            $totalConfirmed += @$item->get_expenses->total;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td>Total</td>
                                    <td colspan="{{$col1}}"></td>
                                    <td>{{ 'Rp ' . number_format($totalOuter, 0, ',', '.') }}</td>
                                    <td>{{ 'Rp ' . number_format($totalConfirmed, 0, ',', '.') }}</td>
                                    <td colspan="{{$col2}}"></td>
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
        // Confirm Remove Request
        $('.btn-reject-reqs-en').each(function(index) {
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
    </script>
@endpush
