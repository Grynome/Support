@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Project</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Project Data</h6>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="{{ url('Form-Add/data=Project') }}">
                                    <button type="button" class="btn btn-inverse-primary btn-icon-text">
                                        ADD Project
                                        <i class="btn-icon-append" data-feather="plus"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Project Name</th>
                                        <th rowspan="2">Owner Name</th>
                                        <th rowspan="2">Contact Person</th>
                                        <th rowspan="2">Description</th>
                                        <th rowspan="2">Project Mail</th>
                                        <th rowspan="2">Phone</th>
                                        <th colspan="2">Project</th>
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2">Option</th>
                                    </tr>
                                    <tr>
                                        <th>Begin</th>
                                        <th>End</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($project as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->go_partner->partner }}</td>
                                            <td>{{ $item->contact_person }}</td>
                                            <td>{{ $item->desc }}</td>
                                            <td>{{ $item->mail_project }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->startdate }}</td>
                                            <td>{{ $item->enddate }}</td>
                                            @if ($item->status == 1)
                                                <td>Active</td>
                                            @else
                                                <td>Inactive</td>
                                            @endif
                                            <td>
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        <a href="{{ url("Edit/data=Project/$item->project_id") }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                        </a>
                                                        &nbsp;
                                                        <button type="button"
                                                            class="btn btn-inverse-warning btn-icon btn-sm remove-prj{{ $no }}">
                                                            <i data-feather="delete"></i>
                                                            <form action="{{ url("Remove/$item->id/Project") }}"
                                                                method="post" id="remove-prj{{ $no }}">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                        </button>
                                                    </div>
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
@endpush
@push('custom-plug')
@endpush
@push('custom')
    <script>
        for (let i = 0; i < 50; i++) {
            $('.remove-prj' + i + '').on('click', function() {

                Swal.fire({
                    title: "Are u Sure to delete this Item?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Save'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        jQuery('#remove-prj' + i + '').submit();
                    }
                });
                return false;
            });
        }
    </script>
@endpush
