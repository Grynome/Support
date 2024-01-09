@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category Expenses</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Category Expenses</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#mdl-add-ctgr-expenses">
                                    ADD Category
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="mdl-add-ctgr-expenses" tabindex="-1" aria-labelledby="ExpensesModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ExpensesModalLabel">Add Category Expenses
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/Data=CtgrExpenses') }}" method="post" id="fm-add-ctgr-expenses">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="Deskripsi" class="form-label">Deskripsi</label>
                                                                <input type="text" class="form-control" id="Deskripsi"
                                                                    name="val_desc" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success btn-add-ctgr-expenses">Save</button>
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
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($cxp as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#mdl-updt-ctgr-expenses{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="mdl-updt-ctgr-expenses{{ $no }}" tabindex="-1"
                                                    aria-labelledby="ExpansesModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ExpansesModalLabel">Edit SLA
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("Update/$item->id/Data=CtgrExpenses") }}"
                                                                    method="post" id="fm-updt-ctgr-expenses{{ $no }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="Val-Updt-Desc"
                                                                                    class="form-label">Description</label>
                                                                                <input type="text" class="form-control" id="Val-Updt-Desc"
                                                                                    name="val_updt_desc"
                                                                                    value="{{ $item->description }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success btn-updt-ctgr-expenses{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm btn-dstr-ctgr-expenses{{ $no }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                                <form action="{{ url("Remove/$item->id/Data=CtgrExpenses") }}" method="post"
                                                    id="fm-dstr-ctgr-expenses{{ $no }}">
                                                    @csrf
                                                    @method('PATCH')
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
        $('.btn-add-ctgr-expenses').on('click', function() {
            if ($('#Deskripsi').val() === "") {
                Swal.fire({
                    title: "Description it's Empty",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
            } else {
                jQuery("#fm-add-ctgr-expenses").submit();
            }
            return false;
        });
        for (let i = 0; i < 50; i++) {
            $('.btn-updt-ctgr-expenses' + i + '').on('click', function() {
                if ($('#Val-Updt-Desc').val() === "") {
                    Swal.fire({
                        title: "Description can't be Empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else {
                    Swal.fire({
                        title: "Confirm the Update?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {

                            jQuery('#fm-updt-ctgr-expenses' + i + '').submit();
                        }
                    });
                    return false;
                }
            });
            $('.btn-dstr-ctgr-expenses' + i + '').on('click', function() {
                Swal.fire({
                    title: "Confirm to Remove?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#fm-dstr-ctgr-expenses' + i + '').submit();
                    }
                });
                return false;
            });
        }
    </script>
@endpush
