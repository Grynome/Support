@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.css">
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload Docs</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <h6 class="card-title">Documents</h6>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Case ID</th>
                                        <th>SN</th>
                                        <th>Project</th>
                                        <th></th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($docs as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->sn }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td><input type="file" class="myDropify" /></td>
                                            <td>
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <button type="button" class="btn btn-inverse-info btn-icon btn-sm btn-receive-docs"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" 
                                                        title="Download Receipt" data-id-rcv="{{ $no }}">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    <form action="{{ url("Update-Ticket/Docs/$item->notiket")}}" method="post"
                                                        id="fm-receive-docs-{{ $no }}">
                                                        @csrf
                                                    </form>
                                                    &nbsp;
                                                    <button type="button" class="btn btn-inverse-warning btn-icon btn-sm">
                                                        <i data-feather="delete"></i>
                                                    </button>
                                                </div>
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
    <script src="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/dropify.js"></script>
@endpush
@push('custom')
<script>
    $('.btn-dstr-reqs-en').each(function(index) {
        $(this).on('click', function() {
            var formId = $(this).data('form-id');
            var form = $('#fm-dstr-reqs-en-' + formId);

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
                    form.submit();
                }
            });
            return false;
        });
    });
</script>
@endpush
