@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="card-title">User's Data</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#filter-ticket">
                                    Filter
                                    <i class="btn-icon-append" data-feather="search"></i>
                                </button>
                                <div class="modal fade" id="filter-ticket" tabindex="-1" aria-labelledby="sourceModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Filter
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <form action="{{ route('sorting.user') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="stats_user">
                                                                    <option value="">- Choose -</option>
                                                                    <option value="1" {{ $sts_verify == 1 ? 'selected' : '' }}>Verified</option>
                                                                    <option value="2" {{ $sts_verify == 2 ? 'selected' : '' }}>Not Verified</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info sort">Sort</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Work Type</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            @if ($item->gender == 'L')
                                                <td>Laki - laki</td>
                                            @else
                                                <td>Perempuan</td>
                                            @endif
                                            <td>{{ @$item->roles->role }}</td>
                                            <td>{{ @$item->dept->department }}</td>
                                            @if ($item->work_type == 1)
                                                <td>Freelance</td>
                                            @else
                                                <td>Karyawan</td>
                                            @endif
                                            <td>
                                                @if ($item->verify == 0)
                                                    Not Verified
                                                @elseif ($item->verify == 2)
                                                    Deactivated
                                                @else
                                                    Verified
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        @php
                                                            $user_id = $item->nik;
                                                        @endphp
                                                        @if ($item->verify != 1 )
                                                            <form action="{{ url("Update/$user_id/User-HGT") }}" method="post"
                                                                id="form_edit_user{{ $no }}">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm edit-user{{ $no }}">
                                                                <i data-feather="user-check"></i>
                                                            </button>
                                                            &nbsp;
                                                        @else
                                                            <form action="{{ url("Deactivated/$user_id/User-HGT") }}" method="post"
                                                                id="fm-deactivated-user{{ $no }}">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                            <button type="button"
                                                                class="btn btn-inverse-warning btn-icon btn-sm deactivated-user{{ $no }}">
                                                                <i data-feather="delete"></i>
                                                            </button>
                                                        @endif
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
@push('custom')
<script>
    for (let i = 0; i < 999; i++) {
        $('.edit-user' + i + '').on('click', function () {
            Swal.fire({
                title: "Verify this Account?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Verify',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#form_edit_user' + i + '').submit();
                }
            });
            return false;
        });
        $('.deactivated-user' + i + '').on('click', function () {
            Swal.fire({
                title: "Deactivated this account?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    jQuery('#fm-deactivated-user' + i + '').submit();
                }
            });
            return false;
        });
    }
</script>
@endpush
