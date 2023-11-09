@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/jquery-tags-input/jquery.tagsinput.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/pickr/themes/classic.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Form</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Ticket</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row position-relative">
                            <div class="col-lg-12 chat-aside">
                                <div class="aside-content">
                                    <div class="aside-header">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h6 class="card-title mb-0">
                                                <span class="input-group-text">
                                                    Page Manage Ticket
                                                </span>
                                            </h6>
                                            <div class="dropdown">
                                                <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-xl text-muted pb-3px" data-feather="settings"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ url('helpdesk/form=Ticket') }}"><i data-feather="eye"
                                                            class="icon-lg me-2"></i> <span class="">Page
                                                            View</span></a>
                                                    <a class="dropdown-item d-flex align-items-center create"
                                                        href="javascript:;"><i data-feather="save" class="icon-lg me-2"></i>
                                                        <span class="">Create Ticket</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="forms-sample" action="{{ url('Create/Ticket-HGT') }}" method="post"
                                        id="create_ticket" enctype="multipart/form-data">
                                        @csrf
                                        <div class="aside-body">
                                            <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="chats-tab" data-bs-toggle="tab"
                                                        data-bs-target="#ticket-info" role="tab" aria-controls="chats"
                                                        aria-selected="true">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="bookmark"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-none d-sm-block">Ticket Info</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="calls-tab" data-bs-toggle="tab"
                                                        data-bs-target="#project-info" role="tab" aria-controls="calls"
                                                        aria-selected="false">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="file-text"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-none d-sm-block">Project Info</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="contacts-tab" data-bs-toggle="tab"
                                                        data-bs-target="#engineer-info" role="tab"
                                                        aria-controls="contacts" aria-selected="false">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="file-text"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-none d-sm-block">Engineer</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content mt-3">
                                                <div class="tab-pane fade show active" id="ticket-info" role="tabpanel"
                                                    aria-labelledby="chats-tab">
                                                    <div class="row">
                                                        <div class="col-md-4 border-end-lg">
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <label for="reference" class="form-label">Reference
                                                                        ID</label>
                                                                    <input id="reference" class="form-control"
                                                                        name="reference_id" type="text"
                                                                        placeholder="Type Reference ID">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="date_come" class="form-label">Incoming
                                                                        Ticket</label>
                                                                    <div class="input-group flatpickr"
                                                                        id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select Date" name="date_come"
                                                                            id="flatpickr-date-validate" data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i
                                                                                data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="time_come" class="form-label">Time
                                                                        Picker</label>
                                                                    <div class="input-group flatpickr"
                                                                        id="flatpickr-time">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select time" name="time_come"
                                                                            id="flatpickr-time-validate" data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i data-feather="clock"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Source</label>
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="source_id"
                                                                        id="id-source">
                                                                        <option value="">- Choose -</option>
                                                                        @foreach ($src as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->sumber_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <label for="sla_1" class="form-label">SLA</label>
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="sla" id="id-sla">
                                                                        <option value="">
                                                                            -
                                                                            Choose -</option>
                                                                        @foreach ($sla as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->sla_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">SLA</label><br>
                                                                    <input type="button" class="btn btn-inverse-primary"
                                                                        name="sla" value="Add SLA"
                                                                        data-bs-toggle="modal" data-bs-target="#slaModal">
                                                                    <div class="modal fade bd-example-modal-lg"
                                                                        id="slaModal" tabindex="-1"
                                                                        aria-labelledby="slaModalLabel" aria-hidden="true"
                                                                        data-bs-backdrop="static">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="slaModalLabel">Adding SLA
                                                                                        to Project
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="btn-close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label for="sla_1"
                                                                                                    class="form-label">SLA</label>
                                                                                                <select
                                                                                                    class="js-example-basic-single form-select"
                                                                                                    data-width="100%"
                                                                                                    name="sla"
                                                                                                    id="id-sla">
                                                                                                    <option value="">
                                                                                                        -
                                                                                                        Choose -</option>
                                                                                                    @foreach ($sla as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->id }}">
                                                                                                            {{ $item->sla_name }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-success"
                                                                                        data-bs-dismiss="modal">Done</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="card-title">Problem Info</h4>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="group" class="col-form-label">
                                                                        Type Problem
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <fieldset id="problem-type" style="margin-top: 8px;">
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="1" name="type_problem"
                                                                                id="tp_blem1">
                                                                            <label class="form-check-label"
                                                                                for="tp_blem1">
                                                                                Software
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="2" name="type_problem"
                                                                                id="tp_blem2">
                                                                            <label class="form-check-label"
                                                                                for="tp_blem2">
                                                                                Hardware
                                                                            </label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig" class="col-form-label">Merk
                                                                        Unit</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="merk_id" id="merk-u-id">
                                                                        <option value="">- Choose -</option>
                                                                        @foreach ($merk as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->merk }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig"
                                                                        class="col-form-label">Category
                                                                        Unit</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="ctgrpi_id"
                                                                        id="ctgr-cu-id">
                                                                        <option value="">- Choose -</option>
                                                                        @foreach ($ctgru as $item)
                                                                            <option value="{{ $item->category_id }}">
                                                                                {{ $item->category_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig" class="col-form-label">Unit
                                                                        Type</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <select
                                                                                class="js-example-basic-single form-select"
                                                                                data-width="100%" name="type_id"
                                                                                id="unit-type-id">
                                                                                <option value="">- Choose Type -
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <button class="btn btn-inverse-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#unitTypeModal"
                                                                                type="button"><i
                                                                                    class="btn-icon-append icon-lg"
                                                                                    data-feather="plus"></i></button>
                                                                            <div class="modal fade" id="unitTypeModal"
                                                                                tabindex="-1"
                                                                                aria-labelledby="slaModalLabel"
                                                                                aria-hidden="true"
                                                                                data-bs-backdrop="static">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="slaModalLabel">Add New
                                                                                                Type Unit
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="btn-close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            for="sla_1"
                                                                                                            class="form-label">Type
                                                                                                            Unit</label>
                                                                                                        <input
                                                                                                            id="type-unit-optional"
                                                                                                            class="form-control"
                                                                                                            name="type_unit_adding"
                                                                                                            type="text"
                                                                                                            placeholder="Type Unit">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-success"
                                                                                                data-bs-dismiss="modal">Done</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3"><br>
                                                                    <label for="defaultconfig" class="col-form-label">Unit
                                                                        Key</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="user"
                                                                                class="form-label">SN</label>
                                                                            <input id="sn" class="form-control"
                                                                                name="sn_unit" type="text"
                                                                                placeholder="Type Serial Number">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="user"
                                                                                class="form-label">PN</label>
                                                                            <input id="pn" class="form-control"
                                                                                name="pn_unit" type="text"
                                                                                placeholder="Type Product Number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="group" class="col-form-label">
                                                                        Warranty
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <fieldset id="warranty-choose"
                                                                        style="margin-top: 8px;">
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="1" name="warranty"
                                                                                id="warranty1">
                                                                            <label class="form-check-label"
                                                                                for="warranty1">
                                                                                Yes
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="0" name="warranty"
                                                                                id="warranty2">
                                                                            <label class="form-check-label"
                                                                                for="warranty2">
                                                                                No
                                                                            </label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig-4"
                                                                        class="col-form-label">Problem</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <textarea id="maxlength-textarea" class="form-control" name="problematika" maxlength="100" rows="2"
                                                                        placeholder="Type Problem"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig-4"
                                                                        class="col-form-label">Action
                                                                        Plan</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <textarea id="maxlength-textarea" class="form-control" name="action_plan" maxlength="100" rows="2"
                                                                        placeholder="Type Solution"></textarea>
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <input type="file" class="file"
                                                                                name="file[]" multiple
                                                                                onchange="showClearButton()">
                                                                        </div>
                                                                        <div class="col-md-2 text-center">
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger btn-icon btn-xs file-clear"
                                                                                style="display:none"
                                                                                onclick="clearFileInput()">
                                                                                <i data-feather="x"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-3">
                                                                    <label for="defaultconfig-4"
                                                                        class="col-form-label">Part Request</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <fieldset id="rqs-part-validate"
                                                                        style="margin-top: 8px;"
                                                                        onChange="modalPart(this.value)">
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="1" name="part_reqs"
                                                                                id="reqs1">
                                                                            <label class="form-check-label"
                                                                                for="reqs1">
                                                                                Yes
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio" class="form-check-input"
                                                                                value="0" name="part_reqs"
                                                                                id="reqs2">
                                                                            <label class="form-check-label"
                                                                                for="reqs2">
                                                                                No
                                                                            </label>
                                                                        </div>
                                                                    </fieldset>
                                                                    <div class="modal fade bd-example-modal-lg"
                                                                        data-bs-backdrop="static" id="find-part"
                                                                        tabindex="-1" aria-labelledby="partModal"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="slaModalLabel">Part Detail
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="btn-close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-md-6">
                                                                                                <label for="date_mail"
                                                                                                    class="form-label">Status</label>
                                                                                                <select
                                                                                                    class="js-example-basic-single form-select"
                                                                                                    data-width="100%"
                                                                                                    id="part-status"
                                                                                                    name="status_part">
                                                                                                    <option value="">
                                                                                                        - Select Status -
                                                                                                    </option>
                                                                                                    @foreach ($type as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->id }}">
                                                                                                            {{ $item->part_type }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="date_mail"
                                                                                                    class="form-label">Part
                                                                                                    Name</label>
                                                                                                <input class="form-control"
                                                                                                    name="type_unit"
                                                                                                    type="text"
                                                                                                    id="part-name-detail"
                                                                                                    placeholder="Type Unit">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-md-3">
                                                                                                <label for="date_mail"
                                                                                                    class="form-label">SO
                                                                                                    Number</label>
                                                                                                <input id="reqs-part"
                                                                                                    class="form-control"
                                                                                                    name="so_num"
                                                                                                    type="text"
                                                                                                    placeholder="SO Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label
                                                                                                    class="form-label">RMA</label>
                                                                                                <input class="form-control"
                                                                                                    name="rma_num"
                                                                                                    type="text"
                                                                                                    id="rma-part"
                                                                                                    placeholder="Type RMA Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label for="date_mail"
                                                                                                    class="form-label">Sparepart
                                                                                                    Number</label>
                                                                                                <input id="pn-2"
                                                                                                    class="form-control"
                                                                                                    name="product_number"
                                                                                                    type="text"
                                                                                                    placeholder="Sparepart Number">
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <label for="time_mail"
                                                                                                    class="form-label">CT
                                                                                                    Number</label>
                                                                                                <input id="sn-2"
                                                                                                    class="form-control"
                                                                                                    name="serial_number"
                                                                                                    type="text"
                                                                                                    placeholder="CT Number">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-success"
                                                                                        data-bs-dismiss="modal">Done</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="project-info" role="tabpanel"
                                                    aria-labelledby="calls-tab">
                                                    <div class="row mb-2">
                                                        <div class="col-md-6 border-end-lg">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Partner</label>
                                                                    <select class="js-example-basic-single form-select"
                                                                        data-width="100%" name="partner_id"
                                                                        id="partner-select">
                                                                        <option value="">- Choose -</option>
                                                                        @foreach ($partner as $item)
                                                                            <option value="{{ $item->partner_id ?? '' }}">
                                                                                {{ $item->partner ?? '' }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="form-label">Project Name</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" id="project-id"
                                                                            name="project_id" style="display: none;">
                                                                        <input type="text" class="form-control"
                                                                            id="project-name" placeholder="Choose Project"
                                                                            aria-label="Choose Project"
                                                                            aria-describedby="basic-addon2" readonly>
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-inverse-primary"
                                                                                type="button" data-bs-toggle="modal"
                                                                                data-bs-target="#find-project"><i
                                                                                    class="btn-icon-append icon-lg"
                                                                                    data-feather="search"></i></button>
                                                                            <button
                                                                                class="btn btn-inverse-primary clear-prj"
                                                                                type="button"><i
                                                                                    class="btn-icon-append icon-lg"
                                                                                    data-feather="x"></i></button>
                                                                            <div class="modal fade bd-example-modal-xl"
                                                                                id="find-project" tabindex="-1"
                                                                                aria-labelledby="projectModal"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="projectModal">
                                                                                                Find & select Project
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="btn-close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="table-responsive">
                                                                                                <table id="display"
                                                                                                    class="table">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>No</th>
                                                                                                            <th>Project
                                                                                                                ID</th>
                                                                                                            <th>Project
                                                                                                                Name</th>
                                                                                                            <th>Partner</th>
                                                                                                            <th>Contact
                                                                                                                Person
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Description
                                                                                                            </th>
                                                                                                            <th>Option
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody
                                                                                                        id="project-data">
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
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="ageSelect" class="form-label">User
                                                                        Detail</label>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-text"
                                                                                name="sla" id="add-cust-dt"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#cnydt">Add Detail
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade bd-example-modal-lg"
                                                                        id="cnydt" tabindex="-1"
                                                                        aria-labelledby="varyingModalLabel"
                                                                        aria-hidden="true" data-bs-backdrop="static">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="varyingModalLabel">Adding User
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label for="company"
                                                                                                    class="form-label">Company
                                                                                                    :</label>
                                                                                                <input type="text"
                                                                                                    name="company_name"
                                                                                                    id="name-company"
                                                                                                    class="form-control"
                                                                                                    placeholder="Company name"
                                                                                                    aria-label="Company name"
                                                                                                    aria-describedby="basic-addon2">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label for="company"
                                                                                                    class="form-label">Type
                                                                                                    Company
                                                                                                    :</label>
                                                                                                <select
                                                                                                    class="js-example-basic-single form-select"
                                                                                                    data-width="100%"
                                                                                                    id="type-kantor"
                                                                                                    name="type_kantor">
                                                                                                    <option value="">
                                                                                                        -
                                                                                                        Select Option -
                                                                                                    </option>
                                                                                                    @foreach ($office_type as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->office_type_id ?? '' }}">
                                                                                                            {{ $item->name_type ?? '' }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            for="cust_name"
                                                                                                            class="form-label">Contact
                                                                                                            Name
                                                                                                            :</label>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            class="form-control"
                                                                                                            name="contact_name"
                                                                                                            id="name-contact"
                                                                                                            placeholder="Contact Name">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col">
                                                                                                <div class="mb-3">
                                                                                                    <label for="severity_4"
                                                                                                        class="form-label">Address
                                                                                                        :</label>
                                                                                                    <blade
                                                                                                        ___html_tags_2___ />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            class="form-label">Provinsi</label>
                                                                                                        <select
                                                                                                            class="js-example-basic-single form-select"
                                                                                                            data-width="100%"
                                                                                                            name="provinces"
                                                                                                            id="provinces">
                                                                                                            <option
                                                                                                                value="">
                                                                                                                -
                                                                                                                Select
                                                                                                                Option -
                                                                                                            </option>
                                                                                                            @foreach ($province as $item)
                                                                                                                <option
                                                                                                                    value="{{ $item->id ?? '' }}">
                                                                                                                    {{ $item->name ?? '' }}
                                                                                                                </option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            class="form-label">Kabupaten</label>
                                                                                                        <select
                                                                                                            class="js-example-basic-single form-select"
                                                                                                            data-width="100%"
                                                                                                            name="cities"
                                                                                                            id="cities-select">
                                                                                                            <option
                                                                                                                value="">
                                                                                                                -
                                                                                                                Select
                                                                                                                Option -
                                                                                                            </option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            class="form-label">Phone
                                                                                                            :</label>
                                                                                                        <input
                                                                                                            class="form-control mb-4 mb-md-0"
                                                                                                            name="phone_cust"
                                                                                                            id="phone-validate"
                                                                                                            data-inputmask-alias="(+62) 999-9999-9999" />
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="mb-3">
                                                                                                        <label
                                                                                                            class="form-label">Email
                                                                                                            :</label>
                                                                                                        <input
                                                                                                            class="form-control mb-4 mb-md-0"
                                                                                                            name="email_cust"
                                                                                                            id="email-validate"
                                                                                                            data-inputmask="'alias': 'email'" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <label for="severity_3"
                                                                                                        class="form-label">Location:</label>
                                                                                                    <select
                                                                                                        class="js-example-basic-single form-select"
                                                                                                        data-width="100%"
                                                                                                        id="severity-validate"
                                                                                                        name="severity">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            -
                                                                                                            Choose -
                                                                                                        </option>
                                                                                                        @foreach ($severity as $item)
                                                                                                            <option
                                                                                                                value="{{ $item->id }}">
                                                                                                                {{ $item->severity_name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-success"
                                                                                        data-bs-dismiss="modal">Done</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="engineer-info" role="tabpanel"
                                                    aria-labelledby="contacts-tab">

                                                    <div class="mb-3">
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Service Point</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    name="servp" id="servp" data-width="100%">
                                                                    <option value="">- Choose Option -</option>
                                                                    @foreach ($sp as $item)
                                                                        <option value="{{ $item->service_id }}">
                                                                            {{ $item->service_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for='engineer' class='form-label'>Engineer</label>
                                                                <select class='js-example-basic-single form-select'
                                                                    data-width='100%' name="engineer" id="engineer">
                                                                    <option value="">- Choose Option -</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <label for="schedule"
                                                                        class="form-label">Schedule</label>
                                                                    <div class="input-group flatpickr"
                                                                        id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select date" name="sch"
                                                                            id="sch-dt-validate" data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i
                                                                                data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="time_mail" class="form-label">Time
                                                                    Picker Schedule</label>
                                                                <div class="input-group flatpickr" id="flatpickr-time">
                                                                    <input type="text" class="form-control"
                                                                        id="sch-tm-validate" placeholder="Select time"
                                                                        name="time_schedule" data-input>
                                                                    <span class="input-group-text input-group-addon"
                                                                        data-toggle><i data-feather="clock"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/dropzone/dropzone.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/form-validation.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-maxlength.js"></script>
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
    <script src="{{ asset('assets') }}/js/typeahead.js"></script>
    <script src="{{ asset('assets') }}/js/tags-input.js"></script>
    <script src="{{ asset('assets') }}/js/dropify.js"></script>
@endpush
@push('custom')
    <script>
        function typeUnit(url, ctgrpi_id, merk_id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    ctgrpi_id: ctgrpi_id,
                    merk_id: merk_id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + name).empty();
                    $('#' + name).append('<option value="">- Choose Type -</option>');
                    $.each(data, function(key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function() {
            $('#ctgr-cu-id, #merk-u-id').on('change', function() {
                if ($("#ctgr-cu-id").val() != "" && $("#merk-u-id").val() != "") {
                    typeUnit('{{ route('typeunit') }}', $("#ctgr-cu-id").val(), $("#merk-u-id").val(),
                        'unit-type-id');
                }
            });
        });
    </script>
    <script>
        function getProjectsByPartner(url, partner_id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    partner_id: partner_id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + name).empty();
                    let no = 0;
                    $.each(data, function(key, value) {
                        no++;
                        $('#' + name).append('<tr><td>' + no + '</td><td>' + value.project_id +
                            '</td><td>' + value.project_name + '</td><td>' + value.go_partner
                            .partner +
                            '</td><td>' + value.contact_person + '</td><td>' + value.desc +
                            '</td><td>' +
                            "<button type='button' class='btn btn-inverse-info btn-icon btn-sm select-project'><i data-feather='mouse-pointer'></i></button>" +
                            '</td></tr>');
                    });
                    feather.replace();
                    setTimeout(function() {
                        $('#find-project').modal('show')
                    }, 200);
                }
            });
        }
        $(document).ready(function() {
            $('#partner-select').on('change', function() {
                if ($("#partner-select").val() != "") {
                    getProjectsByPartner('{{ route('getProjectsByPartner') }}', $("#partner-select").val(),
                        'project-data');
                }
            });
        });
    </script>
    <script>
        function onChangeSelect(url, id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + name).empty();
                    $('#' + name).append('<option value="">- Select Option -</option>');

                    $.each(data, function(key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function() {
            $('#provinces').on('change', function() {
                onChangeSelect('{{ route('cities') }}', $(this).val(), 'cities-select');
            });
        });
    </script>
    <script>
        function engineer(url, id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + name).empty();
                    $('#' + name).append('<option value="">- Choose Option -</option>');
                    $.each(data, function(key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function() {
            $('#servp').on('change', function() {
                engineer('{{ route('engineer') }}', $(this).val(), 'engineer');
            });
        });
    </script>
@endpush
