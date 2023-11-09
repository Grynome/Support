@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables / Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Merk Unit</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Merk</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#merk_hgt">
                                    ADD Merk
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="merk_hgt" tabindex="-1" aria-labelledby="severityModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="severityModalLabel">Add Merk
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data=Merk-Unit') }}" method="post" id="form-merk-unit">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Merk</label>
                                                                <input type="text" class="form-control"
                                                                    name="merk_unit_val" id="merk-u-name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success store-merk-unit">Save</button>
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
                                        <th>Merk Name</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($merk as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->merk }}</td>
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
                                                                <h5 class="modal-title" id="severityModalLabel">Edit Merk
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("update/$item->id/data=Merk-Unit") }}" method="post" id="form-edit-merk-unit{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Type
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edt_merk_unit" value="{{ $item->merk }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-success btn-edt-merk-unit{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <button type="button" class="btn btn-inverse-warning btn-icon btn-sm destroy-merk-unit{{ $no }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                                <form action="{{ url("remove/$item->id/data=Merk-Unit") }}" method="post" id="destroy-merk-unit{{ $no }}">
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
    $('.store-merk-unit').on('click', function () {
        if ($('#merk-u-name').val() === "") {
            Swal.fire({
                title: "Field cannot be empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else {
            Swal.fire({
                title: "Continue add Merk?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery("#form-merk-unit").submit();
                }
            })
            return false;
        }
    });

    for (let i = 0; i < 50; i++) {
        $('.btn-edt-merk-unit' + i + '').on('click', function () {
            Swal.fire({
                title: "Edit this item?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#form-edit-merk-unit' + i + '').submit();
                }
            });
            return false;
        });
        $('.destroy-merk-unit' + i + '').on('click', function () {
            Swal.fire({
                title: "Delete this item?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#destroy-merk-unit' + i + '').submit();
                }
            });
            return false;
        });
    }
</script>
@endpush
