@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/jquery-tags-input/jquery.tagsinput.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/dropzone/dropzone.min.css">
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
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline sv-tc">
                            <h6 class="card-title mb-0">
                                <span class="input-group-text">
                                    Page Manage Ticket
                                </span>
                            </h6>
                            <a class="cta create" href="javascript:;">
                                <span>Save</span>
                                <span>
                                    <svg width="33px" height="18px" viewBox="0 0 66 43" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="arrow" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <path class="one"
                                                d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                            <path class="two"
                                                d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                            <path class="three"
                                                d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="forms-sample" action="{{ url('Create/Ticket-HGT') }}" method="post" id="create_ticket"
            enctype="multipart/form-data">
            @csrf
            <input class="form-control" name="how_many" type="number" id="many-tickets" style="display: none;">
            <div class="row position-relative">
                <div class="col grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4 class="card-title text-center">Ticket Info</h4>
                                <div class="row align-center">
                                    <div class="col-md-1">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <label for="reference" class="form-label">Type Ticket</label>
                                            <a href="#" id="refresh-type-ticket">
                                                <i class="icon-sm" data-feather="rotate-cw"></i>
                                            </a>
                                        </div>
                                        <select class="js-example-basic-single form-select" data-width="100%"
                                            name="type_ticket" id="type-ticket">
                                            <option value="">- Choose -</option>
                                            @foreach ($type_ticket as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="reference" class="form-label">Reference
                                            ID</label>
                                        <input id="reference" class="form-control" name="reference_id" type="text"
                                            placeholder="Type Reference ID">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date_come" class="form-label">Incoming
                                            Ticket</label>
                                        <div class="input-group flatpickr" id="flatpickr-dtc">
                                            <input type="text" class="form-control dt-incoming-tc"
                                                placeholder="Select Date/Time" name="date_come" id="flatpickr-dtc"
                                                data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <label class="form-label">Source</label>
                                            <a href="#" id="refresh-source">
                                                <i class="icon-sm" data-feather="rotate-cw"></i>
                                            </a>
                                        </div>
                                        <select class="js-example-basic-single form-select" data-width="100%"
                                            name="source_id" id="id-source">
                                            <option value="">- Choose -</option>
                                            @foreach ($src as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->sumber_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <label for="sla_1" class="form-label">SLA</label>
                                            <a href="#" id="refresh-sla">
                                                <i class="icon-sm" data-feather="rotate-cw"></i>
                                            </a>
                                        </div>
                                        <select class="js-example-basic-single form-select" data-width="100%"
                                            name="sla" id="id-sla">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row position-relative">
                                <div class="col-md-12">
                                    <h4 class="card-title">Problem Info</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <u>
                                                <h4 class="col-form-label">Unit</h4>
                                            </u>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <label for="defaultconfig" class="col-form-label">Merk</label>
                                                <a href="#" id="refresh-merk-unit">
                                                    <i class="icon-sm" data-feather="rotate-cw"></i>
                                                </a>
                                            </div>
                                            <select class="js-example-basic-single form-select" data-width="100%"
                                                name="merk_id" id="merk-u-id">
                                                <option value="">- Choose -</option>
                                                @foreach ($merk as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->merk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <label for="defaultconfig" class="col-form-label">Category</label>
                                                <a href="#" id="refresh-category-unit">
                                                    <i class="icon-sm" data-feather="rotate-cw"></i>
                                                </a>
                                            </div>
                                            <select class="js-example-basic-single form-select" data-width="100%"
                                                name="ctgrpi_id" id="ctgr-cu-id">
                                                <option value="">- Choose -</option>
                                                @foreach ($ctgru as $item)
                                                    <option value="{{ $item->category_id }}">
                                                        {{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="defaultconfig" class="col-form-label">Type</label>

                                                    <div class="input-group mb-2">
                                                        <select class="js-example-basic-single form-select"
                                                            data-width="70%" name="type_id" id="unit-type-id">
                                                            <option value="">- Choose Type -
                                                            </option>
                                                        </select>

                                                        <button class="btn btn-inverse-primary" data-bs-toggle="modal"
                                                            data-bs-target="#unitTypeModal" type="button"><i
                                                                class="btn-icon-append icon-lg"
                                                                data-feather="plus"></i></button>
                                                        <div class="modal fade" id="unitTypeModal" tabindex="-1"
                                                            aria-labelledby="slaModalLabel" aria-hidden="true"
                                                            data-bs-backdrop="static">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="slaModalLabel">Add New
                                                                            Type Unit
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="btn-close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label for="sla_1"
                                                                                        class="form-label">Type
                                                                                        Unit</label>
                                                                                    <input id="type-unit-optional"
                                                                                        class="form-control"
                                                                                        name="type_unit_adding"
                                                                                        type="text"
                                                                                        placeholder="Type Unit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-success"
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
                                    <div class="row mb-2">
                                        <div class="col-md-12 text-center">
                                            <u>
                                                <h4 class="col-form-label">Unit Key</h4>
                                            </u>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="user" class="form-label">Serial Number</label>
                                                <input id="sn" class="form-control" name="sn_unit" type="text"
                                                    placeholder="Type Serial Number">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="user" class="form-label">Part Number</label>
                                                <input id="pn" class="form-control" name="pn_unit" type="text"
                                                    placeholder="Type Product Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="group" class="col-form-label">
                                                Warranty
                                            </label>
                                            <fieldset id="warranty-choose" style="margin-top: 8px;">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" value="1"
                                                        name="warranty" id="warranty1">
                                                    <label class="form-check-label" for="warranty1">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" value="0"
                                                        name="warranty" id="warranty2">
                                                    <label class="form-check-label" for="warranty2">
                                                        No
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="defaultconfig-4" class="col-form-label">Part Request</label>
                                            <fieldset id="rqs-part-validate" onChange="modalPart(this.value)"
                                                style="margin-top: 8px;">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" value="1"
                                                        name="part_reqs" id="reqs1">
                                                    <label class="form-check-label" for="reqs1">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" value="0"
                                                        name="part_reqs" id="reqs2">
                                                    <label class="form-check-label" for="reqs2">
                                                        No
                                                    </label>
                                                </div>
                                            </fieldset>
                                            <div class="modal fade bd-example-modal-lg" data-bs-backdrop="static"
                                                id="find-part" tabindex="-1" aria-labelledby="partModal"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="slaModalLabel">Part Detail
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label for="date_mail"
                                                                            class="form-label">Status</label>
                                                                        <select class="js-example-basic-single form-select"
                                                                            data-width="100%" id="part-status"
                                                                            name="status_part">
                                                                            <option value="">
                                                                                - Select Status -
                                                                            </option>
                                                                            @foreach ($type as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->part_type }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="reference" class="form-label">Category
                                                                            Part</label>
                                                                        <select class="js-example-basic-single form-select"
                                                                            data-width="100%" name="kat_part"
                                                                            id="kat-part">
                                                                            <option value="">- Choose -</option>
                                                                            @foreach ($ctgr_part as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->type_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="date_mail" class="form-label">Part
                                                                            Name</label>
                                                                        <input class="form-control" name="type_unit"
                                                                            type="text" id="part-name-detail"
                                                                            placeholder="Type Unit">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <label for="date_mail" class="form-label">SO
                                                                            Number</label>
                                                                        <input id="reqs-part" class="form-control"
                                                                            name="so_num" type="text"
                                                                            placeholder="SO Number">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">RMA</label>
                                                                        <input class="form-control" name="rma_num"
                                                                            type="text" id="rma-part"
                                                                            placeholder="Type RMA Number">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label for="date_mail" class="form-label">Part
                                                                            Number</label>
                                                                        <input id="pn-2" class="form-control"
                                                                            name="product_number" type="text"
                                                                            placeholder="Sparepart Number">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label for="time_mail" class="form-label">CT
                                                                            Number</label>
                                                                        <input id="sn-2" class="form-control"
                                                                            name="serial_number" type="text"
                                                                            placeholder="CT Number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-inverse-success"
                                                                data-bs-dismiss="modal">Done</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="defaultconfig-4" class="col-form-label">Problem</label>
                                            <textarea id="problematika" class="form-control" name="problematika" rows="2" placeholder="Type Problem"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="defaultconfig-4" class="col-form-label">Action
                                                Plan</label>
                                            <textarea id="maxlength-textarea" class="form-control" name="action_plan" rows="2"
                                                placeholder="Type Solution"></textarea>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="file" class="file" name="file[]" multiple
                                                        onchange="showClearButton()">
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-icon btn-xs file-clear"
                                                        style="display:none" onclick="clearFileInput()">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <h4 class="card-title">Project Info</h4>
                                                <hr>
                                                <div class="col-md-5">
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <label class="form-label">Partner</label>
                                                        <a href="#" id="refresh-partner">
                                                            <i class="icon-sm" data-feather="rotate-cw"></i>
                                                        </a>
                                                    </div>
                                                    <select class="js-example-basic-single form-select" data-width="100%"
                                                        name="partner_id" id="partner-select">
                                                        <option value="">- Choose -</option>
                                                        @foreach ($partner as $item)
                                                            <option value="{{ $item->partner_id ?? '' }}">
                                                                {{ $item->partner ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-7">
                                                    <label class="form-label">Project Name</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" id="project-id" name="project_id"
                                                            style="display: none;">
                                                        <a href="#find-project" data-bs-toggle="modal">
                                                            <input type="text" class="form-control" id="project-name"
                                                                placeholder="Choose Project" aria-label="Choose Project"
                                                                aria-describedby="basic-addon2" readonly>
                                                        </a>
                                                        <button class="btn btn-inverse-primary" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#find-project"><i
                                                                class="btn-icon-append icon-lg"
                                                                data-feather="search"></i></button>
                                                        <button class="btn btn-inverse-primary clear-prj"
                                                            type="button"><i class="btn-icon-append icon-lg"
                                                                data-feather="x"></i></button>
                                                        <div class="modal fade bd-example-modal-xl" id="find-project"
                                                            tabindex="-1" aria-labelledby="projectModal"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="projectModal">
                                                                            Find & select Project
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
                                                                                        <th>No</th>
                                                                                        <th>Project
                                                                                            ID</th>
                                                                                        <th>Project
                                                                                            Name</th>
                                                                                        <th>Partner</th>
                                                                                        <th>Contact Person
                                                                                        </th>
                                                                                        <th>
                                                                                            Description</th>
                                                                                        <th>Option
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="project-data">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="ageSelect" class="col-form-label">User Detail</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <button type="button"
                                                                class="btn btn-inverse-primary btn-text" name="sla"
                                                                id="add-cust-dt" data-bs-toggle="modal"
                                                                data-bs-target="#cnydt">Add Detail
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bd-example-modal-lg" id="cnydt"
                                                        tabindex="-1" aria-labelledby="varyingModalLabel"
                                                        aria-hidden="true" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="varyingModalLabel">Adding
                                                                        User
                                                                    </h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label for="company"
                                                                                    class="form-label">Company
                                                                                    :</label>
                                                                                <input type="text" name="company_name"
                                                                                    id="name-company" class="form-control"
                                                                                    placeholder="Company name"
                                                                                    aria-label="Company name"
                                                                                    aria-describedby="basic-addon2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-baseline">
                                                                                    <label for="company"
                                                                                        class="form-label">Type Company
                                                                                        :</label>
                                                                                    <a href="#"
                                                                                        id="refresh-type-company">
                                                                                        <i class="icon-sm"
                                                                                            data-feather="rotate-cw"></i>
                                                                                    </a>
                                                                                </div>
                                                                                <select
                                                                                    class="js-example-basic-single form-select"
                                                                                    data-width="100%" id="type-kantor"
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
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label for="cust_name"
                                                                                    class="form-label">Contact
                                                                                    Name
                                                                                    :</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="contact_name" id="name-contact"
                                                                                    placeholder="Contact Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Phone
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
                                                                                        <label class="form-label">Email
                                                                                            :</label>
                                                                                        <input
                                                                                            class="form-control mb-4 mb-md-0"
                                                                                            name="email_cust"
                                                                                            id="email-validate"
                                                                                            data-inputmask="'alias': 'email'" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label for="severity_4"
                                                                                        class="form-label">Address
                                                                                        :</label>
                                                                                    <textarea class="form-control" id="adds-validate" rows="3" placeholder="Type Address" name="addres_cst"></textarea>
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
                                                                                            <option value="">
                                                                                                -
                                                                                                Select Option -
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
                                                                                            <option value="">
                                                                                                -
                                                                                                Select Option -
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-baseline">
                                                                                        <label for="severity_3"
                                                                                            class="form-label">Location:</label>
                                                                                        <a href="#"
                                                                                            id="refresh-location">
                                                                                            <i class="icon-sm"
                                                                                                data-feather="rotate-cw"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <select
                                                                                        class="js-example-basic-single form-select"
                                                                                        data-width="100%"
                                                                                        id="severity-validate"
                                                                                        name="severity">
                                                                                        <option value="">
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
                                                                                <div class="col">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Ext.
                                                                                            Phone
                                                                                            :</label>
                                                                                        <input
                                                                                            class="form-control mb-4 mb-md-0"
                                                                                            name="phone_ext"
                                                                                            data-inputmask-alias="(+62) 999-9999-9999" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-success"
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h4 class="card-title">Engineer</h4>
                                        <hr>
                                        <div class="col-md-6 mb-2">
                                            <label for="schedule" class="form-label">Schedule</label>
                                            <div class="input-group flatpickr" id="flatpickr-dtc">
                                                <input type="text" class="form-control"
                                                    placeholder="Select Date/Time" name="sch" id="flatpickr-dtc"
                                                    data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i
                                                        data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <label class="form-label">Service Point</label>
                                                <a href="#" id="refresh-sp">
                                                    <i class="icon-sm" data-feather="rotate-cw"></i>
                                                </a>
                                            </div>
                                            <select class="js-example-basic-single form-select" name="servp"
                                                id="servp" data-width="100%">
                                                <option value="">- Choose Option -</option>
                                                @foreach ($sp as $item)
                                                    <option value="{{ $item->service_id }}">
                                                        {{ $item->service_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for='engineer' class='form-label'>Engineer</label>
                                            <select class='js-example-basic-single form-select' data-width='100%'
                                                name="engineer" id="engineer">
                                                <option value="">- Choose Engineer -</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for='L2 Engineer' class='form-label'>L2 Engineer</label>
                                            <select class='js-example-basic-single form-select' data-width='100%'
                                                name="l2_engineer" id="l2-engineer">
                                                <option value="">- Choose L2 -</option>
                                                @foreach ($l2 as $item)
                                                    <option value="{{ $item->nik }}">
                                                        {{ $item->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/dropzone/dropzone.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/form-validation.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-maxlength.js"></script>
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
    <script src="{{ asset('assets') }}/js/typeahead.js"></script>
    <script src="{{ asset('assets') }}/js/tags-input.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#refresh-type-ticket').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#type-ticket').empty();
                $.ajax({
                    url: '{{ route('refresh.type.ticket') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i]
                                .type_name + '</option>';
                        }
                        $('#type-ticket').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch ticket type data.');
                    }
                });
            });
            $('#refresh-source').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#id-source').empty();
                $.ajax({
                    url: '{{ route('refresh.source') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i]
                                .sumber_name + '</option>';
                        }
                        $('#id-source').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch Source data.');
                    }
                });
            });
            $('#refresh-sla').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#id-sla').empty();
                $.ajax({
                    url: '{{ route('refresh.sla') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i]
                                .sla_name + '</option>';
                        }
                        $('#id-sla').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch SLA data.');
                    }
                });
            });
            $('#refresh-merk-unit').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#merk-u-id').empty();
                $.ajax({
                    url: '{{ route('refresh.merk.unit') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i].merk +
                                '</option>';
                        }
                        $('#merk-u-id').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch merk data.');
                    }
                });
            });
            $('#refresh-category-unit').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#ctgr-cu-id').empty();
                $.ajax({
                    url: '{{ route('refresh.category.unit') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].category_id + '">' + data[i]
                                .category_name + '</option>';
                        }
                        $('#ctgr-cu-id').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch category data.');
                    }
                });
            });
            $('#refresh-partner').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#partner-select').empty();
                $.ajax({
                    url: '{{ route('refresh.partner') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].partner_id + '">' + data[i]
                                .partner + '</option>';
                        }
                        $('#partner-select').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch partner data.');
                    }
                });
            });
            $('#refresh-type-company').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#type-kantor').empty();
                $.ajax({
                    url: '{{ route('refresh.type.office') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].office_type_id + '">' + data[
                                i].name_type + '</option>';
                        }
                        $('#type-kantor').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch Type Company data.');
                    }
                });
            });
            $('#refresh-location').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#severity-validate').empty();
                $.ajax({
                    url: '{{ route('refresh.location') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + data[i]
                                .severity_name + '</option>';
                        }
                        $('#severity-validate').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch Location data.');
                    }
                });
            });
            $('#refresh-sp').click(function(e) {
                e.preventDefault(); // Prevent the default click behavior
                // Perform the AJAX request
                $('#servp').empty();
                $.ajax({
                    url: '{{ route('refresh.sp') }}', // Replace with your Laravel route URL
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Update the select element with the received data
                        var options = '<option value="">- Choose -</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].service_id + '">' + data[i]
                                .service_name + '</option>';
                        }
                        $('#servp').html(options);
                    },
                    error: function() {
                        console.log('Failed to fetch Location data.');
                    }
                });
            });
        });
    </script>
@endpush
