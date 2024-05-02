@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
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
                <li class="breadcrumb-item"><a href="{{ url('helpdesk/manage=Ticket') }}">Manage Ticket</a></li>
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
                                                <div class="me-3">
                                                    <h6>{{ $id }}</h6>
                                                    <p class="text-muted tx-13">Detail Tiket</p>
                                                </div>
                                                <div class="dropdown">
                                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xl text-muted pb-3px" data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                            @if ($detail->first()->status < 10)
                                                                @if ($detail->first()->status != 0 && $detail->first()->status != 9)
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity" class="icon-sm me-2"></i>
                                                                        <span class="">Activity Engineer</span></a>
                                                                @endif
                                                                <a class="dropdown-item d-flex align-items-center"
                                                                    href="#list-attach" data-bs-toggle="modal"><i
                                                                        data-feather="file" class="icon-sm me-2"></i>
                                                                    <span class="">Attachment</span></a>
                                                            @elseif($detail->first()->status == 10)
                                                                @if (!empty($detail->first()->full_name))
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity" class="icon-sm me-2"></i>
                                                                        <span class="">Activity Engineer</span></a>
                                                                @endif
                                                            @endif
                                                        @elseif($depart == 3 || $depart == 5)
                                                            @if ($detail->first()->status != 0 && $detail->first()->status != 9)
                                                                @if (!empty($detail->first()->full_name))
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="{{ url("Timeline/Engineer/Ticket=$id") }}"><i
                                                                            data-feather="activity" class="icon-sm me-2"></i>
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
                                                                                    <div class="col-md-6 mb-3">
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
                                                                                    <div class="col-md-6 mb-3">
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
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-label fw-bolder">
                                                                                            Incoming Email :
                                                                                        </p>
                                                                                        <div class="input-group flatpickr"
                                                                                            id="flatpickr-dt-ticket">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                placeholder="Select date"
                                                                                                name="ie_dt" id="dt-sch-en"
                                                                                                value="{{ $detail->first()->ticketcoming }}"
                                                                                                data-input required>
                                                                                            <span
                                                                                                class="input-group-text input-group-addon"
                                                                                                data-toggle><i
                                                                                                    data-feather="calendar"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
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
                                                                            <button type="button" class="btn btn-secondary"
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
                                            </div>
                                            @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @if (empty($detail->first()->full_name) ||
                                                                $detail->first()->type_ticket == 'Install' ||
                                                                $detail->first()->type_ticket == 'Deploy' ||
                                                                $detail->first()->type_ticket == 'Staging' ||
                                                                $detail->first()->type_ticket == 'Breakfix' ||
                                                                $detail->first()->type_ticket == 'Inventory' ||
                                                                $detail->first()->type_ticket == 'Deinstall' ||
                                                                $detail->first()->type_ticket == 'Delivery')
                                                            <form action="{{ url("Close/Ticket/$id") }}" method="post"
                                                                id="close-ticket-dt">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                            @if (in_array($detail->first()->type_ticket, ['Inventory', 'Delivery', 'Deploy']) && $role == 16)
                                                                <button type="button" class="btn btn-outline-primary btn-icon-text close-ticket-dt">
                                                                    <i class="btn-icon-prepend" data-feather="x-square"></i>
                                                                    Close Ticket
                                                                </button>
                                                            @endif
                                                            @if ($role == 19)
                                                                <button type="button" class="btn btn-outline-primary btn-icon-text close-ticket-dt">
                                                                    <i class="btn-icon-prepend" data-feather="x-square"></i>
                                                                    Close Ticket
                                                                </button>
                                                                <button type="button" class="btn btn-outline-warning btn-icon-text cancle-ticket-dt">
                                                                    Cancel Ticket
                                                                    <i class="btn-icon-append" data-feather="minus-square"></i>
                                                                </button>
                                                                <form action="{{ url("Ticket-Cancle/$id") }}"
                                                                    method="post" id="cancle-ticket-dt">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if ($detail->first()->status < 10)
                                                            @if ($detail->first()->status == 0)
                                                                @if (!empty($detail->first()->full_name))
                                                                    <button type="button"
                                                                        class="btn btn-outline-github btn-icon send-to-engineer"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Send Ticket to Engineer">
                                                                        <i data-feather="send"></i>
                                                                    </button>
                                                                    <form
                                                                        action="{{ url("Update/$id/Send-to/Engineer") }}"
                                                                        method="post"
                                                                        id="form-send-ticket-to-engineer">
                                                                        @csrf
                                                                        {{ method_field('patch') }}
                                                                    </form>
                                                                @endif
                                                            @elseif ($detail->first()->status == 9)
                                                                @php
                                                                    $url = url("Detail/Ticket=$id");
                                                                    $message = urlencode(
                                                                        "You have a new Ticket with No Ticket.$id\nClick link to open the page : ($url)",
                                                                    );
                                                                    $get_number = $detail->first()->phone_en;
                                                                    $phone = substr("$get_number", 1);
                                                                @endphp
                                                                <a href="https://wa.me/+62{{ $phone }}?text={{ $message }}"
                                                                    target="_blank">
                                                                    <button type="button"
                                                                        class="btn btn-outline-github btn-icon"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Send Reminder Link">
                                                                        <i data-feather="link"></i>
                                                                    </button>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
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
                                                            <p class="d-sm-block">&nbsp;AWB</p>
                                                        @else
                                                            <p class="d-sm-block">&nbsp;Ticket</p>
                                                        @endif
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="parts-tab" data-bs-toggle="tab"
                                                    data-bs-target="#parts" role="tab" aria-controls="parts"
                                                    aria-selected="true">
                                                    <div
                                                        class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                        <i data-feather="info"
                                                            class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                        <p class="d-sm-block">&nbsp;Parts
                                                            ( {{ $detail->first()->part_request }} )</p>
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
                                                                <p class="d-sm-block">&nbsp;Problem</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>
                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show active" id="chats" role="tabpanel"
                                                aria-labelledby="chats-tab">
                                                @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                    @if ($detail->first()->status < 10)
                                                        <div class="row mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <button type="button"
                                                                    class="btn btn-outline-github btn-icon-text"
                                                                    data-bs-toggle="modal" data-bs-target="#updt-info-ticket">
                                                                    Info Tiket
                                                                    <i class="btn-icon-append" data-feather="edit"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
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
                                                                                @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                                                    @if ($detail->first()->status < 10)
                                                                                        <button type="button"
                                                                                            class="btn btn-outline-github btn-icon change-engineer btn-xs"
                                                                                            data-bs-toggle="modal" data-bs-target="#engineer-change">
                                                                                            <i data-feather="edit-3"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                @endif
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
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="col-md-12 border-bottom-dt mb-2">
                                                                    <div class="row text-body fw-bolder">
                                                                        <div class="col-3">
                                                                            Schedule
                                                                        </div>
                                                                        <div class="col-1">
                                                                            :
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <div class="q-a">
                                                                                <div class="q-wrapper">
                                                                                    <div class="d-flex justify-content-between align-items-center"
                                                                                        style="cursor: pointer">
                                                                                        <p>
                                                                                            @if (empty(@$detail->first()->departure))
                                                                                                No Schedule
                                                                                            @else
                                                                                                {{ @$detail->first()->departure }}
                                                                                            @endif
                                                                                        </p>
                                                                                        <svg class="rotate-icon"
                                                                                            width="10" height="7"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path d="M1 .799l4 4 4-4"
                                                                                                stroke="#6571ff"
                                                                                                stroke-width="3"
                                                                                                fill="none"
                                                                                                fill-rule="evenodd" />
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($depart == 4)
                                                                                <div class="q-content mb-2 mt-1">
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-center">
                                                                                        <form
                                                                                            action="{{ url("Update-Ticket/Schedule/$id") }}"
                                                                                            method="post"
                                                                                            id="form-updt-sch-en">
                                                                                            @csrf
                                                                                            {{ method_field('patch') }}
                                                                                            @php
                                                                                                $sch = @$detail->first()
                                                                                                    ->departure;
                                                                                                $date = substr(
                                                                                                    "$sch",
                                                                                                    0,
                                                                                                    10,
                                                                                                );
                                                                                                $time = substr(
                                                                                                    "$sch",
                                                                                                    11,
                                                                                                );
                                                                                            @endphp
                                                                                            <div class="input-group flatpickr"
                                                                                                id="flatpickr-dt-ticket">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="Select date"
                                                                                                    name="sch_time_sch"
                                                                                                    id="dt-sch-en"
                                                                                                    value="{{ $sch }}"
                                                                                                    data-input required>
                                                                                                <span
                                                                                                    class="input-group-text input-group-addon"
                                                                                                    data-toggle><i
                                                                                                        data-feather="calendar"></i></span>
                                                                                            </div>
                                                                                        </form>
                                                                                        <button type="button"
                                                                                            class="btn btn-primary save-updt-sch-en">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
                                            <div class="tab-pane fade" id="parts" role="tabpanel"
                                                aria-labelledby="parts-tab">
                                                @if (
                                                    ($depart == 4 || $role == 20 || $role == 15) &&
                                                        $detail->first()->status < 10)
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <button type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Change Part Request"
                                                                class="btn btn-outline-github btn-icon change-part-reqs">
                                                                <i data-feather="refresh-ccw"></i>
                                                            </button>
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
                                                            @if (@$detail->first()->part_request == 'Yes')
                                                                <div class="d-flex align-items-center">
                                                                    <button type="button"
                                                                        class="btn btn-inverse-primary btn-icon-text"
                                                                        data-bs-toggle="modal" data-bs-target="#add-part">
                                                                        ADD
                                                                        Part
                                                                        <i class="btn-icon-append" data-feather="plus"></i>
                                                                    </button>
                                                                    &nbsp;
                                                                    <button type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Save Changes"
                                                                        class="btn btn-inverse-info btn-icon btn-sv-changes-part">
                                                                        <i data-feather="save"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal fade bd-example-modal-lg" id="add-part"
                                                                    tabindex="-1" aria-labelledby="sourceModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="sourceModalLabel">
                                                                                    Adding
                                                                                    Part
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="btn-close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                                                                    <div>
                                                                                        <h4 class="mb-md-0">Add Fields</h4>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center flex-wrap text-nowrap">
                                                                                        <button
                                                                                            class="btn btn-inverse-primary add-records-part-dt"
                                                                                            type="button" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="top" title="Add Fields"><i
                                                                                                class="btn-icon-append icon-lg"
                                                                                                data-feather="plus"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <form action="{{ url("Part/$id/Added") }}"
                                                                                    method="post" id="part-form">
                                                                                    @csrf
                                                                                    <div class="part-records-dt">
                                                                                        <div
                                                                                            class="d-flex justify-content-between align-items-center flex-wrap mb-3 record-parts-rmv-dt">
                                                                                            <u>
                                                                                                <h4 class="mb-md-0">Form</h4>
                                                                                            </u>
                                                                                        </div>
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-md-4">
                                                                                                <label for="choose-type-part"
                                                                                                    class="form-label">Status</label>
                                                                                                <select class="select2-part-dt form-select"
                                                                                                    data-width="100%" id="choose-type-part"
                                                                                                    name="status_part_updt[]">
                                                                                                    <option value="">
                                                                                                        - Select Status -
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label for="choose-ctgr" class="form-label">Category
                                                                                                    Part</label>
                                                                                                <select class="select2-part-dt form-select"
                                                                                                    data-width="100%" name="kat_part_dt[]"
                                                                                                    id="choose-ctgr">
                                                                                                    <option value="">- Choose -</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label for="choose-part-name" class="form-label">Part
                                                                                                    Name</label>
                                                                                                <input class="form-control" name="type_unit_updt[]"
                                                                                                    type="text" id="choose-part-name"
                                                                                                    placeholder="Type Unit">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-md-3">
                                                                                                <label for="input-so" class="form-label">SO
                                                                                                    Number</label>
                                                                                                <input id="input-so" class="form-control"
                                                                                                    name="so_num_updt[]" type="text"
                                                                                                    placeholder="SO Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label for="input-rma" class="form-label">RMA</label>
                                                                                                <input class="form-control" name="rma_part_updt[]"
                                                                                                    type="text" id="input-rma"
                                                                                                    placeholder="Type RMA Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label for="pn-2-dt" class="form-label">Part
                                                                                                    Number</label>
                                                                                                <input id="pn-2-dt" class="form-control"
                                                                                                    name="product_number_updt[]" type="text"
                                                                                                    placeholder="Sparepart Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label for="sn-2-dt" class="form-label">CT
                                                                                                    Number</label>
                                                                                                <input id="sn-2-dt" class="form-control"
                                                                                                    name="serial_number_updt[]" type="text"
                                                                                                    placeholder="CT Number">
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                    </div>
                                                                                    <div class="part-records-multiple-dt">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Back</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary store-part-dt">Save</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    <form
                                                        action="{{ url("Update/Part/$id") }}"
                                                        method="post" id="fm-dpl-changes-part">
                                                        @csrf
                                                        {{ method_field('patch') }}
                                                        <h5 class="mb-2 mb-md-0">Note* For duplicate the data please to fill Status Part</h5>
                                                        <select
                                                            class="js-example-basic-single form-select"
                                                            data-width="20%"
                                                            id="slt-dpl-sts-part"
                                                            name="val_sts_part_dpl">
                                                            <option value="">
                                                                -
                                                                Choose
                                                                -
                                                            </option>
                                                            @foreach ($type as $spt)
                                                                <option
                                                                    value="{{ $spt->id }}">
                                                                    {{ $spt->part_type }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                @endif
                                                        <div class="table-responsive mt-3">
                                                            <table id="display"
                                                                class="table table-bordered table-hover tbl-pdt">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 3%;">
                                                                        </th>
                                                                        <th style="width:5%">
                                                                            <i class="mdi mdi-content-duplicate"></i>
                                                                        </th>
                                                                        <th style="width:15%">
                                                                            Part
                                                                        </th>
                                                                        <th style="width:5%">
                                                                            Category
                                                                        </th>
                                                                        <th style="width:10%">
                                                                            Part
                                                                            Number
                                                                        </th>
                                                                        <th style="width:4%">
                                                                            CT Number
                                                                        </th>
                                                                        <th style="width:10%">
                                                                            SO
                                                                            Number
                                                                        </th>
                                                                        <th style="width:18%">
                                                                            RMA
                                                                        </th>
                                                                        <th style="width:5%">
                                                                            Type Parts
                                                                        </th>
                                                                        <th style="width:18%">
                                                                            Etimated
                                                                        </th>
                                                                        <th style="width:2%">
                                                                            Option
                                                                        </th>
                                                                        <th style="width:5%">
                                                                            Status
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $no = 1;
                                                                        if ($depart == 4) {
                                                                            $dsbl = "";
                                                                            $rdly = "";
                                                                        } else {
                                                                            $dsbl = "disabled";
                                                                            $rdly = "readonly";
                                                                        }
                                                                    @endphp
                                                                    @if (@$detail->first()->part_request == 'Yes')
                                                                        @foreach ($tiket_part as $item)
                                                                            <tr>
                                                                                <td>
                                                                                    @if ($depart == 4)
                                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                                            data-bs-placement="top" title="Delete Part"
                                                                                            class="btn btn-outline-danger btn-icon btn-xs btn-dstr-list-part"
                                                                                            data-val-idpt="{{ $item->id }}"
                                                                                            data-val-ntkt="{{ $id }}">
                                                                                            <i data-feather="minus"></i>
                                                                                        </button>
                                                                                    @else
                                                                                    Null
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input"
                                                                                        value="1"
                                                                                        name="clone_pdt[{{ $item->id }}]" {{$dsbl}}>
                                                                                </td>
                                                                                <td>
                                                                                    <input value="{{ $item->unit_name }}"
                                                                                        name="un_pdt[{{ $item->id }}]"
                                                                                        class="form-control" type="text" {{$rdly}}>
                                                                                </td>
                                                                                <td>
                                                                                    <select
                                                                                        class="js-example-basic-single form-select"
                                                                                        data-width="100%"
                                                                                        name="slc_ctgr_pdt[{{ $item->id }}]" {{$dsbl}}>
                                                                                        <option value="">
                                                                                            -
                                                                                            Category
                                                                                            -
                                                                                        </option>
                                                                                        @foreach ($ctgr_part as $ctgr)
                                                                                            <option
                                                                                                value="{{ $ctgr->id }}"
                                                                                                {{ $ctgr->type_name == $item->type_name ? 'selected' : '' }}>
                                                                                                {{ $ctgr->type_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input value="{{ $item->pn }}"
                                                                                        class="form-control"
                                                                                        name="pn_pdt[{{ $item->id }}]"
                                                                                        type="text" {{$rdly}}>
                                                                                </td>
                                                                                <td>
                                                                                    <input value="{{ $item->sn }}"
                                                                                        class="form-control"
                                                                                        name="sn_pdt[{{ $item->id }}]"
                                                                                        type="text" {{$rdly}}>
                                                                                </td>
                                                                                <td>
                                                                                    <input value="{{ $item->so_num }}"
                                                                                        class="form-control"
                                                                                        name="so_pdt[{{ $item->id }}]"
                                                                                        type="text" {{$rdly}}>
                                                                                </td>
                                                                                <td>
                                                                                    <input value="{{ $item->rma }}"
                                                                                        class="form-control"
                                                                                        name="rma_pdt[{{ $item->id }}]"
                                                                                        type="text" {{$rdly}}>
                                                                                </td>
                                                                                <td>
                                                                                    <select
                                                                                        class="js-example-basic-single form-select"
                                                                                        data-width="100%"
                                                                                        name="pt_pdt[{{ $item->id }}]" {{$dsbl}}>
                                                                                        <option value="">
                                                                                            -
                                                                                            Status
                                                                                            -
                                                                                        </option>
                                                                                        @foreach ($type as $typ)
                                                                                            <option
                                                                                                value="{{ $typ->id }}"
                                                                                                {{ $typ->part_type == $item->part_type ? 'Selected' : '' }}>
                                                                                                {{ $typ->part_type }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div
                                                                                            class="input-group flatpickr fpck-eta-parts">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                placeholder="Select date"
                                                                                                name="eta_pdt[{{ $item->id }}]"
                                                                                                value="{{ $item->eta }}"
                                                                                                data-input required {{$rdly}}>
                                                                                            <span
                                                                                                class="input-group-text input-group-addon"
                                                                                                data-toggle><i
                                                                                                    data-feather="calendar"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    @if ($depart == 4)
                                                                                        @if ($item->status == 2 || $item->sts_type == 1)
                                                                                            {{ $item->sts_type == 1 ? '-' : 'No Action Needed' }}
                                                                                        @else
                                                                                            <button type="button"
                                                                                                data-bs-toggle="tooltip"
                                                                                                data-bs-placement="top"
                                                                                                title="Part Trip"
                                                                                                class="btn btn-inverse-info btn-icon btn-sm btn-update-journey"
                                                                                                data-idk="{{ $item->id }}"
                                                                                                data-notik="{{ $id }}"
                                                                                                data-trpt="{{ $item->status }}">
                                                                                                <i
                                                                                                    data-feather="truck"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    @else
                                                                                    Null
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $item->sts_type == 1 ? 'Replaced' : $item->sts_journey }}
                                                                                </td>
                                                                            </tr>
                                                                            @php
                                                                                $no++;
                                                                            @endphp
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </form>
                                            </div>
                                            @if ($depart != 9)
                                                @if (!empty($validate_problem))
                                                    <div class="tab-pane fade" id="Problem" role="tabpanel"
                                                        aria-labelledby="calls-tab">
                                                        @if (($depart == 4 && ($role == 19 || $role == 16)) || $role == 20 || $role == 15)
                                                            @if ($detail->first()->status < 10)
                                                                @if (!empty($validate_problem))
                                                                    <div class="row mb-3">
                                                                        <button type="button" class="btn btn-outline-github btn-icon-text"
                                                                            data-bs-toggle="modal" data-bs-target="#updt-unit-tkt">
                                                                            <i class="btn-icon-prepend" data-feather="edit"></i>
                                                                            Edit Unit
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
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
        @if ($depart == 4 || $role == 20 || $role == 15 || $role == 19 || $depart == 3)
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
                                        @if ($detail->first()->status != 10 && $depart == 4)
                                            <button type="button" class="btn btn-outline-github btn-icon-text"
                                                data-bs-toggle="modal" data-bs-target="#add-note">
                                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                                Add Note
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="display" class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th></th>
                                                    <th>
                                                        Activity</th>
                                                    <th>
                                                        Pending</th>
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
                                                    @php
                                                        $profile = @$item->get_user->profile;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$no}}</td>
                                                        <td>
                                                            @if ($depart == 4)
                                                                @if ($item->type_log != 1)
                                                                    <form
                                                                        action="{{ url("Duplicate/$item->id/Note") }}"
                                                                        method="post"
                                                                        id="fm-dpl-note-{{ $no }}">
                                                                        @csrf
                                                                    </form>
                                                                    <button type="button"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Clone Note"
                                                                        data-dplnt-ids="{{ $no }}"
                                                                        class="btn btn-inverse-info btn-icon btn-sm btn-dpl-note">
                                                                        <i class="mdi mdi-content-duplicate"></i>
                                                                    </button>
                                                                @else
                                                                    By System
                                                                @endif
                                                            @else
                                                                No Action
                                                            @endif
                                                        </td>
                                                        <td>{{ @$item->typeNote->ktgr_name }}</td>
                                                        <td>
                                                            {{ @$item->typePending->ktgr_pending }}
                                                        </td>
                                                        <td>{!! $item->note !!}</td>
                                                        <td>
                                                            @if ($depart == 4)
                                                                <img class="rounded-circle profile-user"
                                                                    src="{{ asset("$profile") }}" alt="profile">
                                                                <br>
                                                            @endif
                                                            {{ @$item->get_user->full_name }}
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
                                                                                                        <div
                                                                                                            class="row">
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
                                                                                                                        class="js-example-basic-single form-select"
                                                                                                                        data-width="100%"
                                                                                                                        id="choose-type-note"
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
                                    </div>
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
                                                                    <div id="ntGroup">
                                                                        <label for="input-desc-note"
                                                                            class="form-label fw-bolder">Description:</label>
                                                                        <textarea class="form-control txt-note" rows="3" id="input-desc-note"
                                                                            placeholder="Click the 'Record' button and speak" name="log_note"></textarea>
                                                                        <button id="recordButton"><i
                                                                                class="mdi mdi-microphone-outline"></i></button>
                                                                    </div>
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
    <script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
    <script src="{{ asset('assets') }}/js/chat.js"></script>
@endpush
@push('custom')
    <script>
        $(document).ready(function() {
            // Initial Ajax request to fetch data and populate original records
            $.ajax({
                url: '{{ route('fetch.select') }}',
                method: 'GET',
                success: function(data) {
                    // Update the options in the original records
                    updateOptions($('.part-records-dt .select2-part-dt:eq(0)'), data.types, 'part_type');
                    updateOptions($('.part-records-dt .select2-part-dt:eq(1)'), data.categories, 'type_name');

                    // Use event delegation to handle the 'select2:open' event for dynamically added elements
                    $(document).on('select2:open', '.select2-part-dt', function() {
                        setTimeout(function() {
                            $('.select2-search__field').get(0).focus();
                        }, 0);
                    });
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });

            // Event listener for Add Records button
            $('.add-records-part-dt').click(function() {
                // Clone the original records
                var clonedRecords = $('<div class="part-records-dt">' + $('.part-records-dt').html() +
                    '</div>');;

                clonedRecords.find('.select2-part-dt').each(function() {
                    $(this).next('.select2-container').remove();
                });
                // Append remove button
                clonedRecords.find('.record-parts-rmv-dt').append(
                    '<button class="btn btn-outline-danger btn-icon btn-md remove-parts-fields-dt" type="button"><i class="btn-icon-append" data-feather="minus"></i></button>'
                );
                // Append the cloned records to the container
                $('.part-records-multiple-dt').append(clonedRecords);

                // Initialize Select2 for the new records
                $('.part-records-multiple-dt .select2-part-dt').select2({
                    dropdownParent: $(this).parent()
                });

                feather.replace();
            });

            // Function to update options in a select element
            function updateOptions(selectElement, data, columnName) {
                // Clear existing options
                selectElement.empty();

                // Add new options
                selectElement.append('<option value="">- Select -</option>');
                $.each(data, function(index, item) {
                    selectElement.append('<option value="' + item.id + '">' + item[columnName] +
                        '</option>');
                });
            }
            $(document).on('click', '.remove-parts-fields-dt', function() {
                $(this).closest('.part-records-dt').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.fpck-eta-parts').each(function() {
                flatpickr(this, {
                    wrap: true,
                    enableTime: true,
                    dateFormat: "Y-m-d",
                    time_24hr: true
                });
            });
        });
    </script>
    <script>
        $('.btn-dpl-note').each(function(index) {
            $(this).on('click', function() {
                var vds = $(this).data('dplnt-ids');
                var fmdplNT = $('#fm-dpl-note-' + vds);

                Swal.fire({
                    title: "Duplicate this note?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fmdplNT.submit();
                    }
                });
                return false;
            });
        });
        $('.btn-sv-changes-part').on('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var partType = document.getElementById('slt-dpl-sts-part').value;

            // Check if at least one checkbox is checked
            if (checkboxes.length >= 1) {
                // Check if partType is not selected
                if (partType === "") {
                    Swal.fire({
                        title: "Select the Status Part!!",
                        text: "If checkbox for clones is checked, please choose status part!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else {
                    Swal.fire({
                        title: "Continue this action??",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#fm-dpl-changes-part').submit();
                        }
                    });
                    return false;
                }
            } else {
                Swal.fire({
                    title: "Continue this action??",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#fm-dpl-changes-part').submit();
                    }
                });
                return false;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.q-wrapper').click(function() {
                $(this).toggleClass('active');
                $(this).next('.q-content').slideToggle();
            });
        });
    </script>
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
            var cek_pt = '{{ @$cek_part->cpt }}';
            $('.send-to-engineer').on('click', function() {
                if (cek_pt == 1) {
                    Swal.fire({
                        title: "Part Not Ready!!",
                        text: "Update your part status!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
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
                }
                return false;
            });
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
        <script>
            $('.btn-dstr-list-part').each(function(index) {
                $(this).on('click', function() {
                    var idpt = $(this).data('val-idpt');
                    var ntkt = $(this).data('val-ntkt');
                    
                    var fmDstr = 'fm_dstr' + idpt;

                    $('#' + fmDstr).remove();

                    var apndFM = $('<form>').attr({
                        id: fmDstr,
                        method: 'POST', 
                        action: '{{ route("dstr.part", ["id" => ":id", "notiket" => ":notiket"]) }}'.replace(':id', idpt).replace(':notiket', ntkt),
                        style: 'display: none;' 
                    });

                    // CSRF
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $('<input>').attr({
                        type: 'hidden',
                        name: '_token',
                        value: token
                    }).appendTo(apndFM);
                    // DELETE
                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    }).appendTo(apndFM);

                    apndFM.appendTo('body');
                    
                    Swal.fire({
                        title: "Sure want to Delete?",
                        icon: 'warning',
                        showCancelButton: false,
                        showDenyButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Yes',
                        denyButtonColor: '#d33',
                        denyButtonText: "No"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            apndFM.submit();
                        }
                    });
                    return false;

                    apndFM.remove();
                });
            });

            $('.btn-update-journey').each(function(index) {
                $(this).on('click', function() {
                    var ids = $(this).data('idk');
                    var notik = $(this).data('notik');
                    var trippt = $(this).data('trpt');
                    
                    var formId = 'fm_journey' + ids;

                    $('#' + formId).remove();

                    var form = $('<form>').attr({
                        id: formId,
                        method: 'POST', 
                        action: '{{ route("trip.part", ["id" => ":id"]) }}'.replace(':id', ids),
                        style: 'display: none;' 
                    });

                    // CSRF
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $('<input>').attr({
                        type: 'hidden',
                        name: '_token',
                        value: token
                    }).appendTo(form);
                    // PATCH
                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'PATCH'
                    }).appendTo(form);
                    // Notiket Input
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'log_part_notik',
                        value: notik
                    }).appendTo(form);

                    form.appendTo('body');
                    
                    if (trippt === 0) {
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
                            form.submit();
                        }
                    });
                    return false;

                    form.remove();
                });
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
        </script>
    @endif
    @if (session('whatsapp_link_1'))
        <script>
            const whatsappLink1 = "{{ session('whatsapp_link_1') }}";

            window.open(whatsappLink1, '_blank');
        </script>
    @endif
    <script>
        const textarea = document.getElementById('input-desc-note');
        const recordButton = document.getElementById('recordButton');
        let recognition;

        // Check if SpeechRecognition is available
        if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();

            // Set language to Indonesian (id-ID)
            recognition.lang = 'id-ID';

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                textarea.value += transcript + ' ';
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error', event.error);
            };

            recognition.onend = () => {
                console.log('Speech recognition ended');
                // Change the button style when recording ends
                recordButton.classList.remove('recording');
            };

            // Toggle recording when the button is clicked
            recordButton.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent form submission
                if (recognition && recognition.recognizing) {
                    recognition.stop();
                } else {
                    recognition.start();
                    // Change the button style when recording starts
                    recordButton.classList.add('recording');
                }
            });

        } else {
            console.error('Speech recognition not supported in this browser');
        }
    </script>
@endpush
