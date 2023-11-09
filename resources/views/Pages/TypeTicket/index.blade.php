@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
    @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ticket Type</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Ticket Type</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#Ticket-Type">
                                    ADD Type
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="Ticket-Type" tabindex="-1" aria-labelledby="sourceModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Adding Ticket Type
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data=Type-Ticket') }}" method="post" id="store-ticket-type">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="Office Type" class="form-label">Type
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="type_ticket_name" id="type-ticket-name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success btn-store-ticket-type">Save</button>
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
                                    @foreach ($type_tic as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->type_name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#mdl-part-ktgr{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="mdl-part-ktgr{{ $no }}" tabindex="-1"
                                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sourceModalLabel">Edit Ticket Type
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url("update/$item->id/data=Type-Ticket") }}"
                                                                    method="post" id="edit-ticket-type-form{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="source_name"
                                                                                    class="form-label">Type Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edt_ticket_type_name"
                                                                                    value="{{ $item->type_name }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success edit-mdl-ticket-type{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <form action="{{ url("remove/$item->id/data=Type-Ticket") }}" method="post"
                                                    id="form-remove-type-ticket{{ $no }}" style="display: none;">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                </form>
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm btn-remove-type-ticket{{ $no }}">
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
    $('.btn-store-ticket-type').on('click', function () {
        Swal.fire({
            title: "Continue store type office?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#store-ticket-type').submit();
            }
        });
        return false;
    });
    
    for (let i = 0; i < 50; i++) {
        $('.edit-mdl-ticket-type' + i + '').on('click', function () {
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
                    jQuery('#edit-ticket-type-form' + i + '').submit();
                }
            });

            return false;
        });
        $('.btn-remove-type-ticket' + i + '').on('click', function () {
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
                    jQuery('#form-remove-type-ticket' + i + '').submit();
                }
            });

            return false;
        });
    }
</script>
@endpush
