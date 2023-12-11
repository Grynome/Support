@push('css-plugin')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Form Input / Project</a></li>
                @if (empty($data_project))
                    <li class="breadcrumb-item active" aria-current="page">Add New Data Project</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">Edit Data Project</li>
                @endif
            </ol>
        </nav>
        <form class="forms-sample"
            action="{{ empty($data_project) ? url('Add/Project-HGT') : url("Update/$data_project->project_id/Project") }}"
            method="post" id="data-process">
            @csrf
            @if (!empty($data_project))
                {{ method_field('patch') }}
            @endif
            <div class="row">
                <div class="col-md-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Partner Data</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Project
                                            Owner</label>
                                        <input type="text" id="partner-id" name="partner_id" style="display: none;"
                                            value="{{ @$data_project->partner_id }}">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Partner's name"
                                                value="{{ @$data_project->go_partner->partner }}" aria-label="Owner's Name"
                                                aria-describedby="basic-addon2" id="name-partner" disabled>
                                            <div class="input-group-append">
                                                <button class="btn btn-inverse-primary" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#find-partner"><i
                                                        class="btn-icon-append icon-lg" data-feather="search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Name</label>
                                        <input type="text" class="form-control" placeholder="PIC name" id="contact-person-prj"
                                            name="contact_name" value="{{ @$data_project->contact_person }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg" id="find-partner" tabindex="-1" aria-labelledby="projectModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="projectModal">
                                    Select Option Owner
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Partner ID</th>
                                                <th>Partner</th>
                                                <th>Contact_person</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($partner as $item)
                                                <tr>
                                                    <td>{{ $no }}
                                                    </td>
                                                    <td>{{ $item->partner_id }}
                                                    </td>
                                                    <td>{{ $item->partner }}
                                                    </td>
                                                    <td>{{ $item->contact_person }}
                                                    </td>
                                                    <td>{{ $item->telp }}
                                                    </td>
                                                    <td>{{ $item->email }}
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-inverse-info btn-icon btn-sm select-partner">
                                                            <i data-feather="mouse-pointer"></i>
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Project Detail</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="contract_prj" class="form-label">Kontrak Number</label>
                                        <input type="text" class="form-control" name="contract_prj" id="contract-prj"
                                            value="{{ @$data_project->no_contract }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="project_name" class="form-label">Project
                                            Name</label>
                                        <input type="text" class="form-control" name="project_name" id="project-name"
                                            value="{{ @$data_project->project_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="desc" class="form-label">Description</label>
                                        <textarea class="form-control" name="desc" id="project-desc" maxlength="100" rows="1" placeholder="Type Desc">{{ @$data_project->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="project_mail" class="form-label">Project
                                                    Mail</label>
                                                <input class="form-control mb-4 mb-md-0" name="project_mail" id="project-mail"
                                                    data-inputmask="'alias': 'email'"
                                                    value="{{ @$data_project->mail_project }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="Phone" class="form-label">Phone Number</label>
                                                <input class="form-control mb-4 mb-md-0"
                                                    data-inputmask-alias="(+62) 999-9999-9999" name="phone_prj" id="phone-prj"
                                                    value="{{ @$data_project->phone }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="detail" class="form-label">Status</label>
                                        <fieldset id="status">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="sts"
                                                    value="1" {{ @$data_project->status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="prj-sts">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="sts"
                                                    value="2" {{ @$data_project->status == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="prj-sts">
                                                    Inactive
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start
                                            Date</label>
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control" placeholder="Select Date"
                                                name="start_date" id="start-date"
                                                value="{{ @$data_project->startdate }}" data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control" placeholder="Select Date"
                                                name="end_date" id="end-date" value="{{ @$data_project->enddate }}"
                                                data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-inverse-success save-data"> Save </button>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
@endpush
@push('custom')
    @if (!empty($data_project))
        <script>
            $('.save-data').on('click', function() {
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Continues to Update?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = getLink;
                        jQuery('#data-process').submit();
                    }
                });
                return false;
            });
        </script>
    @else
        <script>
            $('.save-data').on('click', function() {
                var getLink = $(this).attr('href');
                var fieldset2 = document.getElementById("status").getElementsByTagName('input');
                var checkedFieldset2 = false;
                for (var i = 0; i < fieldset2.length; i++) {
                    if (fieldset2[i].checked) {
                        checkedFieldset2 = true;
                        break;
                    }
                }
                if ($('#partner-id').val() === "" && $('#contact-person-prj').val() === "" && $('#contract-prj').val() === "" && $('#project-name').val() === "" && $('#project-desc').val() === "" && $('#project-mail').val() ===
                    "" && $('#phone-prj').val() === "" && !checkedFieldset2 && $('#start-date').val() === "" && $('#end-date').val() === "") {
                    Swal.fire({
                        title: "All Field's its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#partner-id').val() === "") {
                    Swal.fire({
                        title: "Choose Owner for this project!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#contact-person-prj').val() === "") {
                    Swal.fire({
                        title: "Contact Name its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#contract-prj').val() === "") {
                    Swal.fire({
                        title: "No Kontrak cannot be empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#project-name').val() === "") {
                    Swal.fire({
                        title: "Project Name Cannot be Empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#project-desc').val() === "") {
                    Swal.fire({
                        title: "Pls add Description!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#project-mail').val() === "") {
                    Swal.fire({
                        title: "Please insert mail!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#phone-prj').val() === "") {
                    Swal.fire({
                        title: "Please insert Phone!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if (!checkedFieldset2) {
                    Swal.fire({
                        title: "Please select an option status",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#start-date').val() === "") {
                    Swal.fire({
                        title: "Pls Choose start date!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#end-date').val() === "") {
                    Swal.fire({
                        title: "Pls Choose end date!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else {
                    window.location.href = getLink;
                    jQuery("#data-process").submit();
                }
                return false;
            });
        </script>
    @endif
@endpush
