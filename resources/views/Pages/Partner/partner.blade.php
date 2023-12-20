@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Partner</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h6 class="card-title">Partner Data</h6>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ url('Form/Partner') }}">
                                    <button type="button" class="btn btn-inverse-primary btn-icon-text">
                                        ADD Partner
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
                                        <th>Partner</th>
                                        <th>Contact Person</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($partner as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->partner }}</td>
                                            <td>{{ $item->contact_person }}</td>
                                            <td>{{ $item->telp }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        <a href="{{ url("Form=edit/$item->partner_id/Partner") }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                        </a>
                                                        &nbsp;
                                                        <button type="button"
                                                            class="btn btn-inverse-warning btn-icon btn-sm destroy-ptn{{ $no }}">
                                                            <i data-feather="delete"></i>
                                                        </button>
                                                        <form action="{{ url("delete/$item->partner_id/data=Partner") }}"
                                                            method="post" id="remove-ptn{{ $no }}">
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
    $('.destroy-ptn' + i + '').on('click', function () {

        Swal.fire({
            title: "Are u sure to delete this item?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                jQuery('#remove-ptn' + i + '').submit();
            }
        });
        return false;
    });
}
</script>
@endpush
