@push('css-plugin')
@endpush
@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
    $nik = auth()->user()->nik;
    if ($detail->first()->status == 10) {
        $disabled = 'disabled';
        $readonly = 'readonly';
    } else {
        if ($depart == 4) {
            $disabled = '';
            $readonly = '';
        } else {
            $disabled = 'disabled';
            $readonly = 'readonly';
        }
    }
@endphp
@if (session()->has('whatsapp_link'))
    <script>
        var whatsappLink = "{{ session('whatsapp_link') }}";
        window.open(whatsappLink, '_blank');
    </script>
@endif
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Manage Ticket</li>
                <li class="breadcrumb-item active" aria-current="page">Detil</li>
            </ol>
        </nav>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row position-relative">
                            <div class="col-lg-12 chat-aside">
                                <div class="aside-content">
                                    <div class="aside-header">
                                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6>{{ $id }}</h6>
                                                    <p class="text-muted tx-13">Detail Tiket</p>
                                                </div>
                                            </div>
                                            @if ($depart == 10)
                                                <div class="dropdown">
                                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xl text-muted pb-3px" data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="#list-attach" data-bs-toggle="modal"><i
                                                                data-feather="folder" class="icon-sm me-2"></i>
                                                            <span class="">Engineer Attach</span>
                                                        </a>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            href="#adm-upload-file" data-bs-toggle="modal"><i
                                                                data-feather="upload-cloud" class="icon-sm me-2"></i>
                                                            <span class="">Upload Attach</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- MODAL Upload Admin --}}
                                                <div class="modal fade" id="adm-upload-file" tabindex="-1"
                                                    aria-labelledby="attachModal" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Upload Bundle
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("Add-Attachment/ADM/$id") }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row mb-1">
                                                                        <div class="col-md-6">
                                                                            <p class="form-label fw-bolder">
                                                                                Type Attach :
                                                                            </p>
                                                                            <select
                                                                                class="js-example-basic-single form-select"
                                                                                data-width="100%" name="type_attach_adm"
                                                                                required>
                                                                                <option value="">
                                                                                    -
                                                                                    Choose
                                                                                    -
                                                                                </option>
                                                                                <option value="1">
                                                                                    Work Order
                                                                                </option>
                                                                                <option value="2">
                                                                                    Other Document
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div id="adm-upload-att" class="mb-1">
                                                                        <input type="file" class="file"
                                                                            name="filesAdm[]"
                                                                            accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"
                                                                            id="file-input" required />
                                                                    </div>
                                                                    <div class="btn-group me-2" role="group"
                                                                        aria-label="First group">
                                                                        <button id="addt-upload-att"
                                                                            class="btn btn-inverse-info btn-md"
                                                                            type="button">
                                                                            <i class="btn-icon-append icon-md"
                                                                                data-feather="plus"></i>
                                                                        </button>
                                                                        &nbsp;
                                                                        <button class="btn btn-inverse-info" type="submit">
                                                                            <i class="btn-icon-append icon-md"
                                                                                data-feather="save"></i> Save
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-bs-toggle="modal"
                                                                    class="btn btn-inverse-primary btn-sm" type="button"
                                                                    data-bs-target="#list-bundled-adm">
                                                                    <i class="btn-icon-append icon-sm"
                                                                        data-feather="eye"></i> view Bundle
                                                                </button>
                                                                <button type="button" class="btn btn-inverse-secondary"
                                                                    data-bs-dismiss="modal">Cancle</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- MODAL view adm Attachment --}}
                                                <div class="modal fade bd-example-modal-lg" id="list-bundled-adm"
                                                    tabindex="-1" aria-labelledby="attachModal" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Had been Uploaded
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table id="display" class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>
                                                                                    No</th>
                                                                                <th>
                                                                                    File Name</th>
                                                                                <th>
                                                                                    Type Attach</th>
                                                                                <th>Option</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $nono = 1;
                                                                            @endphp
                                                                            @foreach ($attach_uploaded as $item)
                                                                                <tr>
                                                                                    <td>{{ $nono }}</td>
                                                                                    <td>{{ $item->filename }}</td>
                                                                                    <td>{{ $item->type_attach == 1 ? 'Work Order' : 'Other Documents' }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <form method="POST"
                                                                                            action="{{ url("uploaded-download/ADM/$item->id") }}"
                                                                                            style="display: none;"
                                                                                            id="fm-dld-adm{{ $nono }}">
                                                                                            @csrf
                                                                                        </form>
                                                                                        <button type="button"
                                                                                            class="btn btn-inverse-primary btn-icon btn-sm dld-upd-adm{{ $nono }}">
                                                                                            <i data-feather="download"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                                @php
                                                                                    $nono++;
                                                                                @endphp
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-inverse-secondary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#adm-upload-file">Cancle</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="dropdown">
                                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xl text-muted pb-3px" data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                            @if ($detail->first()->status < 10)
                                                                <a class="dropdown-item d-flex align-items-center change-part-reqs"
                                                                    href="javascript:;"><i data-feather="edit"
                                                                        class="icon-sm me-2"></i>
                                                                    <span class="">Change Part Request</span>
                                                                    <form action="{{ url("Update/$id/Part-Reqs") }}"
                                                                        method="post" id="form-change-part-reqs">
                                                                        @csrf
                                                                        {{ method_field('patch') }}
                                                                        @if ($detail->first()->part_request == 'Yes')
                                                                            <input type="hidden" value="0"
                                                                                name="sts_part_reqs">
                                                                        @else
                                                                            <input type="hidden" value="1"
                                                                                name="sts_part_reqs">
                                                                        @endif
                                                                        <input type="hidden" id="status-part-reqs"
                                                                            data-statusrqs="{{ $detail->first()->part_request }}">
                                                                    </form>
                                                                </a>
                                                                @if ($detail->first()->status == 0)
                                                                    @if (!empty($detail->first()->full_name))
                                                                        <a class="dropdown-item d-flex align-items-center send-to-engineer"
                                                                            href="javascript:;"><i data-feather="send"
                                                                                class="icon-sm me-2"></i>
                                                                            <span class="">Send to Engineer</span>
                                                                            <form
                                                                                action="{{ url("Update/$id/Send-to/Engineer") }}"
                                                                                method="post"
                                                                                id="form-send-ticket-to-engineer">
                                                                                @csrf
                                                                                {{ method_field('patch') }}
                                                                            </form>
                                                                        </a>
                                                                    @endif
                                                                @elseif ($detail->first()->status == 9)
                                                                    @php
                                                                        $url = url("Detail/Ticket=$id");
                                                                        $message = urlencode("You have a new Ticket with No Ticket.$id\nClick link to open the page : ($url)");
                                                                        $get_number = $detail->first()->phone_en;
                                                                        $phone = substr("$get_number", 1);
                                                                    @endphp
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="https://wa.me/+62{{ $phone }}?text={{ $message }}"
                                                                        target="_blank"><i data-feather="link-2"
                                                                            class="icon-sm me-2"></i>
                                                                        <span class="">Send Reminder link</span>
                                                                    </a>
                                                                @endif
                                                                <a class="dropdown-item d-flex align-items-center change-engineer"
                                                                    href="#engineer-change" data-bs-toggle="modal"><i
                                                                        data-feather="user-check"
                                                                        class="icon-sm me-2"></i>
                                                                    <span class="">Change Engineer</span></a>
                                                                <a class="dropdown-item d-flex align-items-center change-engineer"
                                                                    href="#l2-engineer-change" data-bs-toggle="modal"><i
                                                                        data-feather="user-check"
                                                                        class="icon-sm me-2"></i>
                                                                    <span class="">Change L2</span></a>
                                                                @if ($detail->first()->status != 0 && $detail->first()->status != 9)
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity"
                                                                            class="icon-sm me-2"></i>
                                                                        <span class="">Activity Engineer</span></a>
                                                                @endif
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="#list-attach" data-bs-toggle="modal"><i
                                                                        data-feather="file" class="icon-sm me-2"></i>
                                                                    <span class="">Attachment</span></a>
                                                                @if (!empty($validate_problem))
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#updt-unit-tkt" data-bs-toggle="modal"><i
                                                                            data-feather="edit" class="icon-sm me-2"></i>
                                                                        <span class="">Edit Unit</span></a>
                                                                @endif
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="#updt-info-ticket" data-bs-toggle="modal"><i
                                                                        data-feather="edit" class="icon-sm me-2"></i>
                                                                    <span class="">Edit Info Ticket</span></a>
                                                                @if (empty($detail->first()->full_name) ||
                                                                        $detail->first()->type_ticket == 'Install' ||
                                                                        $detail->first()->type_ticket == 'Deploy' ||
                                                                        $detail->first()->type_ticket == 'Staging' ||
                                                                        $detail->first()->type_ticket == 'Breakfix' ||
                                                                        $detail->first()->type_ticket == 'Inventory' ||
                                                                        $detail->first()->type_ticket == 'Delivery')
                                                                    <form action="{{ url("Close/Ticket/$id") }}"
                                                                        method="post" id="close-ticket-dt">
                                                                        @csrf
                                                                        {{ method_field('patch') }}
                                                                    </form>
                                                                    @if (($detail->first()->type_ticket == 'Inventory' || $detail->first()->type_ticket == 'Delivery') && $role == 16)
                                                                        <a class="dropdown-item d-flex align-items-center close-ticket-dt"
                                                                            href="javascript:;"><i data-feather="x-square"
                                                                                class="icon-sm me-2"></i>
                                                                            <span class="">Close Ticket</span>
                                                                        </a>
                                                                    @endif
                                                                    @if ($role == 19)
                                                                        <a class="dropdown-item d-flex align-items-center close-ticket-dt"
                                                                            href="javascript:;"><i data-feather="x-square"
                                                                                class="icon-sm me-2"></i>
                                                                            <span class="">Close Ticket</span>
                                                                        </a>
                                                                        <a class="dropdown-item d-flex align-items-center cancle-ticket-dt"
                                                                            href="javascript:;"><i data-feather="x-square"
                                                                                class="icon-sm me-2"></i>
                                                                            <span class="">Cancel Ticket</span>
                                                                        </a>
                                                                        <form action="{{ url("Ticket-Cancle/$id") }}"
                                                                            method="post" id="cancle-ticket-dt">
                                                                            @csrf
                                                                            {{ method_field('patch') }}
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                            @elseif($detail->first()->status == 10)
                                                                @if (!empty($detail->first()->full_name))
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity"
                                                                            class="icon-sm me-2"></i>
                                                                        <span class="">Activity Engineer</span></a>
                                                                @endif
                                                            @endif
                                                        @elseif($depart == 3 || $depart == 5)
                                                            @if ($detail->first()->status != 0 && $detail->first()->status != 9)
                                                                @if (!empty($detail->first()->full_name))
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity"
                                                                            class="icon-sm me-2"></i>
                                                                        <span class="">Activity Engineer</span></a>
                                                                @endif
                                                            @endif
                                                        @elseif($depart == 9)
                                                            @if ($validate_awb->status_awb == 1)
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="#awb-log-data" data-bs-toggle="modal"><i
                                                                        data-feather="activity" class="icon-sm me-2"></i>
                                                                    <span class="">Log AWB</span></a>
                                                            @endif
                                                        @endif
                                                        @if ($depart == 6 || $depart == 13 || $role == 20 || $role == 15)
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="#list-attach" data-bs-toggle="modal"><i
                                                                    data-feather="file" class="icon-sm me-2"></i>
                                                                <span class="">Attachment</span></a>

                                                            <a class="dropdown-item d-flex align-items-center change-engineer"
                                                                href="#engineer-change" data-bs-toggle="modal"><i
                                                                    data-feather="user-check" class="icon-sm me-2"></i>
                                                                <span class="">Change Engineer</span></a>
                                                        @endif
                                                    </div>
                                                    @if ($depart == 4 || $role == 20 || $role == 15)
                                                        @if (@$detail->first()->status != 10)
                                                            <div class="modal fade" id="updt-info-ticket" tabindex="-1"
                                                                aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="sourceModalLabel">
                                                                                Edit Ticket
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="btn-close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ url("edit-InfoTicket/Ticket=$id") }}"
                                                                                method="post" id="form-updt-ticket">
                                                                                @csrf
                                                                                {{ method_field('patch') }}
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Type Ticket :
                                                                                        </p>
                                                                                        <select
                                                                                            class="js-example-basic-single form-select"
                                                                                            data-width="100%"
                                                                                            name="fm_dt_type_ticket">
                                                                                            <option value="">
                                                                                                -
                                                                                                Choose
                                                                                                -
                                                                                            </option>
                                                                                            @foreach ($typeTicket as $item)
                                                                                                <option
                                                                                                    value="{{ $item->id }}"
                                                                                                    {{ $item->id == @$detail->first()->key_type_ticket ? 'selected' : '' }}>
                                                                                                    {{ $item->type_name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Case ID :
                                                                                        </p>
                                                                                        <input class="form-control"
                                                                                            name="dt_csid" type="text"
                                                                                            value="{{ $detail->first()->case_id }}"
                                                                                            placeholder="Type Reference ID">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Source :
                                                                                        </p>
                                                                                        <select
                                                                                            class="js-example-basic-single form-select"
                                                                                            data-width="100%"
                                                                                            name="fm_dt_src">
                                                                                            <option value="">
                                                                                                -
                                                                                                Choose
                                                                                                -
                                                                                            </option>
                                                                                            @foreach ($source as $item)
                                                                                                <option
                                                                                                    value="{{ $item->id }}"
                                                                                                    {{ $item->id == @$detail->first()->sumber_id ? 'selected' : '' }}>
                                                                                                    {{ $item->sumber_name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Back</button>
                                                                            <button type="button"
                                                                                class="btn btn-primary save-updt-ticket">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal fade bd-example-modal-lg" id="updt-unit-tkt"
                                                                tabindex="-1" aria-labelledby="sourceModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="sourceModalLabel">
                                                                                Update Unit
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="btn-close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ url("Update-Unit/$id/Detail-Ticket") }}"
                                                                                method="post" id="dt-form-edit-unit">
                                                                                @csrf
                                                                                {{ method_field('patch') }}
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-3">
                                                                                        <div
                                                                                            class="justify-content-between flex-grow-1">
                                                                                            <div>
                                                                                                <p
                                                                                                    class="form-label fw-bolder">
                                                                                                    Merk :
                                                                                                </p>
                                                                                                <select
                                                                                                    class="js-example-basic-single form-select"
                                                                                                    data-width="100%"
                                                                                                    name="dt_merk_u"
                                                                                                    id="dt-merk-u"
                                                                                                    {{ $disabled }}>
                                                                                                    <option value="">
                                                                                                        -
                                                                                                        Choose
                                                                                                        -
                                                                                                    </option>
                                                                                                    @foreach ($merk as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->id ?? '' }}"
                                                                                                            {{ @$detail->first()->merk == $item->merk ? 'selected' : '' }}>
                                                                                                            {{ $item->merk ?? '' }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div
                                                                                            class="justify-content-between flex-grow-1">
                                                                                            <div>
                                                                                                <p
                                                                                                    class="form-label fw-bolder">
                                                                                                    Category :
                                                                                                </p>
                                                                                                <select
                                                                                                    class="js-example-basic-single form-select"
                                                                                                    data-width="100%"
                                                                                                    name="dt_ktgr_u"
                                                                                                    id="dt-ktgr-u"
                                                                                                    {{ $disabled }}>
                                                                                                    <option value="">
                                                                                                        -
                                                                                                        Choose
                                                                                                        -
                                                                                                    </option>
                                                                                                    @foreach ($ktgr_unit as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->category_id ?? '' }}"
                                                                                                            {{ @$detail->first()->category_name == $item->category_name ? 'selected' : '' }}>
                                                                                                            {{ $item->category_name ?? '' }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Type :
                                                                                        </p>
                                                                                        <div class="input-group mb-2">
                                                                                            <select
                                                                                                class="js-example-basic-single form-select"
                                                                                                data-width="80%"
                                                                                                name="dt_type_u"
                                                                                                id="dt-type-u"
                                                                                                {{ $disabled }}>
                                                                                                <option value="">
                                                                                                    -
                                                                                                    Choose
                                                                                                    -
                                                                                                </option>
                                                                                            </select>
                                                                                            <button
                                                                                                class="btn btn-inverse-primary"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#unitTypeDT"
                                                                                                type="button"><i
                                                                                                    class="btn-icon-append icon-lg"
                                                                                                    data-feather="plus"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div
                                                                                            class="justify-content-between flex-grow-1">
                                                                                            <label for="input-PN/SN"
                                                                                                class="form-label fw-bolder">PN/SN
                                                                                                Unit : </label>
                                                                                            <div class="input-group mb-3"
                                                                                                id="input-PN/SN">
                                                                                                <input type="text"
                                                                                                    name="dt_pn_unit"
                                                                                                    class="form-control"
                                                                                                    placeholder="Product Number"
                                                                                                    aria-label="Product Number"
                                                                                                    aria-describedby="basic-addon2"
                                                                                                    id="unit-pn"
                                                                                                    value="{{ @$detail->first()->pn }}">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <button
                                                                                                        class="btn btn-inverse-secondary"
                                                                                                        type="button"
                                                                                                        style="border : none;"
                                                                                                        disabled>/</button>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    name="dt_sn_unit"
                                                                                                    class="form-control"
                                                                                                    placeholder="Serial Number"
                                                                                                    aria-label="Serial Number"
                                                                                                    aria-describedby="basic-addon2"
                                                                                                    id="unit-sn"
                                                                                                    value="{{ $detail->first()->sn }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="edt-return-or-not"
                                                                                            class="form-label fw-bolder">Warranty
                                                                                            : </label>
                                                                                        <fieldset id="edt-return-or-not">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input type="radio"
                                                                                                    class="form-check-input"
                                                                                                    value="1"
                                                                                                    name="edt_warranty_dt"
                                                                                                    {{ @$detail->first()->info_tiket->warranty == 1 ? 'checked' : '' }}>
                                                                                                <label
                                                                                                    class="form-check-label">
                                                                                                    Yes
                                                                                                </label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input type="radio"
                                                                                                    class="form-check-input"
                                                                                                    value="0"
                                                                                                    name="edt_warranty_dt"
                                                                                                    {{ @$detail->first()->info_tiket->warranty == 0 ? 'checked' : '' }}>
                                                                                                <label
                                                                                                    class="form-check-label">
                                                                                                    No
                                                                                                </label>
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="justify-content-between flex-grow-1">
                                                                                                    <div>
                                                                                                        <p
                                                                                                            class="form-label fw-bolder">
                                                                                                            Problem :
                                                                                                        </p>
                                                                                                        <textarea class="form-control txt-note" rows="3" placeholder="Type Note" name="edt_prob">{{ @$detail->first()->problem }}</textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="justify-content-between flex-grow-1 border-bottom-dt">
                                                                                                    <div>
                                                                                                        <p
                                                                                                            class="form-label fw-bolder">
                                                                                                            Action Plan :
                                                                                                        </p>
                                                                                                        <textarea class="form-control txt-note" rows="3" placeholder="Type Note" name="edt_act_plan">{{ @$detail->first()->action_plan }}</textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="button"
                                                                                class="btn btn-success dt-btn-save-edit-unit"
                                                                                id="saveButton">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Modal Add Type --}}
                                                            <div class="modal fade" id="unitTypeDT" tabindex="-1"
                                                                aria-labelledby="slaModalLabel" aria-hidden="true"
                                                                data-bs-backdrop="static">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="slaModalLabel">
                                                                                Update Type Unit
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="btn-close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>
                                                                                # This is for adding <b>'Unit Type'</b> that
                                                                                doesn't exist in <b>'Select Type Unit'</b>,
                                                                                after insert <b>'Type'</b> will update the
                                                                                <b>'type Unit'</b> on this ticket.
                                                                                Make sure the <b>'Type Unit'</b> is doesn't
                                                                                exist!
                                                                            </p>
                                                                            <hr>
                                                                            <form
                                                                                action="{{ url("dt-Type/$id/Added-Updated") }}"
                                                                                id="fm-dt-type-not-exist" method="post">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Merk :
                                                                                        </p>
                                                                                        <select
                                                                                            class="js-example-basic-single form-select"
                                                                                            data-width="100%"
                                                                                            name="not_exist_merk"
                                                                                            id="dt-val-merk-ne"
                                                                                            {{ $disabled }}>
                                                                                            <option value="">
                                                                                                -
                                                                                                Choose
                                                                                                -
                                                                                            </option>
                                                                                            @foreach ($merk as $item)
                                                                                                <option
                                                                                                    value="{{ $item->id ?? '' }}"
                                                                                                    {{ @$detail->first()->merk == $item->merk ? 'selected' : '' }}>
                                                                                                    {{ $item->merk ?? '' }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-3">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Category :
                                                                                        </p>
                                                                                        <select
                                                                                            class="js-example-basic-single form-select"
                                                                                            data-width="100%"
                                                                                            name="not_exist_ktgr"
                                                                                            id="dt-val-ktgr-ne"
                                                                                            {{ $disabled }}>
                                                                                            <option value="">
                                                                                                -
                                                                                                Choose
                                                                                                -
                                                                                            </option>
                                                                                            @foreach ($ktgr_unit as $item)
                                                                                                <option
                                                                                                    value="{{ $item->category_id ?? '' }}"
                                                                                                    {{ @$detail->first()->category_name == $item->category_name ? 'selected' : '' }}>
                                                                                                    {{ $item->category_name ?? '' }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="mb-3">
                                                                                            <label for="not-exist-type-add"
                                                                                                class="form-label fw-bolder">Type
                                                                                                Unit</label>
                                                                                            <input class="form-control"
                                                                                                name="dt_type_unit_add"
                                                                                                id="not-exist-type-add"
                                                                                                type="text"
                                                                                                placeholder="Type Unit">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-inverse-secondary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#updt-unit-tkt">Back</button>
                                                                            <button type="button"
                                                                                class="btn btn-success add-type-not-exist">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @elseif($depart == 9)
                                                        <div class="modal fade bd-example-modal-lg" id="awb-log-data"
                                                            tabindex="-1" aria-labelledby="sourceModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="sourceModalLabel">
                                                                            Logging AWB
                                                                        </h5>
                                                                        &nbsp;
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="btn-close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table id="display" class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        No</th>
                                                                                    <th>
                                                                                        Users</th>
                                                                                    <th>
                                                                                        Notiket</th>
                                                                                    <th>
                                                                                        Action</th>
                                                                                    <th>
                                                                                        Timestamp</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $no = 1;
                                                                                @endphp
                                                                                @foreach ($log_awb as $item)
                                                                                    <tr>
                                                                                        <td>{{ $no }}</td>
                                                                                        <td>{{ $item->full_name }}</td>
                                                                                        <td>{{ $item->notiket }}</td>
                                                                                        <td>{{ $item->action }}</td>
                                                                                        <td>{{ $item->dtime }}</td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $no++;
                                                                                    @endphp
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-inverse-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            {{-- MODAL Engineer --}}
                                            <div class="modal fade bd-example-modal-lg" id="find-engineer" tabindex="-1"
                                                aria-labelledby="projectModal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="projectModal">Select
                                                                Option
                                                                Engineer
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table id="display" class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                No</th>
                                                                            <th>
                                                                                NIK</th>
                                                                            <th>
                                                                                Name</th>
                                                                            <th>
                                                                                Email</th>
                                                                            <th>
                                                                                Service Point</th>
                                                                            <th>
                                                                                Option</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($engineer as $item)
                                                                            <tr>
                                                                                <td>{{ $no }}</td>
                                                                                <td>{{ $item->nik }}</td>
                                                                                <td>{{ $item->full_name }}</td>
                                                                                <td>{{ $item->email }}</td>
                                                                                <td>{{ $item->service_name }}
                                                                                </td>
                                                                                <td>
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-info btn-icon btn-sm select-engineer">
                                                                                        <i data-feather="mouse-pointer"
                                                                                            data-bs-dismiss="modal"></i>
                                                                                    </button>
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
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-inverse-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#engineer-change">Back</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade bd-example-modal-lg" id="engineer-change"
                                                tabindex="-1" aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="sourceModalLabel">
                                                                Change Engineer
                                                                to Take ticket
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url("Update/$id/Change-Engineer") }}"
                                                                method="post" id="update-change-engineer">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" name="sp_en_name"
                                                                                    id="get-sp-en" style="display: none;">
                                                                                <input type="text" name="nik_engineer"
                                                                                    id="id-engineer"
                                                                                    style="display: none;">
                                                                                <input type="text" class="form-control"
                                                                                    placeholder="Engineer Name"
                                                                                    aria-label="Engineer name"
                                                                                    aria-describedby="basic-addon2"
                                                                                    id="engineer-name" disabled>
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-inverse-primary"
                                                                                        type="button"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#find-engineer"><i
                                                                                            class="btn-icon-append icon-lg"
                                                                                            data-feather="database"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button"
                                                                class="btn btn-success change-en-save">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- MODAL L2 --}}
                                            <div class="modal fade bd-example-modal-lg" id="find-l2engineer"
                                                tabindex="-1" aria-labelledby="projectModal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="projectModal">Select
                                                                Option
                                                                Engineer
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table id="display" class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                No</th>
                                                                            <th>
                                                                                NIK</th>
                                                                            <th>
                                                                                Name</th>
                                                                            <th>
                                                                                Email</th>
                                                                            <th>
                                                                                Service Point</th>
                                                                            <th>
                                                                                Option</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($l2_en as $item)
                                                                            <tr>
                                                                                <td>{{ $no }}</td>
                                                                                <td>{{ $item->nik }}</td>
                                                                                <td>{{ $item->full_name }}</td>
                                                                                <td>{{ $item->email }}</td>
                                                                                <td>{{ $item->service_name }}
                                                                                </td>
                                                                                <td>
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-info btn-icon btn-sm select-l2">
                                                                                        <i data-feather="mouse-pointer"
                                                                                            data-bs-dismiss="modal"></i>
                                                                                    </button>
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
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-inverse-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#l2-engineer-change">Back</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade bd-example-modal-lg" id="l2-engineer-change"
                                                tabindex="-1" aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="sourceModalLabel">
                                                                Change L2
                                                                to Take ticket
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url("Update/$id/Change-L2") }}"
                                                                method="post" id="update-change-l2-engineer">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" name="nik_engineer"
                                                                                    id="id-l2" style="display: none;">
                                                                                <input type="text" class="form-control"
                                                                                    placeholder="Engineer Name"
                                                                                    aria-label="Engineer name"
                                                                                    aria-describedby="basic-addon2"
                                                                                    id="l2-name" disabled>
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-inverse-primary"
                                                                                        type="button"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#find-l2engineer"><i
                                                                                            class="btn-icon-append icon-lg"
                                                                                            data-feather="database"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button"
                                                                class="btn btn-success change-l2en-save">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- MODAL Attachment --}}
                                            <div class="modal fade bd-example-modal-lg" id="list-attach" tabindex="-1"
                                                aria-labelledby="attachModal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">List Attachment
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table id="display" class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                No</th>
                                                                            <th>
                                                                                File Name</th>
                                                                            @if ($depart == 10)
                                                                                <th>
                                                                                    On Site</th>
                                                                            @endif
                                                                            <th>
                                                                                Option</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($file_attach_ticket as $item)
                                                                            <tr>
                                                                                <td>{{ $no }}</td>
                                                                                <td>{{ $item->filename }}</td>
                                                                                @if ($depart == 10)
                                                                                    <td>{{ $item->visiting }}</td>
                                                                                @endif
                                                                                <td>
                                                                                    <form method="POST"
                                                                                        action="{{ url("Attach-download/File-Ticket/$item->id") }}"
                                                                                        style="display: none;"
                                                                                        id="download-ticket-file{{ $no }}">
                                                                                        @csrf
                                                                                    </form>
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-primary btn-icon btn-sm download-file-ticket-attach{{ $no }}">
                                                                                        <i data-feather="download"
                                                                                            data-bs-dismiss="modal"></i>
                                                                                    </button>
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
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-inverse-secondary"
                                                                data-bs-dismiss="modal">Cancle</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="aside-body">
                                        <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="chats-tab" data-bs-toggle="tab"
                                                    data-bs-target="#chats" role="tab" aria-controls="chats"
                                                    aria-selected="true">
                                                    <div
                                                        class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                        <i data-feather="info"
                                                            class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                        @if ($depart == 9)
                                                            <p class="d-none d-sm-block">AWB</p>
                                                        @else
                                                            <p class="d-none d-sm-block">Ticket</p>
                                                        @endif
                                                    </div>
                                                </a>
                                            </li>
                                            @if ($depart != 9 && $depart != 6)
                                                @if (!empty($validate_problem))
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="calls-tab" data-bs-toggle="tab"
                                                            data-bs-target="#Problem" role="tab"
                                                            aria-controls="calls" aria-selected="false">
                                                            <div
                                                                class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                                <i data-feather="info"
                                                                    class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                                <p class="d-none d-sm-block">Problem</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>
                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show active" id="chats" role="tabpanel"
                                                aria-labelledby="chats-tab">
                                                <div class="row">
                                                    @if ($depart != 6)
                                                        <div class="col-md-6 border-end-lg">
                                                            <div class="row">
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Type Ticket
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->type_ticket }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Case ID
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->case_id }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Entry Date
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->entrydate }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if ($depart != 9)
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Source
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->sumber_name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Project
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->project_name . ' ~ ' . @$detail->first()->partner }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Contact Name
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->contact_person }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-12 border-bottom-dt mb-2">
                                                                <div class="row text-body fw-bolder">
                                                                    <div class="col-3">
                                                                        Contact Person
                                                                    </div>
                                                                    <div class="col-1">
                                                                        :
                                                                    </div>
                                                                    <div class="col-8">
                                                                        {{ @$detail->first()->contact_person }}
                                                                        &nbsp;
                                                                        <a href="#see-customer-detil-ticket"
                                                                            data-bs-toggle="modal">
                                                                            ( <i class="icon-lg"
                                                                                data-feather="search"></i> )
                                                                        </a>
                                                                        <div class="modal fade bd-example-modal-lg"
                                                                            id="see-customer-detil-ticket" tabindex="-1"
                                                                            aria-labelledby="ownerModal"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="ownerModal">End User
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="btn-close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form class="form"
                                                                                            action="{{ url("update/End-User/$id") }}"
                                                                                            method="post" id="updt-eu">
                                                                                            @csrf
                                                                                            {{ method_field('patch') }}
                                                                                            <div
                                                                                                class="row border-bottom-dt mb-2">
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="justify-content-between flex-grow-1">
                                                                                                        <div>
                                                                                                            <p class="text-body fw-bolder"
                                                                                                                type="Company Name:">
                                                                                                                <input
                                                                                                                    placeholder="Write Company here.."
                                                                                                                    name="company_eu"
                                                                                                                    value="{{ @$detail->first()->company }}"
                                                                                                                    {{ $readonly }}>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6 mb-2">
                                                                                                    <div
                                                                                                        class="justify-content-between flex-grow-1 border-bottom-dt">
                                                                                                        <div>
                                                                                                            <p class="text-body fw-bolder"
                                                                                                                type="Type Company:">
                                                                                                                <select
                                                                                                                    class="js-example-basic-single form-select"
                                                                                                                    data-width="100%"
                                                                                                                    name="type_kantor_eu"
                                                                                                                    {{ $disabled }}>
                                                                                                                    <option
                                                                                                                        value="">
                                                                                                                        -
                                                                                                                        Select
                                                                                                                        Option
                                                                                                                        -
                                                                                                                    </option>
                                                                                                                    @foreach ($office_type as $item)
                                                                                                                        <option
                                                                                                                            value="{{ $item->office_type_id ?? '' }}"
                                                                                                                            {{ @$detail->first()->type_office == $item->office_type_id ? 'selected' : '' }}>
                                                                                                                            {{ $item->name_type ?? '' }}
                                                                                                                        </option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-md-6 border-end-lg">
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <div
                                                                                                                    class="justify-content-between flex-grow-1">
                                                                                                                    <div>
                                                                                                                        <p class="text-body fw-bolder"
                                                                                                                            type="Contact Person:">
                                                                                                                            <input
                                                                                                                                placeholder="Write Contact Person here.."
                                                                                                                                name="person_eu"
                                                                                                                                value="{{ @$detail->first()->contact_person }}"
                                                                                                                                {{ $readonly }}>
                                                                                                                        </p>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                <div
                                                                                                                    class="col-md-6">
                                                                                                                    <div
                                                                                                                        class="mb-3">
                                                                                                                        <div
                                                                                                                            class="justify-content-between flex-grow-1">
                                                                                                                            <div>
                                                                                                                                <p class="text-body fw-bolder"
                                                                                                                                    type="Phone:">
                                                                                                                                    <input
                                                                                                                                        name="phone_eu"
                                                                                                                                        placeholder="Write Phone here.."
                                                                                                                                        value="{{ @$detail->first()->phone }}"
                                                                                                                                        data-inputmask-alias="(+62) 999-9999-9999"
                                                                                                                                        {{ $readonly }} />
                                                                                                                                </p>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-6">
                                                                                                                    <div
                                                                                                                        class="mb-3">
                                                                                                                        <div
                                                                                                                            class="justify-content-between flex-grow-1">
                                                                                                                            <div>
                                                                                                                                <p class="text-body fw-bolder"
                                                                                                                                    type="Phone:">
                                                                                                                                    <input
                                                                                                                                        name="ext_phone_eu"
                                                                                                                                        placeholder="Write Phone here.."
                                                                                                                                        value="{{ @$detail->first()->ext_phone }}"
                                                                                                                                        data-inputmask-alias="(+62) 999-9999-9999"
                                                                                                                                        {{ $readonly }} />
                                                                                                                                </p>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <div
                                                                                                                    class="justify-content-between flex-grow-1">
                                                                                                                    <div>
                                                                                                                        <p class="text-body fw-bolder"
                                                                                                                            type="Email:">
                                                                                                                            <input
                                                                                                                                name="email_eu"
                                                                                                                                placeholder="Write Email here.."
                                                                                                                                value="{{ @$detail->first()->email }}"
                                                                                                                                data-inputmask="'alias': 'email'"
                                                                                                                                {{ $readonly }} />
                                                                                                                        </p>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-md-6">
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                <div
                                                                                                                    class="col-md-6">
                                                                                                                    <div
                                                                                                                        class="mb-3">
                                                                                                                        <div
                                                                                                                            class="justify-content-between flex-grow-1">
                                                                                                                            <div>
                                                                                                                                <p class="text-body fw-bolder mb-1"
                                                                                                                                    type="Provinsi:">
                                                                                                                                </p>
                                                                                                                                <select
                                                                                                                                    class="js-example-basic-single form-select"
                                                                                                                                    data-width="100%"
                                                                                                                                    name="province_eu"
                                                                                                                                    id="provinces-eu"
                                                                                                                                    {{ $disabled }}>
                                                                                                                                    <option
                                                                                                                                        value="">
                                                                                                                                        -
                                                                                                                                        Choose
                                                                                                                                        -
                                                                                                                                    </option>
                                                                                                                                    @foreach ($province as $item)
                                                                                                                                        <option
                                                                                                                                            value="{{ $item->id ?? '' }}"
                                                                                                                                            {{ @$detail->first()->provinces == $item->id ? 'selected' : '' }}>
                                                                                                                                            {{ $item->name ?? '' }}
                                                                                                                                        </option>
                                                                                                                                    @endforeach
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-6">
                                                                                                                    <div
                                                                                                                        class="mb-3">
                                                                                                                        <div
                                                                                                                            class="justify-content-between flex-grow-1">
                                                                                                                            <div>
                                                                                                                                <p class="text-body fw-bolder mb-1"
                                                                                                                                    type="Kabupaten:">
                                                                                                                                </p>
                                                                                                                                <select
                                                                                                                                    class="js-example-basic-single form-select"
                                                                                                                                    data-width="100%"
                                                                                                                                    name="cities_eu"
                                                                                                                                    id="cities-eu"
                                                                                                                                    {{ $disabled }}>
                                                                                                                                    <option
                                                                                                                                        value="">
                                                                                                                                        -
                                                                                                                                        Choose
                                                                                                                                        -
                                                                                                                                    </option>
                                                                                                                                </select>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="justify-content-between flex-grow-1">
                                                                                                                <p class="text-body fw-bolder"
                                                                                                                    type="Address:">
                                                                                                                    <textarea name="address_eu" rows="2" placeholder="Type Address" {{ $readonly }}>{{ @$detail->first()->address }}</textarea>
                                                                                                                </p>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <div
                                                                                                                    class="justify-content-between flex-grow-1">
                                                                                                                    <div>
                                                                                                                        <p class="text-body fw-bolder mb-1"
                                                                                                                            type="Location:">
                                                                                                                            <select
                                                                                                                                class="js-example-basic-single form-select"
                                                                                                                                data-width="100%"
                                                                                                                                name="severity_eu"
                                                                                                                                {{ $disabled }}>
                                                                                                                                <option
                                                                                                                                    value="">
                                                                                                                                    -
                                                                                                                                    Choose
                                                                                                                                    -
                                                                                                                                </option>
                                                                                                                                @foreach ($severity as $item)
                                                                                                                                    <option
                                                                                                                                        value="{{ $item->id }}"
                                                                                                                                        {{ @$detail->first()->severity_name == $item->severity_name ? 'selected' : '' }}>
                                                                                                                                        {{ $item->severity_name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </p>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#owner_hgt">Back</button>
                                                                                        @if ($depart == 4)
                                                                                            <button type="button"
                                                                                                class="btn btn-success edit-eu">Edit</button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($depart != 9)
                                                                @if ($depart != 6)
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Engineer
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                @if (empty($detail->first()->full_name))
                                                                                    No Engineer
                                                                                @else
                                                                                    {{ $detail->first()->full_name }}
                                                                                    <br>
                                                                                    {{ $detail->first()->phone_en . ' ~ ' . $detail->first()->service_name }}
                                                                                @endif
                                                                                &nbsp;
                                                                                @if ($depart == 4)
                                                                                    @if (!empty($detail->first()->full_name))
                                                                                        <form
                                                                                            action="{{ url("Remove-Engineer/Ticket/$id") }}"
                                                                                            method="post"
                                                                                            id="dtFrom-remove-en"
                                                                                            style="display: none;">
                                                                                            @csrf
                                                                                            {{ method_field('patch') }}
                                                                                        </form>
                                                                                        <a href="javascript:;"
                                                                                            class="btn-remove-en-dt">
                                                                                            ( <i class="icon-lg"
                                                                                                data-feather="x"></i> )
                                                                                        </a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                L2 Engineer
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                @if (empty($detail->first()->nik_l2))
                                                                                    No Engineer
                                                                                @else
                                                                                    {{ $detail->first()->l2_en }} ~
                                                                                    {{ $detail->first()->l2_phone }}
                                                                                @endif
                                                                                &nbsp;
                                                                                @if ($depart == 4)
                                                                                    @if (!empty($detail->first()->nik_l2))
                                                                                        <form
                                                                                            action="{{ url("Remove/L2-Engineer/DT/$id") }}"
                                                                                            method="post"
                                                                                            id="dtFrom-remove-l2en"
                                                                                            style="display: none;">
                                                                                            @csrf
                                                                                            {{ method_field('patch') }}
                                                                                        </form>
                                                                                        <a href="javascript:;"
                                                                                            class="btn-remove-l2en-dt">
                                                                                            ( <i class="icon-lg"
                                                                                                data-feather="x"></i> )
                                                                                        </a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if (!empty($detail->first()->full_name))
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Schedule
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ @$detail->first()->departure }}
                                                                                &nbsp;
                                                                                @if ($depart == 4)
                                                                                    @if (@$detail->first()->status != 10)
                                                                                        <a href="#updt-sch"
                                                                                            data-bs-toggle="modal">
                                                                                            ( <i class="icon-lg"
                                                                                                data-feather="calendar"></i>
                                                                                            )
                                                                                        </a>
                                                                                        <div class="modal fade"
                                                                                            id="updt-sch" tabindex="-1"
                                                                                            aria-labelledby="sourceModalLabel"
                                                                                            aria-hidden="true">
                                                                                            <div class="modal-dialog">
                                                                                                <div class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-header">
                                                                                                        <h5 class="modal-title"
                                                                                                            id="sourceModalLabel">
                                                                                                            Update Schedule
                                                                                                            Engineer
                                                                                                        </h5>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn-close"
                                                                                                            data-bs-dismiss="modal"
                                                                                                            aria-label="btn-close"></button>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="modal-body">
                                                                                                        <form
                                                                                                            action="{{ url("Update-Ticket/Schedule/$id") }}"
                                                                                                            method="post"
                                                                                                            id="form-updt-sch-en">
                                                                                                            @csrf
                                                                                                            {{ method_field('patch') }}
                                                                                                            @php
                                                                                                                $sch = @$detail->first()->departure;
                                                                                                                $date = substr("$sch", 0, 10);
                                                                                                                $time = substr("$sch", 11);
                                                                                                            @endphp
                                                                                                            <div class="input-group flatpickr"
                                                                                                                id="flatpickr-date-time">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="Select date"
                                                                                                                    name="sch_time_sch"
                                                                                                                    id="dt-sch-en"
                                                                                                                    value="{{ $sch }}"
                                                                                                                    data-input
                                                                                                                    required>
                                                                                                                <span
                                                                                                                    class="input-group-text input-group-addon"
                                                                                                                    data-toggle><i
                                                                                                                        data-feather="calendar"></i></span>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="modal-footer">
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-secondary"
                                                                                                            data-bs-dismiss="modal">Back</button>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-primary save-updt-sch-en">Save</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            SLA
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->sla_name }}
                                                                            @if ($depart == 4)
                                                                                @if (@$detail->first()->status != 10)
                                                                                    <a href="#updt-sla"
                                                                                        data-bs-toggle="modal">
                                                                                        ( <i class="icon-lg"
                                                                                            data-feather="edit-3"></i>
                                                                                        )
                                                                                    </a>
                                                                                    <div class="modal fade" id="updt-sla"
                                                                                        tabindex="-1"
                                                                                        aria-labelledby="sourceModalLabel"
                                                                                        aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="sourceModalLabel">
                                                                                                        Change SLA
                                                                                                    </h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="btn-close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <form
                                                                                                        action="{{ url("Change-SLA/Ticket=$id") }}"
                                                                                                        method="post"
                                                                                                        id="form-updt-sla">
                                                                                                        @csrf
                                                                                                        {{ method_field('patch') }}
                                                                                                        <div
                                                                                                            class="row">
                                                                                                            <div
                                                                                                                class="col-md-6">
                                                                                                                <select
                                                                                                                    class="js-example-basic-single form-select"
                                                                                                                    data-width="100%"
                                                                                                                    name="updt_sla"
                                                                                                                    {{ $disabled }}>
                                                                                                                    <option
                                                                                                                        value="">
                                                                                                                        -
                                                                                                                        Choose
                                                                                                                        -
                                                                                                                    </option>
                                                                                                                    @foreach ($sla as $item)
                                                                                                                        <option
                                                                                                                            value="{{ $item->id }}"
                                                                                                                            {{ @$detail->first()->sla == $item->id ? 'selected' : '' }}>
                                                                                                                            {{ $item->sla_name }}
                                                                                                                        </option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-secondary"
                                                                                                        data-bs-dismiss="modal">Back</button>
                                                                                                    <button type="button"
                                                                                                        class="btn btn-primary save-updt-sla">Save</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Part Request
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->part_request }}
                                                                            @if ($depart != 10)
                                                                                @if (@$detail->first()->part_request == 'Yes')
                                                                                    <a href="#part-detail"
                                                                                        data-bs-toggle="modal">
                                                                                        ( <i class="icon-lg"
                                                                                            data-feather="search"></i> )
                                                                                    </a>
                                                                                    @if ($depart == 6 || $depart == 13)
                                                                                        @php
                                                                                            $sz = '';
                                                                                            $sz1 = '';
                                                                                        @endphp
                                                                                    @else
                                                                                        @php
                                                                                            $sz = 'bd-example-modal-xl';
                                                                                            $sz1 = 'modal-xl';
                                                                                        @endphp
                                                                                    @endif
                                                                                    <div class="modal fade {{ $sz }}"
                                                                                        id="part-detail" tabindex="-1"
                                                                                        aria-labelledby="partModal"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog {{ $sz1 }}">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5
                                                                                                        class="modal-title">
                                                                                                        Detail
                                                                                                        Part
                                                                                                    </h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="btn-close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    @if ($depart == 4 || $role == 20 || $role == 15)
                                                                                                        @if ($detail->first()->status == 10)
                                                                                                        @else
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <div class="btn-group me-2"
                                                                                                                    role="group"
                                                                                                                    aria-label="First group">
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="btn btn-inverse-primary btn-icon-text"
                                                                                                                        data-bs-toggle="modal"
                                                                                                                        data-bs-target="#add-part">
                                                                                                                        ADD
                                                                                                                        Part
                                                                                                                        <i class="btn-icon-append"
                                                                                                                            data-feather="plus"></i>
                                                                                                                    </button>
                                                                                                                    &nbsp;
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        onclick="window.location.href='{{ url('Ticket/' . $id . '/Part-Detail') }}'"
                                                                                                                        class="btn btn-inverse-info btn-icon-text">
                                                                                                                        Update
                                                                                                                        <i
                                                                                                                            data-feather="edit"></i>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                    @else
                                                                                                    @endif
                                                                                                    <div
                                                                                                        class="table-responsive">
                                                                                                        <table
                                                                                                            id="display"
                                                                                                            class="table">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <th>
                                                                                                                        No
                                                                                                                    </th>
                                                                                                                    <th>
                                                                                                                        Part
                                                                                                                    </th>
                                                                                                                    @if (@$detail->first()->status != 6)
                                                                                                                        @if ($depart != 6)
                                                                                                                            <th>
                                                                                                                                Category
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                Part
                                                                                                                                Number
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                SO
                                                                                                                                Number
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                RMA
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                Type
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                ETA
                                                                                                                            </th>
                                                                                                                            <th>
                                                                                                                                Option
                                                                                                                            </th>
                                                                                                                        @endif
                                                                                                                    @endif
                                                                                                                    <th>
                                                                                                                        Status
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @php
                                                                                                                    $no = 1;
                                                                                                                @endphp
                                                                                                                @foreach ($tiket_part as $item)
                                                                                                                    <tr>
                                                                                                                        <td>{{ $no }}
                                                                                                                        </td>
                                                                                                                        <td>{{ $item->unit_name }}
                                                                                                                        </td>
                                                                                                                        @if (@$detail->first()->status != 6)
                                                                                                                            @if ($depart != 6)
                                                                                                                                <td>{{ $item->type_name }}
                                                                                                                                </td>
                                                                                                                                <td>{{ $item->pn }}
                                                                                                                                </td>
                                                                                                                                <td>{{ $item->so_num }}
                                                                                                                                </td>
                                                                                                                                <td>{{ $item->rma }}
                                                                                                                                </td>
                                                                                                                                <td>{{ $item->part_type }}
                                                                                                                                </td>
                                                                                                                                <td>{{ $item->eta }}
                                                                                                                                </td>
                                                                                                                                <td>
                                                                                                                                    @if ($item->status == 2)
                                                                                                                                        No
                                                                                                                                        Action
                                                                                                                                        Needed
                                                                                                                                    @else
                                                                                                                                        <form
                                                                                                                                            action="{{ url("Update/Part-log/$item->id") }}"
                                                                                                                                            method="post"
                                                                                                                                            id="form-update-journey{{ $no }}"
                                                                                                                                            style="display:none;">
                                                                                                                                            @csrf
                                                                                                                                            {{ method_field('patch') }}
                                                                                                                                            <input
                                                                                                                                                type="hidden"
                                                                                                                                                name="log_part_notik"
                                                                                                                                                value="{{ $id }}">
                                                                                                                                            <input
                                                                                                                                                type="hidden"
                                                                                                                                                value="{{ $item->status }}"
                                                                                                                                                id="cek-journey-part{{ $no }}">
                                                                                                                                        </form>
                                                                                                                                        <button
                                                                                                                                            type="button"
                                                                                                                                            class="btn btn-inverse-info btn-icon btn-sm btn-update-journey{{ $no }}">
                                                                                                                                            <i
                                                                                                                                                data-feather="truck"></i>
                                                                                                                                        </button>
                                                                                                                                    @endif
                                                                                                                                </td>
                                                                                                                            @endif
                                                                                                                        @endif
                                                                                                                        <td>{{ $item->sts_journey }}
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
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-secondary"
                                                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal fade bd-example-modal-lg"
                                                                                        id="add-part" tabindex="-1"
                                                                                        aria-labelledby="sourceModalLabel"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog modal-lg">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="sourceModalLabel">
                                                                                                        Adding
                                                                                                        Part
                                                                                                    </h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="btn-close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <form
                                                                                                        action="{{ url("Part/$id/Added") }}"
                                                                                                        method="post"
                                                                                                        id="part-form">
                                                                                                        @csrf
                                                                                                        <div
                                                                                                            class="row">
                                                                                                            <div
                                                                                                                class="row mb-3">
                                                                                                                <div
                                                                                                                    class="col-md-4">
                                                                                                                    <label
                                                                                                                        for="choose-type-part"
                                                                                                                        class="form-label">Type
                                                                                                                        Part
                                                                                                                    </label>
                                                                                                                    <select
                                                                                                                        class="js-example-basic-single form-select"
                                                                                                                        data-width="100%"
                                                                                                                        id="choose-type-part"
                                                                                                                        name="status_part_updt">
                                                                                                                        <option
                                                                                                                            value="">
                                                                                                                            -
                                                                                                                            Select
                                                                                                                            Status
                                                                                                                            -
                                                                                                                        </option>
                                                                                                                        @foreach ($type as $item)
                                                                                                                            <option
                                                                                                                                value="{{ $item->id }}">
                                                                                                                                {{ $item->part_type }}
                                                                                                                            </option>
                                                                                                                        @endforeach
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-4">
                                                                                                                    <label
                                                                                                                        for="choose-ctgr"
                                                                                                                        class="form-label">Category
                                                                                                                        Part</label>
                                                                                                                    <select
                                                                                                                        class="js-example-basic-single form-select"
                                                                                                                        data-width="100%"
                                                                                                                        id="choose-ctgr"
                                                                                                                        name="kat_part_dt">
                                                                                                                        <option
                                                                                                                            value="">
                                                                                                                            -
                                                                                                                            Choose
                                                                                                                            -
                                                                                                                        </option>
                                                                                                                        @foreach ($ctgr_part as $item)
                                                                                                                            <option
                                                                                                                                value="{{ $item->id }}">
                                                                                                                                {{ $item->type_name }}
                                                                                                                            </option>
                                                                                                                        @endforeach
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-4">
                                                                                                                    <label
                                                                                                                        for="choose-part-name"
                                                                                                                        class="form-label">Part
                                                                                                                        Name
                                                                                                                    </label>
                                                                                                                    <input
                                                                                                                        class="form-control"
                                                                                                                        name="type_unit_updt"
                                                                                                                        type="text"
                                                                                                                        id="choose-part-name"
                                                                                                                        placeholder="Type Unit">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="row mb-3">
                                                                                                                <div
                                                                                                                    class="col-md-3">
                                                                                                                    <label
                                                                                                                        for="input-so"
                                                                                                                        class="form-label">SO
                                                                                                                        Number</label>
                                                                                                                    <input
                                                                                                                        class="form-control"
                                                                                                                        name="so_num_updt"
                                                                                                                        type="text"
                                                                                                                        id="input-so"
                                                                                                                        placeholder="SO Number">
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-3">
                                                                                                                    <label
                                                                                                                        for="input-rma"
                                                                                                                        class="form-label">RMA
                                                                                                                    </label>
                                                                                                                    <input
                                                                                                                        class="form-control"
                                                                                                                        name="rma_part_updt"
                                                                                                                        type="text"
                                                                                                                        id="input-rma"
                                                                                                                        placeholder="Type RMA Number">
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-3">
                                                                                                                    <label
                                                                                                                        for="pn-2"
                                                                                                                        class="form-label">Part
                                                                                                                        Number</label>
                                                                                                                    <input
                                                                                                                        id="pn-2"
                                                                                                                        class="form-control"
                                                                                                                        name="product_number_updt"
                                                                                                                        type="text"
                                                                                                                        placeholder="Product Number">
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-3">
                                                                                                                    <label
                                                                                                                        for="sn-2"
                                                                                                                        class="form-label">CT
                                                                                                                        Number</label>
                                                                                                                    <input
                                                                                                                        id="sn-2"
                                                                                                                        class="form-control"
                                                                                                                        name="serial_number_updt"
                                                                                                                        type="text"
                                                                                                                        placeholder="Serial Number">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-secondary"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#part-detail">Back</button>
                                                                                                    <button type="button"
                                                                                                        class="btn btn-primary store-part-dt">Save</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($depart == 6 || $depart == 13)
                                                        <div class="col-md-6 border-start">
                                                            <div class="row">
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Problem
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->problem }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Category
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->category_name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Merk
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->merk }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Type
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->type_name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            SN/PN
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->sn . '/' . @$detail->first()->pn }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Action Plan
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $detail->first()->action_plan }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if ($detail->first()->status == 10)
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Solve
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ @$detail->first()->solve }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if ($depart == 9)
                                                    @if ($validate_awb->status_awb == 1)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table id="display" class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Unit Name</th>
                                                                                <th>AWB Number</th>
                                                                                <th>SO Number</th>
                                                                                <th>RMA Number</th>
                                                                                <th>Part Number</th>
                                                                                <th>CT Number</th>
                                                                                <th>Type Part</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $no = 1;
                                                                            @endphp
                                                                            @foreach ($done_awb as $item)
                                                                                <tr>
                                                                                    <td>{{ $no }}</td>
                                                                                    <td>{{ $item->unit_name }}</td>
                                                                                    <td>{{ $item->awb_num }}</td>
                                                                                    <td>{{ $item->so_num }}</td>
                                                                                    <td>{{ $item->rma }}</td>
                                                                                    <td>{{ $item->pn }}</td>
                                                                                    <td>{{ $item->sn }}</td>
                                                                                    <td>{{ $item->part_type }}</td>
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
                                                    @endif
                                                @endif
                                            </div>
                                            @if ($depart != 9)
                                                @if (!empty($validate_problem))
                                                    <div class="tab-pane fade" id="Problem" role="tabpanel"
                                                        aria-labelledby="calls-tab">
                                                        <div class="row">
                                                            <div class="col-md-6 border-end-lg">
                                                                <div class="row">
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Problem
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->problem }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Category
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->category_name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Merk
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->merk }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Type
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->type_name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                SN/PN
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->sn . '/' . @$detail->first()->pn }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Action Plan
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ $detail->first()->action_plan }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 border-bottom-dt mb-2">
                                                                        <div class="row text-body fw-bolder">
                                                                            <div class="col-3">
                                                                                Solve
                                                                            </div>
                                                                            <div class="col-1">
                                                                                :
                                                                            </div>
                                                                            <div class="col-8">
                                                                                {{ @$detail->first()->solve }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($depart == 4 || $role == 20 || $role == 15)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6>Log Note Ticket</h6>
                                            </div>
                                        </div>
                                        @if ($detail->first()->status != 10)
                                            <div class="dropdown">
                                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-xl text-muted pb-3px" data-feather="settings"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item d-flex align-items-center" href="#add-note"
                                                        data-bs-toggle="modal"><i data-feather="plus"
                                                            class="icon-sm me-2"></i>
                                                        <span class="">Add Note</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="display" class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    No</th>
                                                <th>
                                                    Activity</th>
                                                <th>
                                                    Note</th>
                                                <th>
                                                    User</th>
                                                <th>
                                                    Created At</th>
                                                <th>
                                                    Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($log_detil as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ @$item->typeNote->ktgr_name }}
                                                    <td>{!! $item->note !!}</td>
                                                    <td>{{ @$item->get_user->full_name }}
                                                    </td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>
                                                        <div class="btn-toolbar" role="toolbar"
                                                            aria-label="Toolbar with button groups">
                                                            <div class="btn-group me-2" role="group"
                                                                aria-label="First group">
                                                                @if ($nik == 'HGT-KR016' && $item->type_log != 1)
                                                                    <button type="button"
                                                                        data-bs-target="#edit-note{{ $no }}"
                                                                        data-bs-toggle="modal"
                                                                        class="btn btn-inverse-info btn-icon btn-sm">
                                                                        <i data-feather="edit"></i>
                                                                    </button>
                                                                    &nbsp;
                                                                    <button type="button"
                                                                        class="btn btn-inverse-danger btn-icon btn-sm btn-remove-dt-log{{ $no }}">
                                                                        <i data-feather="trash-2"></i>
                                                                    </button>
                                                                @else
                                                                    @if ($nik == $item->user && $item->type_log != 1)
                                                                        <button type="button"
                                                                            data-bs-target="#edit-note{{ $no }}"
                                                                            data-bs-toggle="modal"
                                                                            class="btn btn-inverse-info btn-icon btn-sm">
                                                                            <i data-feather="edit"></i>
                                                                        </button>
                                                                        &nbsp;
                                                                        <button type="button"
                                                                            class="btn btn-inverse-danger btn-icon btn-sm btn-remove-dt-log{{ $no }}">
                                                                            <i data-feather="trash-2"></i>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                @if ($item->type_log != 1)
                                                                    <form
                                                                        action="{{ url("Delete/Log-Note/$item->id") }}"
                                                                        id="form-remove-dt-log{{ $no }}"
                                                                        method="post">
                                                                        @csrf
                                                                        {{ method_field('delete') }}
                                                                    </form>
                                                                    <div class="modal fade bd-example-modal-lg"
                                                                        id="edit-note{{ $no }}"
                                                                        tabindex="-1"
                                                                        aria-labelledby="sourceModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="sourceModalLabel">
                                                                                        Edit Log Note
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="btn-close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form
                                                                                        action="{{ url("edit/Log-Note/$item->id") }}"
                                                                                        method="post"
                                                                                        id="form-edt-note{{ $no }}">
                                                                                        @csrf
                                                                                        {{ method_field('patch') }}
                                                                                        <div class="row">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <div
                                                                                                                    class="d-flex justify-content-between align-items-baseline">
                                                                                                                    <label
                                                                                                                        for="choose-type-note"
                                                                                                                        class="form-label fw-bolder">Type
                                                                                                                        Note
                                                                                                                        :
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <select
                                                                                                                    id="choose-type-note"
                                                                                                                    class="js-example-basic-single form-select"
                                                                                                                    data-width="100%"
                                                                                                                    name="edt_type_note">
                                                                                                                    <option
                                                                                                                        value="">
                                                                                                                        -
                                                                                                                        Choose
                                                                                                                        -
                                                                                                                    </option>
                                                                                                                    @foreach ($type_note as $tn)
                                                                                                                        <option
                                                                                                                            value="{{ $tn->id }}"
                                                                                                                            {{ $item->type_note == $tn->id ? 'selected' : '' }}>
                                                                                                                            {{ $tn->ktgr_name }}
                                                                                                                        </option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="edt-input-desc-note"
                                                                                                                    class="form-label fw-bolder">Description
                                                                                                                    :
                                                                                                                </label>
                                                                                                                <textarea class="form-control txt-note" rows="3" id="edt-input-desc-note" placeholder="Type Note"
                                                                                                                    name="edt_log_note">{{ $item->note }}</textarea>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-secondary"
                                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-primary edt-dt-note{{ $no }}">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="modal fade bd-example-modal-lg" id="add-note" tabindex="-1"
                                        aria-labelledby="sourceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sourceModalLabel">
                                                        Adding
                                                        Log
                                                        Note Ticketing
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ url("Note/$id/Added") }}" method="post"
                                                        id="store-note">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-baseline">
                                                                        <label for="type-note"
                                                                            class="form-label fw-bolder">Aktivitas
                                                                            Helpdesk : </label>
                                                                        <a href="#" id="refresh-type-note">
                                                                            <i class="icon-sm"
                                                                                data-feather="rotate-cw"></i>
                                                                        </a>
                                                                    </div>
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="type_note"
                                                                        id="type-note">
                                                                        <option value="">
                                                                            - Choose -
                                                                        </option>
                                                                        @foreach ($type_note as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->ktgr_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="input-desc-note"
                                                                        class="form-label fw-bolder">Description
                                                                        : </label>
                                                                    <textarea class="form-control txt-note" rows="3" id="input-desc-note" placeholder="Type Note"
                                                                        name="log_note"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-baseline">
                                                                        <label for="rc_dt_note"
                                                                            class="form-label fw-bolder">Pending Karena :
                                                                        </label>
                                                                    </div>
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="ktgr_pending"
                                                                        id="rc_dt_note">
                                                                        <option value="">
                                                                            - Choose -
                                                                        </option>
                                                                        @foreach ($getStsP as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->ktgr_pending }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-inverse-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button"
                                                        class="btn btn-inverse-primary add-note">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('plugin-page')
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/chat.js"></script>
@endpush
@push('custom')
    <script>
        for (let i = 0; i < 50; i++) {
            $('.download-file-ticket-attach' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Download this file?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#download-ticket-file' + i + '').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
            });
            $('.btn-remove-dt-log' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Delete this Log?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-remove-dt-log' + i + '').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
            });
            $('.edt-dt-note' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Edit this Log?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-edt-note' + i + '').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
            });
        }
    </script>
    @if ($detail->first()->status < 10 && $depart == 4)
        <script>
            $('.save-updt-ticket').on('click', function() {
                Swal.fire({
                    title: 'Edit Info Ticket?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-updt-ticket').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
            });

            $('.btn-remove-en-dt').on('click', function() {
                Swal.fire({
                    title: "Remove Engineer from this ticket?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#dtFrom-remove-en').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });

            $('.btn-remove-l2en-dt').on('click', function() {
                Swal.fire({
                    title: "Remove L2 Engineer from this ticket?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#dtFrom-remove-l2en').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });

            $('.edit-eu').on('click', function() {
                Swal.fire({
                    title: "Continue save this data?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#updt-eu').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });
            $('.add-note').on('click', function() {
                function getTypeNoteValue() {
                    var type_id_val = document.getElementById("type-note").value;
                    return type_id_val;
                };

                function getRootCauseValue() {
                    var rc_id_val = document.getElementById("rc_dt_note").value;
                    return rc_id_val;
                };
                if (getTypeNoteValue() === "") {
                    Swal.fire({
                        title: "Type of note must be choosen!",
                        text: "Choose the type!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if (getRootCauseValue() === "") {
                    Swal.fire({
                        title: "Root Cause must be choosen!",
                        text: "Choose the Root Cause!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else {
                    jQuery('#store-note').submit();
                }
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });

            $('.change-en-save').on('click', function() {
                if ($('#engineer-name').val() === "") {
                    Swal.fire({
                        title: "Engineer empty!!",
                        text: "Choose from the list!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: "Continue change the engineer?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#update-change-engineer').submit();
                        }
                    });
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Enter") {
                            const nextButton = document.querySelector(".swal2-confirm");
                            if (nextButton) {
                                nextButton.click();
                            }
                        }
                    });
                    return false;
                }
            });

            $('.change-l2en-save').on('click', function() {
                if ($('#l2-name').val() === "") {
                    Swal.fire({
                        title: "L2 empty!!",
                        text: "Choose from the list!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: "Continue change the L2?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#update-change-l2-engineer').submit();
                        }
                    });
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Enter") {
                            const nextButton = document.querySelector(".swal2-confirm");
                            if (nextButton) {
                                nextButton.click();
                            }
                        }
                    });
                    return false;
                }
            });

            $('.dt-btn-save-edit-unit').on('click', function() {
                if ($('#unit-pn').val() === "" || $('#unit-sn').val() === "") {
                    Swal.fire({
                        title: "One of the SN/PN Can't be empty!!",
                        text: "Fill for the SN/PN!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: "Continue change information Unit?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#dt-form-edit-unit').submit();
                        }
                    });
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Enter") {
                            const nextButton = document.querySelector(".swal2-confirm");
                            if (nextButton) {
                                nextButton.click();
                            }
                        }
                    });
                    return false;
                }
            });

            $('.store-part-dt').on('click', function() {
                Swal.fire({
                    title: "Continue adding Part?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#part-form').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });

            $('.select-engineer').click(function() {
                let nik = $(this).closest('tr').find('td:eq(1)').text();
                let name = $(this).closest('tr').find('td:eq(2)').text();
                let get_sp_en = $(this).closest('tr').find('td:eq(4)').text();
                $('#id-engineer').val(nik);
                $('#engineer-name').val(name);
                $('#get-sp-en').val(get_sp_en);
                $('#find-engineer').modal('hide');
                setTimeout(function() {
                    $('#engineer-change').modal('show')
                }, 500);
            });

            $('.select-l2').click(function() {
                let nik = $(this).closest('tr').find('td:eq(1)').text();
                let name = $(this).closest('tr').find('td:eq(2)').text();
                let get_sp_en = $(this).closest('tr').find('td:eq(4)').text();
                $('#id-l2').val(nik);
                $('#l2-name').val(name);
                $('#find-l2engineer').modal('hide');
                setTimeout(function() {
                    $('#l2-engineer-change').modal('show')
                }, 500);
            });

            $('.close-ticket-dt').on('click', function() {
                Swal.fire({
                    title: 'Close Ticket?',
                    text: 'Ticket will be closed!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#close-ticket-dt').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });
            $('.cancle-ticket-dt').on('click', function() {
                Swal.fire({
                    title: 'Close Ticket?',
                    text: 'Ticket will be cancled!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#cancle-ticket-dt').submit();
                    }
                });
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        const nextButton = document.querySelector(".swal2-confirm");
                        if (nextButton) {
                            nextButton.click();
                        }
                    }
                });
                return false;
            });

            $('.add-type-not-exist').on('click', function() {
                if ($('#not-exist-type-add').val() === "") {
                    Swal.fire({
                        title: "Type can't be null",
                        text: "Write Type for update this ticket!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: "Continue adding Type & updat Type on this Ticket?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#fm-dt-type-not-exist').submit();
                        }
                    });
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Enter") {
                            const nextButton = document.querySelector(".swal2-confirm");
                            if (nextButton) {
                                nextButton.click();
                            }
                        }
                    });
                    return false;
                }
            });

            $('.change-part-reqs').on('click', function() {

                let status = document.getElementById('status-part-reqs').dataset.statusrqs;
                if (status == 'Yes') {
                    var title = "No need Parts?";
                    var text = "Status of part Request will be change to No!";
                } else {
                    var title = "Need Parts?";
                    var text = "Status of part Request will be change to Yes!";
                }
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {

                        jQuery('#form-change-part-reqs').submit();
                    }
                });
                return false;
            });
            $('.send-to-engineer').on('click', function() {

                Swal.fire({
                    title: "Tickets Ready?",
                    text: "Ticket will be sent to engineer!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-send-ticket-to-engineer').submit();
                    }
                });
                return false;
            });
            for (let i = 0; i < 50; i++) {
                $('.btn-update-journey' + i + '').on('click', function() {
                    $('#part-detail').modal('hide');
                    if ($('#cek-journey-part' + i + '').val() === "0") {
                        var text = "This part will be update to send!";
                    } else {
                        var text = "The part will be update to received!";
                    }
                    Swal.fire({
                        title: "Update?",
                        text: text,
                        icon: 'question',
                        showCancelButton: false,
                        showDenyButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Yes',
                        denyButtonColor: '#d33',
                        denyButtonText: "No"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#form-update-journey' + i + '').submit();
                        } else if (result.isDenied) {
                            $('#part-detail').modal('show');
                        }
                    });
                    return false;
                });
            }
            $('.save-updt-sch-en').on('click', function() {
                if ($('#dt-sch-en').val() === "") {
                    Swal.fire({
                        title: "The field cannot be empty!",
                        text: "Select date and time for updating schedule Engineer!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else {
                    jQuery('#form-updt-sch-en').submit();
                }
                return false;
            });
            $('.save-updt-sla').on('click', function() {
                Swal.fire({
                    title: "Continue change SLA?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-updt-sla').submit();
                    }
                });
                return false;
            });
        </script>
    @endif
    @if (!in_array($depart, [10, 6]))
        <script>
            function dtTypeUnit(url, ctgrpi_id, merk_id, name) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        ctgrpi_id: ctgrpi_id,
                        merk_id: merk_id
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            $('#' + name).empty();
                            $('#' + name).append(
                                '<option value="">- Choose Type -</option>');
                        } else {
                            $('#' + name).empty();
                            $('#' + name).append('<option value="">- Choose Type -</option>');
                            $.each(data, function(key, value) {
                                selected = '';
                                if ('{{ @$detail->first()->info_tiket->type_id }}' == key) {
                                    selected = 'selected';
                                }
                                $('#' + name).append('<option value="' + key + '" ' + selected + '>' +
                                    value + '</option>');
                            });
                        }
                    }
                });
            }
            $(function() {
                var valKtgr = '{{ @$detail->first()->info_tiket->category_id }}';
                var valMerk = '{{ @$detail->first()->info_tiket->merk_id }}';
                var ktgrSelect = $('#dt-ktgr-u');
                var merkSelect = $('#dt-merk-u');
                var typeSelect = $('#dt-type-u');

                if (valKtgr !== '' && valMerk !== '') {
                    // A province is already selected
                    ktgrSelect.val(valKtgr);
                    merkSelect.val(valMerk);
                    dtTypeUnit('{{ route('typeunit') }}', ktgrSelect.val(), merkSelect.val(), 'dt-type-u');
                } else {
                    // No province is selected
                    typeSelect.empty();
                    typeSelect.append('<option value="">- Select Type -</option>');
                }

                $('#dt-ktgr-u, #dt-merk-u').on('change', function() {
                    var selectedKtgrId = $("#dt-ktgr-u").val();
                    var selectedMerkId = $("#dt-merk-u").val();
                    if (selectedKtgrId === '' && selectedMerkId === '') {
                        typeSelect.empty();
                        typeSelect.append('<option value="">- Choose Type -</option>');
                    } else {
                        dtTypeUnit('{{ route('typeunit') }}', selectedKtgrId, selectedMerkId,
                            'dt-type-u');
                    }
                });
            });
        </script>
        <script>
            function onChangeSelectEU(url, id, name) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            $('#' + name).empty();
                            $('#' + name).append(
                                '<option value="">- No cities found for the selected province -</option>');
                        } else {
                            $('#' + name).empty();
                            $('#' + name).append('<option value="">- Choose -</option>');
                            $.each(data, function(key, value) {
                                selected = '';
                                if ('{{ @$detail->first()->kab }}' ==
                                    key) {
                                    selected = 'selected';
                                }
                                $('#' + name).append('<option value="' + key + '" ' + selected + '>' +
                                    value + '</option>');
                            });
                        }
                    }
                });
            }

            $(function() {
                var provincesSelect = $('#provinces-eu');
                var citiesSelect = $('#cities-eu');
                var selectedProvince = '{{ @$detail->first()->provinces }}';

                if (selectedProvince !== '') {
                    // A province is already selected
                    provincesSelect.val(selectedProvince);
                    onChangeSelectEU('{{ route('cities') }}', provincesSelect.val(), 'cities-eu');
                } else {
                    // No province is selected
                    citiesSelect.empty();
                    citiesSelect.append('<option value="">- Select Province -</option>');
                }

                // Change event for provinces select element
                provincesSelect.on('change', function() {
                    var selectedProvinceId = $(this).val();
                    if (selectedProvinceId === '') {
                        citiesSelect.empty();
                        citiesSelect.append('<option value="">- Choose -</option>');
                    } else {
                        onChangeSelectEU('{{ route('cities') }}', selectedProvinceId, 'cities-eu');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#refresh-type-note').click(function(e) {
                    e.preventDefault(); // Prevent the default click behavior
                    // Perform the AJAX request
                    $('#type-note').empty();
                    $.ajax({
                        url: '{{ route('refresh.cateogry.note') }}', // Replace with your Laravel route URL
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Update the select element with the received data
                            var options = '<option value="">- Choose -</option>';
                            for (var i = 0; i < data.length; i++) {
                                options += '<option value="' + data[i].id + '">' + data[i]
                                    .ktgr_name + '</option>';
                            }
                            $('#type-note').html(options);
                        },
                        error: function() {
                            console.log('Failed to fetch Category Note data.');
                        }
                    });
                });
            });
        </script>
        <script>
            $('#addt-upload-att').on('click', function() {
                const fileInputs = document.getElementById('adm-upload-att');
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = 'filesAdm[]';
                fileInput.accept = 'image/jpeg,image/gif,image/png,application/pdf,image/x-eps';
                fileInput.capture = 'camera';
                fileInputs.appendChild(fileInput);
            });

            for (let i = 0; i < 50; i++) {
                $('.dld-upd-adm' + i + '').on('click', function() {
                    Swal.fire({
                        title: 'Download this file?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'yes',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#fm-dld-adm' + i + '').submit();
                        }
                    });
                    document.addEventListener("keydown", function(event) {
                        if (event.key === "Enter") {
                            const nextButton = document.querySelector(".swal2-confirm");
                            if (nextButton) {
                                nextButton.click();
                            }
                        }
                    });
                });
            }
        </script>
    @endif
    @if (session('whatsapp_link_1') || session('whatsapp_link_2'))
        @if (session('whatsapp_link_1') && session('whatsapp_link_2'))
            <script>
                const whatsappLink1 = "{{ session('whatsapp_link_1') }}";
                const whatsappLink2 = "{{ session('whatsapp_link_2') }}";

                window.open(whatsappLink1, '_blank');
                window.open(whatsappLink2, '_blank');
            </script>
        @elseif (session('whatsapp_link_1'))
            <script>
                const whatsappLink1 = "{{ session('whatsapp_link_1') }}";

                window.open(whatsappLink1, '_blank');
            </script>
        @elseif (session('whatsapp_link_2'))
            <script>
                const whatsappLink2 = "{{ session('whatsapp_link_2') }}";

                window.open(whatsappLink2, '_blank');
            </script>
        @endif
    @endif
@endpush
