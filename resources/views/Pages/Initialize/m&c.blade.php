@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Merk & Category</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Merk & Category</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#src_hgt">
                                    ADD New Init
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="src_hgt" tabindex="-1" aria-labelledby="sourceModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Choose item for Initialize
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add-Initialize/data=Merk-Category') }}" method="post"
                                                    id="store-init-mc">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="defaultconfig" class="col-form-label">Merk
                                                                Unit</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="init_merk" id="merk-init-mc">
                                                                <option value="">- Choose -</option>
                                                                @foreach ($merk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->merk }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="defaultconfig" class="col-form-label">Category
                                                                Unit</label>
                                                            <select class="js-example-basic-single form-select"
                                                                data-width="100%" name="init_ktgr" id="ktgr-init-mc">
                                                                <option value="">- Choose -</option>
                                                                @foreach ($ktgr as $item)
                                                                    <option value="{{ $item->category_id }}">
                                                                        {{ $item->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button"
                                                    class="btn btn-success btn-store-init-mc">Save</button>
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
                                        <th>Type Name</th>
                                        <th>Created at</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($init_mc as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->merk->merk }}</td>
                                            <td>{{ $item->category->category_name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-type-office{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="modal-edit-type-office{{ $no }}"
                                                    tabindex="-1" aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sourceModalLabel">Edit Office
                                                                    Type
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ url("update/$item->id/Initialize=Merk-Category") }}"
                                                                    method="post"
                                                                    id="edit-init-mc-form{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <label for="defaultconfig"
                                                                                class="col-form-label">Merk
                                                                                Unit</label>
                                                                            <select
                                                                                class="js-example-basic-single form-select"
                                                                                data-width="100%" name="edt_init_merk">
                                                                                <option value="">- Choose -</option>
                                                                                @foreach ($merk as $mrk)
                                                                                    <option value="{{ $mrk->id }}" 
                                                                                    {{ $item->merk_id == $mrk->id ? 'selected' : '' }}>
                                                                                        {{ $mrk->merk }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label for="defaultconfig"
                                                                                class="col-form-label">Category
                                                                                Unit</label>
                                                                            <select
                                                                                class="js-example-basic-single form-select"
                                                                                data-width="100%" name="edt_init_ktgr">
                                                                                <option value="">- Choose -</option>
                                                                                @foreach ($ktgr as $ctgr)
                                                                                    <option
                                                                                        value="{{ $ctgr->category_id }}"
                                                                                        {{ $item->category_id == $ctgr->category_id ? 'selected' : '' }}>
                                                                                        {{ $ctgr->category_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success edit-mdl-init-mc{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <form action="{{ url("remove/$item->id/Initialize=Merk-Category") }}"
                                                    method="post" id="form-remove-init-mc{{ $no }}"
                                                    style="display: none;">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                </form>
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm btn-remove-init-mc{{ $no }}">
                                                    <i data-feather="delete"></i>
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
        $('.btn-store-init-mc').on('click', function() {
            Swal.fire({
                title: "Continue save this data?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#store-init-mc').submit();
                }
            });
            return false;
        });

        for (let i = 0; i < 50; i++) {
            $('.edit-mdl-init-mc' + i + '').on('click', function () {
                Swal.fire({
                    title: "Edit this type?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#edit-init-mc-form' + i + '').submit();
                    }
                });

                return false;
            });
            $('.btn-remove-init-mc' + i + '').on('click', function() {
                Swal.fire({
                    title: "Deleted this type?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Yes!',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#form-remove-init-mc' + i + '').submit();
                    }
                });

                return false;
            });
        }
    </script>
@endpush
