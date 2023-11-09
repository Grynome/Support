@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Ticket</a></li>
                <li class="breadcrumb-item active" aria-current="page">AWB</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Sparepart Data</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#det-user-awb">
                                    <i class="btn-icon-append" data-feather="eye"></i>
                                </button>
                                <div class="modal fade" id="det-user-awb" tabindex="-1" aria-labelledby="projectModal"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="projectModal">
                                                    Detail
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12 mb-2">
                                                        <p class="text-body fw-bolder border-bottom">
                                                            ~ Information User ~
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div
                                                            class="d-flex justify-content-between flex-grow-1">
                                                            <div>
                                                                <p class="text-body fw-bolder">
                                                                    Company
                                                                </p>
                                                                <p class="text-body tx-13">
                                                                    {{ $dt_ticket->company }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 border-end-lg">
                                                                <div class="mb-3">
                                                                    <div class="d-flex justify-content-between flex-grow-1">
                                                                        <div>
                                                                            <p class="text-body fw-bolder">
                                                                                Contact
                                                                                Name
                                                                            </p>
                                                                            <p class="text-body tx-13">
                                                                                {{ $dt_ticket->contact_person }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="d-flex justify-content-between flex-grow-1">
                                                                        <div>
                                                                            <p class="text-body fw-bolder">
                                                                                Phone
                                                                            </p>
                                                                            <p class="text-body tx-13">
                                                                                {{ $dt_ticket->phone }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="d-flex justify-content-between flex-grow-1">
                                                                        <div>
                                                                            <p class="text-body fw-bolder">
                                                                                Email
                                                                            </p>
                                                                            <p class="text-body tx-13">
                                                                                {{ $dt_ticket->email }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <div class="d-flex justify-content-between flex-grow-1">
                                                                        <div>
                                                                            <p class="text-body fw-bolder">
                                                                                Address
                                                                            </p>
                                                                            <p class="text-body tx-13">
                                                                                {{ $dt_ticket->address }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12 mb-2">
                                                        <p class="text-body fw-bolder border-bottom">
                                                            ~ Information SP ~
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div
                                                            class="d-flex justify-content-between flex-grow-1">
                                                            <div>
                                                                <p class="text-body fw-bolder">
                                                                    Hp. Engineer
                                                                </p>
                                                                <p class="text-body tx-13">
                                                                    {{ $dt_ticket->phone_en }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div
                                                            class="d-flex justify-content-between flex-grow-1">
                                                            <div>
                                                                <p class="text-body fw-bolder">
                                                                    Address SP
                                                                </p>
                                                                <p class="text-body tx-13">
                                                                    {{ @$get_ads_sp->alamat }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Back</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($validate_list))
                                    <button type="button" class="btn btn-inverse-primary btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#list-part-awb">
                                        <i class="btn-icon-append" data-feather="list"></i>
                                    </button>
                                @elseif (empty($validate_save))
                                    @if ($hidden->status_awb == 1)
                                    @else
                                        <button type="button" class="btn btn-inverse-success btn-icon finish-awb">
                                            <i class="btn-icon-append" data-feather="save"></i>
                                        </button>
                                        <form action="{{ url("Update-Ticket/AWB/$key") }}" method="post"
                                            id="awb-finishing">
                                            @csrf
                                            {{ method_field('patch') }}
                                        </form>
                                    @endif
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            SO Number
                                        </th>
                                        <th>
                                            Part
                                        </th>
                                        <th>
                                            Part
                                            Number
                                        </th>
                                        <th>
                                            RMA
                                        </th>
                                        <th>
                                            Type Part
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            AWB Number
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
                                    @foreach ($part_awb as $item)
                                        <tr>

                                            <td>{{ $no }}
                                            </td>
                                            <td>{{ $item->so_num }}
                                            </td>
                                            <td>{{ $item->unit_name }}
                                            </td>
                                            <td>{{ $item->pn }}
                                            </td>
                                            <td>{{ $item->rma }}
                                            </td>
                                            <td>
                                                {{ $item->part_type }}
                                            </td>
                                            <td>
                                                @if ($item->status_list == '')
                                                    Need update AWB
                                                @elseif ($item->status_list == 0)
                                                    <a href="#list-part-awb" data-bs-toggle="modal">
                                                        Already In List
                                                    </a>
                                                @elseif ($item->status_list == 1)
                                                    AWB Added
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status_list == 1)
                                                    {{ $item->awb_num }}
                                                @else
                                                    Not Available
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status_list == '')
                                                    <div class="btn-toolbar" role="toolbar"
                                                        aria-label="Toolbar with button groups">
                                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                                            <form
                                                                action="{{ url("Add-List/AWB/$key/$item->part_detail_id") }}"
                                                                method="post" id="add-list{{ $no }}"
                                                                style="display: none;">
                                                                @csrf
                                                                <input type="text" value="{{ $item->id }}"
                                                                    name="part_id" style="display:none;">
                                                                <input type="text" id="trigger-list" name="vald"
                                                                    style="display:none;">
                                                                <input type="hidden" name="single_no_awb"
                                                                    id="single-no-awb">
                                                            </form>
                                                            <button type="button"
                                                                class="btn btn-inverse-success btn-icon btn-sm add-to-list{{ $no }}">
                                                                <i data-feather="plus"></i>
                                                            </button>
                                                            &nbsp;
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm add-single-list{{ $no }}">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    No Action Needed
                                                @endif
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
    {{-- ADD NO AWB --}}
    <div class="modal fade" id="addnoAWB" tabindex="-1" aria-labelledby="slaModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slaModalLabel">Add New
                        Type Unit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sla_1" class="form-label">Type
                                    Unit</label>
                                <input id="type-unit-optional" class="form-control" name="type_unit_adding"
                                    type="text" placeholder="Type Unit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success save-list-no-awb">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- List Part --}}
    <div class="modal fade bd-example-modal-xl" id="list-part-awb" tabindex="-1" aria-labelledby="projectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModal">
                        List Part to Update AWB
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="display" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part</th>
                                    <th>Part Number</th>
                                    <th>CT</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data_list as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->unit_name }}</td>
                                        <td>{{ $item->pn }}</td>
                                        <td>{{ $item->sn }}</td>
                                        <td>
                                            <form
                                                action="{{ url("Delete/List-awb/$item->part_detail_id/$item->part_id") }}"
                                                method="post">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-inverse-danger btn-icon btn-sm">
                                                    <i data-feather="refresh-ccw"></i>
                                                </button>
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
                <div class="modal-footer">
                    <form action="{{ url("Update/All-List/$key") }}" method="post" id="update-all-list-part">
                        @csrf
                        {{ method_field('patch') }}
                        <input type="hidden" name="awb_number" id="awb_number">
                    </form>
                    <button type="button" class="btn btn-primary fill-no-awb" data-bs-dismiss="modal">Next</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        for (let i = 0; i < 50; i++) {
            $('.add-to-list' + i + '').on('click', function() {
                Swal.fire({
                    title: "Add for create AWB?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        const cek = 1;
                        $('#trigger-list').val(cek);
                        jQuery('#add-list' + i + '').submit();
                    }
                })
                return false;
            });
            $('.add-single-list' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Submit no AWB!',
                    text: 'After this the part will be finish of created AWB',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Save',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Back',
                    inputPlaceholder: "Input the AWB number",
                    inputAttributes: {
                        name: "single_no_awb"
                    }
                }).then((result) => {
                    if (result.value) {
                        const cek = 2;
                        $('#trigger-list').val(cek);
                        jQuery('#single-no-awb').val(result.value);
                        jQuery('#add-list' + i + '').submit();
                    }
                });
            });
        }
        $('.fill-no-awb').on('click', function() {
            Swal.fire({
                title: 'Submit no AWB!',
                text: 'After this the part will be finish of created AWB',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showDenyButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Save',
                denyButtonColor: '#d33',
                denyButtonText: 'Back',
                inputPlaceholder: "Input the AWB number",
                inputAttributes: {
                    name: "awb_number"
                }
            }).then((result) => {
                if (result.value) {
                    jQuery('#awb_number').val(result.value);
                    jQuery('#update-all-list-part').submit();
                } else if (result.isDenied) {
                    $('#list-part-awb').modal('show');
                }
            });
        });

        $('.finish-awb').on('click', function() {
            Swal.fire({
                title: "Finish AWB from this ticket?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Finish',
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#awb-finishing').submit();
                }
            })
            return false;
        });
    </script>
@endpush
