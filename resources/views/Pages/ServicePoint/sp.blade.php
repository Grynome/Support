@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Service Point</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Service Point Data</h6>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="{{ url('Form/data=ServicePoint') }}">
                                    <button type="button" class="btn btn-inverse-primary btn-icon-text">
                                        ADD Data
                                        <i class="btn-icon-append" data-feather="plus"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Service Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Head</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($sp as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->service_name }}</td>
                                            <td class="adds"
                                                style="text-align: center !important; vertical-align: middle; white-space: wrap;">
                                                {{ $item->alamat }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->head }}</td>
                                            @if ($item->status == 1)
                                                <td>Active</td>
                                            @else
                                                <td>Non Active</td>
                                            @endif
                                            <td>
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        <a href="{{ url("Form/$item->service_id/Edit=ServicePoint") }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                        </a>
                                                        &nbsp;
                                                        <button type="button"
                                                            class="btn btn-inverse-warning btn-icon btn-sm delete-sp{{ $no }}">
                                                            <i data-feather="delete"></i>
                                                        </button>
                                                        <form
                                                            action="{{ url("deleted/$item->service_id/data=ServicePoint") }}"
                                                            method="post" id="disappear-sp{{ $no }}">
                                                            @csrf
                                                            {{ method_field('patch') }}
                                                        </form>
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
            $('.delete-sp' + i + '').on('click', function() {
                Swal.fire({
                    title: "Remove this Item?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Sure!',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#disappear-sp' + i + '').submit();
                    }
                });
                return false;
            });
        }
    </script>
@endpush
