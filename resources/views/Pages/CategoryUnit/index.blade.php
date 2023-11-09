@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables / Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category Unit</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Category</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#ctgr_hgt">
                                    ADD Category
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="ctgr_hgt" tabindex="-1" aria-labelledby="severityModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="severityModalLabel">Add Category
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data=Category-Unit') }}" method="post" id="form-ctgr-unit">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="condition" class="form-label">Merk</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" id="merk-ctgr" name="add_ktgr_merk"
                                                                required>
                                                                <option value="">- Choose -</option>
                                                                @foreach ($merk_data as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->merk }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Category</label>
                                                                <input type="text" class="form-control"
                                                                    name="ctgr_unit_val" id="ctgr-u-name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success store-ctgr-unit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Name</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($ktgr as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit-ctgr-unit{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="edit-ctgr-unit{{ $no }}" tabindex="-1" aria-labelledby="severityModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="severityModalLabel">Edit Severity
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("update/$item->category_id/data=Category-Unit") }}" method="post" id="form-edit-ctgr-unit{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="mb-3">
                                                                                <label for="condition" class="form-label">Merk</label>
                                                                                <select class="js-example-basic-single form-select"
                                                                                    data-width="100%" name="updt_ktgr_unit"
                                                                                    required>
                                                                                    <option value="">- Choose -</option>
                                                                                    @foreach ($merk_data as $sch)
                                                                                        <option value="{{ $sch->id }}"
                                                                                            {{ $item->merk_id == $sch->id ? 'selected' : '' }}>
                                                                                            {{ $sch->merk }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Type
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edt_ctgr_unit" value="{{ $item->category_name }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-success btn-edt-ctgr-unit{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <button type="button" class="btn btn-inverse-warning btn-icon btn-sm destroy-ctgr-unit{{ $no }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                                <form action="{{ url("remove/$item->category_id/data=Category-Unit") }}" method="post" id="destroy-ctgr-unit{{ $no }}">
                                                @csrf
                                                {{ method_field('patch') }}
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
@endsection
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
<script>
    $('.store-ctgr-unit').on('click', function () {
        if ($('#ctgr-u-name').val() === "") {
            Swal.fire({
                title: "Field cannot be empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        }else if ($('#merk-ctgr').val() === "") {
            Swal.fire({
                title: "Choose Merk!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else {
            Swal.fire({
                title: "Continue add category unit?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery("#form-ctgr-unit").submit();
                }
            })
        }
        return false;
    });

    for (let i = 0; i < 50; i++) {
        $('.btn-edt-ctgr-unit' + i + '').on('click', function () {
            Swal.fire({
                title: "Edit this item?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#form-edit-ctgr-unit' + i + '').submit();
                }
            });
            return false;
        });
        $('.destroy-ctgr-unit' + i + '').on('click', function () {
            Swal.fire({
                title: "Delete this item?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#destroy-ctgr-unit' + i + '').submit();
                }
            });
            return false;
        });
    }
</script>
@endpush
