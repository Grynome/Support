@extends('Theme/Report/header')
@section('page_detil')
    <body class="g-sidenav-show  bg-gray-100">
        @include('sweetalert::alert')
        <nav
            class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
            <div class="container">
                <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text" href="{{ url("Detail/Ticket=$id") }}">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Back
                </a>
                <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon mt-2">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </span>
                </button>
            </div>
        </nav>
        <div class="page-header bg-gradient-secondary  position-relative m-3 border-radius-xl">
            <img src="{{ asset('assets') }}/images/waves-white.svg" alt="pattern-lines"
                class="position-absolute opacity-6 start-0 top-0 w-100">
            <div class="container pb-lg-9 pb-10 pt-7 postion-relative z-index-2">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-7 mx-auto text-center">
                        <div class="nav-wrapper mt-5 position-relative z-index-2">
                            <ul class="nav nav-pills nav-fill flex-row p-1" id="tabs-pricing" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 active" id="tabs-iconpricing-tab-1" data-bs-toggle="tab"
                                        role="tab" aria-controls="monthly" aria-selected="true">
                                        Part Detail
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-n8">
            <div class="container">
                <div class="tab-content tab-space">
                    <div class="tab-pane active" id="monthly">
                        <div class="row">
                            <div class="col-lg-12 mb-lg-0 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <span class="badge rounded-pill bg-light text-dark">No. Ticket</span>
                                        <h5><span class="badge rounded-pill text-dark">{{ $id }}</span></h5>

                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                        <div class="table-responsive p-0">
                                            <table class="table table-flush" id="datatable-search">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            No
                                                        </th>
                                                        <th>
                                                            Part
                                                        </th>
                                                        <th>
                                                            Category Part
                                                        </th>
                                                        <th>
                                                            Part
                                                            Number
                                                        </th>
                                                        <th>
                                                            CT
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
                                                            ETA
                                                        </th>
                                                        <th>
                                                            Status
                                                        </th>
                                                        <th>
                                                            Option
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
                                                            <td>{{ $item->type_name }}
                                                            </td>
                                                            <td>{{ $item->pn }}
                                                            </td>
                                                            <td>{{ $item->sn }}
                                                            </td>
                                                            <td>{{ $item->so_num }}
                                                            </td>
                                                            <td>{{ $item->rma }}
                                                            </td>
                                                            <td>{{ $item->eta }}
                                                            </td>
                                                            <td>{{ $item->part_type }}
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="badge badge-sm bg-gradient-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-prd{{ $no }}">Update</button>
                                                                <div class="modal fade" id="edit-prd{{ $no }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Update Part</h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    action="{{ url("Update/$item->id/Part/$id") }}"
                                                                                    method="post"
                                                                                    id="part-edit-form{{ $no }}">
                                                                                    @csrf
                                                                                    {{ method_field('patch') }}
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="row mb-3">
                                                                                                <div class="col-md-3">
                                                                                                    <label for="date_mail"
                                                                                                        class="form-label">Type
                                                                                                        Unit</label>
                                                                                                    <input id="reqs-part"
                                                                                                        class="form-control"
                                                                                                        name="edt_type_unit_updt"
                                                                                                        type="text"
                                                                                                        value="{{ $item->unit_name }}"
                                                                                                        placeholder="Type Unit">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label for="group"
                                                                                                        class="form-label">
                                                                                                        Category Part
                                                                                                    </label>
                                                                                                    <select
                                                                                                        class="js-example-basic-single form-select"
                                                                                                        data-width="100%"
                                                                                                        name="edt_ktgr_part_dt">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            -
                                                                                                            Select
                                                                                                            Status
                                                                                                            -
                                                                                                        </option>
                                                                                                        @foreach ($ctgr_part as $tp)
                                                                                                            <option
                                                                                                                value="{{ $tp->id }}"
                                                                                                                {{ $item->type_name == $tp->type_name ? 'selected' : '' }}>
                                                                                                                {{ $tp->type_name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label for="group"
                                                                                                        class="form-label">
                                                                                                        Type Part
                                                                                                    </label>
                                                                                                    <select
                                                                                                        class="js-example-basic-single form-select"
                                                                                                        data-width="100%"
                                                                                                        name="edt_status_part_updt">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            -
                                                                                                            Select
                                                                                                            Status
                                                                                                            -
                                                                                                        </option>
                                                                                                        @foreach ($type as $tp)
                                                                                                            <option
                                                                                                                value="{{ $tp->id }}"
                                                                                                                {{ $item->part_type == $tp->part_type ? 'selected' : '' }}>
                                                                                                                {{ $tp->part_type }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                        <label for="group"
                                                                                                            class="form-label">
                                                                                                            ETA
                                                                                                        </label>
                                                                                                    <input
                                                                                                        class="form-control datepicker"
                                                                                                        placeholder="Please select estimate date"
                                                                                                        type="text" name="eta_date"
                                                                                                        value="{{ $item->eta }}">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row mb-3">
                                                                                                <div class="col-md-3">
                                                                                                    <label for="date_mail"
                                                                                                        class="form-label">SO
                                                                                                        Number</label>
                                                                                                    <input id="reqs-part"
                                                                                                        class="form-control"
                                                                                                        name="edt_so_num_updt"
                                                                                                        type="text"
                                                                                                        value="{{ $item->so_num }}"
                                                                                                        placeholder="SO Number">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label for="date_mail"
                                                                                                        class="form-label">RMA
                                                                                                        Number</label>
                                                                                                    <input id="reqs-part"
                                                                                                        class="form-control"
                                                                                                        name="edt_rma_updt"
                                                                                                        type="text"
                                                                                                        value="{{ $item->rma }}"
                                                                                                        placeholder="Type RMA Number">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label for="date_mail"
                                                                                                        class="form-label">Part
                                                                                                        Number</label>
                                                                                                    <input id="pn-2"
                                                                                                        class="form-control"
                                                                                                        name="edt_product_number_updt"
                                                                                                        type="text"
                                                                                                        value="{{ $item->pn }}"
                                                                                                        placeholder="Product Number">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label for="time_mail"
                                                                                                        class="form-label">CT
                                                                                                        Number</label>
                                                                                                    <input id="sn-2"
                                                                                                        class="form-control"
                                                                                                        name="edt_serial_number_updt"
                                                                                                        type="text"
                                                                                                        value="{{ $item->sn }}"
                                                                                                        placeholder="CT Number">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-default trigger-edit-part-dt{{ $no }}">Save</button>
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#part-detail">Back</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                |
                                                                <button type="submit"
                                                                    class="badge badge-sm bg-gradient-danger btn-destroy-list-part{{ $no }}">Delete</button>
                                                                <form action="{{ url("Delete/$item->id/Part/$id") }}"
                                                                    method="post" id="fm-destroy-list-part{{ $no }}"
                                                                    style="display: none;">
                                                                    @csrf
                                                                    {{ method_field('delete') }}
                                                                </form>
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
                </div>
            </div>
        </div>
    @endsection
    @push('script2')
        <script>
            if (document.querySelector(".flatpickr-input")) {
                flatpickr(".flatpickr-input", {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    altInput: false,
                    allowInput: true,
                    altFormat: '(W) d-m-Y',
                });
            }
        </script>
        <script>
            for (let i = 0; i < 50; i++) {
                $('.trigger-edit-part-dt' + i + '').on('click', function() {
                    Swal.fire({
                        title: "Continue update this part?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            jQuery('#part-edit-form' + i + '').submit();
                        }
                    })
                    return false;
                });
                $('.btn-destroy-list-part' + i + '').on('click', function() {
                    Swal.fire({
                        title: "Are u sure delete this part?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            jQuery('#fm-destroy-list-part' + i + '').submit();
                        }
                    })
                    return false;
                });
            }
        </script>
    @endpush
