@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
    @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category Note</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Category Note</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#CtgrNote">
                                    ADD Category
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="CtgrNote" tabindex="-1" aria-labelledby="sourceModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Adding Category Note
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data=Category-Note') }}" method="post" id="store-note-category">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="Category Note" class="form-label">Category
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="ktgr_note_name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success btn-store-note-category">Save</button>
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
                                        <th>Created at</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($ktgr_note as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->ktgr_name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#mdl-edt-Category-Note{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="mdl-edt-Category-Note{{ $no }}" tabindex="-1"
                                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sourceModalLabel">Edit Category Note
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("update/$item->id/data=Category-Note") }}"
                                                                    method="post" id="edit-ktgr-note-form{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="source_name"
                                                                                    class="form-label">Category Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edt_note_kategory_name"
                                                                                    value="{{ $item->ktgr_name }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success edit-mdl-ktgr-note{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <form action="{{ url("remove/$item->id/data=Category-Note") }}" method="post"
                                                    id="form-remove-ktgr-note{{ $no }}" style="display: none;">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                </form>
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm btn-remove-ktgr-note{{ $no }}">
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
    $('.btn-store-note-category').on('click', function () {
        Swal.fire({
            title: "Continue Save ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#store-note-category').submit();
            }
        });
        return false;
    });
    
    for (let i = 0; i < 50; i++) {
        $('.edit-mdl-ktgr-note' + i + '').on('click', function () {
            Swal.fire({
                title: "Edit this category?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Next',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#edit-ktgr-note-form' + i + '').submit();
                }
            });

            return false;
        });
        $('.btn-remove-ktgr-note' + i + '').on('click', function () {
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
                    jQuery('#form-remove-ktgr-note' + i + '').submit();
                }
            });

            return false;
        });
    }
</script>
@endpush
