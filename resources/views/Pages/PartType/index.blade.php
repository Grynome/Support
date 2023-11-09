@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables / Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Type Part</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Type Part</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#part_hgt">
                                    ADD Type
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="part_hgt" tabindex="-1" aria-labelledby="severityModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="severityModalLabel">Adding Type of Part
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data=Type-Part') }}" method="post"
                                                    id="form-type-part">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="Type-Part-Name" class="form-label">Type
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="type_part_name" id="type-name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="Type-Part-Name" class="form-label">Return or Not</label>
                                                                <fieldset id="return-or-not">
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input"
                                                                            value="1" name="return_or_not">
                                                                        <label class="form-check-label">
                                                                            Yes
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input"
                                                                            value="0" name="return_or_not">
                                                                        <label class="form-check-label">
                                                                            No
                                                                        </label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="Type-Part-Name" class="form-label">Type
                                                                    Describe</label>
                                                                <textarea id="type-part-desc" class="form-control" name="desc_type" maxlength="100" rows="3"
                                                                    placeholder="Describe the Type"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success store-type-part">Save</button>
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
                                        <th>Type Part</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($part as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->part_type }}</td>
                                            <td>{{ $item->desc_type }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit-type-part{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="edit-type-part{{ $no }}"
                                                    tabindex="-1" aria-labelledby="severityModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="severityModalLabel">Edit
                                                                    Part Type
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("update/$item->id/data=Type-Part") }}"
                                                                    method="post"
                                                                    id="form-edit-type-part{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="source_name"
                                                                                    class="form-label">Type
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edt_type_name"
                                                                                    value="{{ $item->part_type }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="Type-Part-Name" class="form-label">Return or Not</label>
                                                                                <fieldset id="edt-return-or-not">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio" class="form-check-input"
                                                                                            value="1" name="edt_return_or_not" {{ ($item->status == 1 ? 'checked' : '') }}>
                                                                                        <label class="form-check-label">
                                                                                            Yes
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio" class="form-check-input"
                                                                                            value="0" name="edt_return_or_not" {{ ($item->status == 0 ? 'checked' : '') }}>
                                                                                        <label class="form-check-label">
                                                                                            No
                                                                                        </label>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="Type-Part-Name"
                                                                                    class="form-label">Type
                                                                                    Describe</label>
                                                                                <textarea id="maxlength-textarea" class="form-control" name="edt_desc_type" maxlength="100" rows="3"
                                                                                    placeholder="Describe the Type">{{ $item->desc_type }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success btn-edt-type-part{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm destroy-type-part{{ $no }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                                <form action="{{ url("remove/$item->id/data=Type-Part") }}"
                                                    method="post" id="destroy-type-part{{ $no }}">
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
        $('.store-type-part').on('click', function() {
            if ($('#type-name').val() === "" || $('#type-part-desc').val() === "") {
                Swal.fire({
                    title: "Field cannot be empty!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
            } else {
                Swal.fire({
                    title: "Continue to Add Type Part?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery("#form-type-part").submit();
                    }
                })
            }
            return false;
        });

        for (let i = 0; i < 50; i++) {
            $('.btn-edt-type-part' + i + '').on('click', function() {
                Swal.fire({
                    title: "Edit this item?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-edit-type-part' + i + '').submit();
                    }
                });
                return false;
            });
            $('.destroy-type-part' + i + '').on('click', function() {
                Swal.fire({
                    title: "Delete this item?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#destroy-type-part' + i + '').submit();
                    }
                });
                return false;
            });
        }
    </script>
@endpush
