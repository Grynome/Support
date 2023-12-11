@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
    @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Manage Ticket</li>
                <li class="breadcrumb-item active" aria-current="page">Closed</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <h6 class="card-title">Ticket Canceled</h6>
                            </div>
                            <div class="col-md-3">
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
                                            <form action="{{ route('sorting.closed') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                        <div class="row">
                                                            <label class="form-label">Cancel Date</label>
                                                            <div class="col-md-5">
                                                                <div class="mb-3">
                                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select Date" name="stCC_date"
                                                                            id="st-date-mt" value="{{$st_dt_cl}}"
                                                                            data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-center">
                                                                <label class="form-label">s/d</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="mb-3">
                                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select Date"
                                                                            value="{{$nd_dt_cl}}" name="ndCC_date"
                                                                            id="nd-date-mt" data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info">Sort</button>
                                                </div>
                                            </form>
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
                                        <th>No Tiket</th>
                                        <th>Case ID</th>
                                        <th>Company</th>
                                        <th>SN</th>
                                        <th>Entry Date</th>
                                        <th>Closed</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($ticket_canceled as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->company }}</td>
                                            <td>{{ $item->sn }}</td>
                                            <td>{{ $item->entrydate }}</td>
                                            <td>{{ $item->closedate }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>
                                                {{ $item->status }}
                                            </td>
                                            <td>
                                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        @if ($depart == 4 && $role == 19)
                                                            <form
                                                                action="{{ url("Return/Ticket/$item->notiket") }}"
                                                                id="form-return-cancel{{ $no }}"
                                                                method="post">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                            <button type="button"
                                                                class="btn btn-inverse-secondary btn-icon btn-sm btn-return-cancel{{ $no }}">
                                                                <i data-feather="rotate-cw"></i>
                                                            </button>
                                                            &nbsp;
                                                        @endif
                                                        <a href="{{ url("Detail/Ticket=$item->notiket") }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-success btn-icon btn-sm ">
                                                                <i data-feather="search"></i>
                                                            </button>
                                                        </a>
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
@if ($depart == 4 && $role == 19)
<script>
    for (let i = 0; i < 10000; i++) {
        $('.btn-return-cancel' + i + '').on('click', function() {
            Swal.fire({
                title: 'Are u sure return this Ticket?',
                text: 'Ticket will be Open again!!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#form-return-cancel' + i + '').submit();
                }
            });
            return false;
        });
    }
</script>
@endif
@endpush
